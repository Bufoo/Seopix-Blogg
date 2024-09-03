<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'about' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp'],
            'linkedin_url' => ['required', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'twitter_url' => ['nullable', 'url'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Görseli yükle ve yolunu al
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'about' => $request->about,
            'image' => $imagePath,  // Görsel yolunu veritabanına kaydet
            'linkedin_url' => $request->linkedin_url,
            'instagram_url' => $request->insgram_url,
            'twitter_url' => $request->twitter_url,
            'password' => Hash::make($request->password),
        ]);


        event(new Registered($user));

        return redirect(route('dashboard', absolute: false));
    }
}
