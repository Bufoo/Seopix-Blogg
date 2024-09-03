<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="{{ $blog->meta_description ? $blog->meta_description : $blog->cover_text }}">
    <title>{{ $blog->meta_title ? $blog->meta_title : $blog->caption }}</title>
    <link rel="canonical" href="{{ $blog->canonical_link ? $blog->canonical_link : ''}}">
    </link>
    <!-- Diğer meta etiketleri ve stil dosyaları -->
</head>
@php
    \Carbon\Carbon::setLocale('tr');
@endphp

<body>
    @yield('content')
    <x-app-layout>
        <x-slot name="header">
            <div class="d-flex justify-content-between">
                <p class="card-text text-muted mb-2">{{ $blog->category->name }}</p>
                <p class="mb-0 text-gray-600">{{ $blog->updated_at->format('d.m.Y') }}</p>
            </div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                {{ $blog->caption }}
            </h2>
            <p class="text-lg text-gray-800 mb-4">{{ $blog->cover_text }}</p>
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('storage/' . $blog->user->image) }}" alt="{{ $blog->user->name }}"
                        class="avatar rounded-circle me-3" width="50" height="50">
                    <p class="mb-0">{{ $blog->user->name }}</p>
                </div>
                <div class="d-flex flex-column align-items-center">

                    <p>{{ $tahminiSure }} dakikada okuyabilirsiniz</p>
                </div>
                </divc>

        </x-slot>

        <div class="container mt-4 py-1">
            <img class="d-block mx-auto img-fluid rounded mb-5" src="{{ asset('storage/' . $blog->cover_img) }}"
                alt="{{ $blog->caption }}" style="max-width: 900px; height: auto;">
            <div>
                <p class="text-gray-700 mt-4" id="blogContent">{!! $blog->content !!}</p>
            </div>
        </div>
    </x-app-layout>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var contentElement = document.getElementById('blogContent');
            var readingTimeElement = document.getElementById('readingTime');

            if (contentElement && readingTimeElement) {
                var content = contentElement.innerText || contentElement.textContent;
                var words = content.split(/\s+/).length;
                var readingSpeed = 160; // Ortalama okuma hızı (kelime/dakika)
                var minutes = Math.ceil(words / readingSpeed);

                readingTimeElement.textContent = 'Tahmini Okuma Süresi: ' + minutes + ' dakika';
            }
        });
    </script>
</body>

</html>