@php
    \Carbon\Carbon::setLocale('tr');
@endphp
<x-app-layout>
    <x-slot name="header">

        @if ($blogs->isEmpty())
            <p>Henüz içerik eklenmemiş.</p>
        @else
            <h2 class="mb-3">İçerikler:</h2>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Başlık</th>
                        <th scope="col">Güncelleme</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $blog)
                        <tr>
                            <th scope="row">{{ $blog->id }}</th>
                            <td>
                                @foreach ($categories as $category)
                                    @if ($category->id == $blog->category_id)
                                        {{ $category->name }}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $blog->caption }}</td>
                            <td>
                                @if ($blog->updated_at->year == now()->year)
                                    {{ $blog->updated_at->translatedFormat('d M H:i') }}
                                @else
                                    {{ $blog->updated_at->format('d.m.Y H:i') }}
                                @endif
                            </td>
                            <td>
                                <span class="badge text-bg-primary">
                                    <!-- Görüntüle Butonu -->
                                    <a href="{{ route('blog.show', $blog->id) }}" target="_blank">Görüntüle</a>
                                </span>
                                <span class="badge text-bg-warning ml-4">
                                    <!-- Güncelle Butonu -->
                                    <a href="{{ route('blog.edit', $blog->id) }}">Güncelle</a>
                                </span>
                                <span class="badge text-bg-danger">
                                    <form action="{{ route('blog.destroy', $blog->id) }}" method="POST"
                                        onsubmit="return confirm('Bu blogu silmek istediğinize emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Sil</button>
                                    </form>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </x-slot>
</x-app-layout>