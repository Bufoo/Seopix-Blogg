<x-app-layout>
    <x-slot name="header">
        @if(session('success'))
            <p>{{ session('success') }}</p>
        @endif

        <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data"
            onsubmit="tinymce.triggerSave();" novalidate>
            @csrf
            
            <div class="mb-3">
                <label for="cover_img">Kapak Görseli:</label>
                <input type="file" id="cover_img" name="cover_img" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" for="caption">Başlık</span>
                <input type="text" class="form-control" id="caption" name="caption" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" for="cover_text">Kapak Metni</span>
                <input type="text" class="form-control" id="cover_text" name="cover_text" required>
            </div>
            <div class="mb-3">
                <label class="mb-2" for="content">İçerik:</label>
                <textarea id="content" name="content" required></textarea>
            </div>
            <div class="mb-3">
                <label class="mb-2" for="category_id">Kategori:</label>
                <select class="form-select" name="category_id" id="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" for="meta_title">Meta Başlık</span>
                <input type="text" class="form-control" id="meta_title" name="meta_title" required>
            </div>

            <!-- Meta Description -->
            <div class="mb-3">
                <label class="mb-2" for="meta_description">Meta Açıklama</label>
                <textarea class="form-control" id="meta_description" name="meta_description" rows="3"
                    required></textarea>
            </div>

            <!-- Canonical Link -->
            <div class="input-group mb-3">
                <span class="input-group-text" for="canonical_link">Canonical Bağlantı</span>
                <input type="url" class="form-control" id="canonical_link" name="canonical_link" required>
            </div>
            <div class="d-flex justify-content-end mb-4">
                <button class="btn btn-outline-success" type="submit">Oluştur</button>
            </div>
        </form>
    </x-slot>
</x-app-layout>