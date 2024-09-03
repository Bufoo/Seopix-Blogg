<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->except('image');

        // Fotoğraf güncellenmiş mi kontrol et
        if ($request->hasFile('image')) {
            // Mevcut resmi sil
            if ($user->image && Storage::exists('public/' . $user->image)) {
                Storage::delete('public/' . $user->image);
            }

            // Yeni resmi yükle
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath; // Veritabanına tam yolu kaydet
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Profil fotoğrafını sil
        if ($user->image && Storage::exists('public/' . $user->image)) {
            Storage::delete('public/' . $user->image);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function deletePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => ['required', 'string'],
        ]);

        $user = $request->user();
        $photoPath = $request->input('photo');

        // Profil fotoğrafını sil
        if ($photoPath && Storage::exists('public/' . $photoPath)) {
            Storage::delete('public/' . $photoPath);
        }

        // Kullanıcının fotoğraf bilgisini güncelle
        $user->image = null;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'photo-deleted');
    }

}
