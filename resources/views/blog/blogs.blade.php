<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bloglar
        </h2>
    </x-slot>
    <div class="container py-8 mt-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($blogs as $blog)
                <div class="col">
                    <div class="card">
                        <a href="{{ route('blog.blog-details', $blog->id) }}">
                            <div class="d-flex justify-content-center">
                                <img class="card-img-top" src="{{ asset('storage/' . $blog->cover_img) }}"
                                    alt="{{ $blog->caption }}" style="width: 400; height: 400; object-fit: cover;">
                            </div>
                        </a>
                        <div class="card-body">
                            <p class="card-text text-muted mb-2">{{ $blog->category->name }}</p>
                            <p class="card-title fs-3 fw-bold mb-4">{{ $blog->caption }}</p>
                            <p class="card-text multi-line-ellipsis mb-3">
                                {{ \Illuminate\Support\Str::limit($blog->cover_text, 100, '...') }}</p>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/' . $blog->user->image) }}" alt="{{ $blog->user->name }}"
                                    class="avatar rounded-circle me-3" width="50" height="50">
                                <p class="card-text text-secondary">{{ $blog->user->name }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $blogs->links() }} <!-- Sayfalama için -->
        </div>
    </div>
</x-app-layout>