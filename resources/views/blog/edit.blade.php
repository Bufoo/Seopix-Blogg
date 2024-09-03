<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-3">
            Blog Düzenle
        </h2>
        @if(session('success'))
            <p>{{ session('success') }}</p>
        @endif


        <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                @if($blog->cover_img)
                    <div class="mb-2">
                        <p class="mb-2">Mevcut Kapak Görseli:</p>
                        <img src="{{ asset('storage/' . $blog->cover_img) }}" alt="Kapak Görseli" class="object-cover"
                            height="140" width="140">
                    </div>
                @endif
                <input type="file" name="cover_img">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" for="caption">Başlık</span>
                <input type="text" class="form-control" name="caption" value="{{ $blog->caption }}">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" for="cover_text">Kapak Yazısı</span>
                <input type="text" class="form-control" name="cover_text" value="{{ $blog->cover_text }}">
            </div>
            <div class="mb-3">
                <label class="mb-2" for="content">İçerik:</label>
                <textarea id="content" name="content" required>{{ $blog->content }}</textarea>
            </div>
            <div class="mb-3">
                <label class="mb-2" for="category_id">Kategori:</label>
                <select class="form-select" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $blog->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" for="meta_title">Meta Başlık</span>
                <input type="text" class="form-control" name="meta_title" value="{{ $blog->meta_title }}">
            </div>

            <!-- Meta Description -->
            <div class="mb-3">
                <label class="mb-2" for="meta_description">Meta Açıklama</label>
                <textarea class="form-control" name="meta_description" rows="3" required>{{ $blog->meta_description }}</textarea>
            </div>

            <!-- Canonical Link -->
            <div class="input-group mb-3">
                <span class="input-group-text" for="canonical_link">Canonical Bağlantı</span>
                <input type="url" class="form-control" name="canonical_link" value="{{ $blog->canonical_link }}">
            </div>

            <div class="d-flex justify-content-end mb-4">
                <button class="btn btn-outline-success" type="submit">Güncelle</button>
            </div>
        </form>
    </x-slot>
</x-app-layout>