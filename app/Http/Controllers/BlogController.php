<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::all();
        foreach ($blogs as $blog) {
            $blog->updated_at = Carbon::parse($blog->updated_at)->timezone('Europe/Istanbul');
        }
        $blogs = Blog::with('user')->get();
        $categories = Category::all();
        return view('blog.index', compact('blogs', 'categories'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('blog.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required|string',
            'cover_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover_text' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'canonical_link' => 'nullable|url',
        ]);

        // Görseli yükle ve yolunu al
        if ($request->hasFile('cover_img')) {
            $imagePath = $request->file('cover_img')->store('blog-images', 'public');
        }

        $blog = Blog::create([
            'caption' => $request->caption,
            'cover_img' => $imagePath,  // Görsel yolunu veritabanına kaydet
            'cover_text' => $request->cover_text,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'canonical_link' => $request->canonical_link,
        ]);

        $blog->save();

        return redirect()->route('blog.create')->with('success', 'İçerik başarıyla oluşturuldu.');
    }
    public function blogs()
    {
        $blogs = Blog::with('category')->paginate(6);  // Her sayfada 6 blog gösteriliyor
        return view('blog.blogs', compact('blogs'));
    }

    public function show($id)
    {
        $blog = Blog::with('category')->findOrFail($id);
        $content = $blog->content; // İçeriği veritabanından al
        $tahminiSure = $this->tahminiOkunmaSuresi($content);
        return view('blog.blog-details', compact('blog', 'tahminiSure'));
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = Category::all();
        return view('blog.edit', compact('blog', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'caption' => 'required|string',
            'cover_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover_text' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'canonical_link' => 'nullable|url',
        ]);

        $blog = Blog::findOrFail($id);

        // Görsel güncellenmişse yükle
        if ($request->hasFile('cover_img')) {
            $imagePath = $request->file('cover_img')->store('blog-images', 'public');
            $blog->cover_img = $imagePath; // Yeni görsel yolunu güncelle
        }

        $blog->update([
            'caption' => $request->caption,
            'cover_text' => $request->cover_text,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'canonical_link' => $request->canonical_link,
        ]);

        return redirect()->route('blog.index')->with('success', 'İçerik başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('blog.index')->with('success', 'İçerik başarıyla silindi.');
    }
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $blogId = $request->get('blog_id'); // Blog ID'sini göndererek hangi blog için olduğunu belirleyebilirsin
        $directory = 'blog-images/blog-' . $blogId;

        // Görseli kaydet
        $path = $request->file('file')->store($directory, 'public');

        return response()->json(['location' => "/storage/{$path}"]);
    }

    private function tahminiOkunmaSuresi($content)
{
    $plainTextContent = strip_tags($content);
    $wordCount = str_word_count($plainTextContent);
    $averageReadingSpeed = 200;
    $readingTime = ceil($wordCount / $averageReadingSpeed);

    return $readingTime;
}
}
