<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            Category::create([
                'name' => $request->name,
            ]);

            return redirect()->route('categories.index')->with('success', 'Kategori başarıyla oluşturuldu.');
        }

        if ($request->isMethod('delete')) {
            $id = $request->id;
            $category = Category::findOrFail($id);
            $category->delete();

            return redirect()->route('categories.index')->with('success', 'Kategori başarıyla silindi.');
        }

        $categories = Category::all();
        foreach ($categories as $category) {
            $category->updated_at = Carbon::parse($category->updated_at)->timezone('Europe/Istanbul');
        }
        return view('categories.index', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return response()->json(['success' => 'Kategori başarıyla güncellendi.']);
    }
}
