@php
    \Carbon\Carbon::setLocale('tr');
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kategoriler') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <p>{{ session('success') }}</p>
                    @endif

                    <!-- Kategori Ekleme Formu -->
                    <form class="py-6" action="{{ route('categories.index') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" for="name">Kategori</span>
                            <input type="text" class="form-control" name="name" id="name">
                            <button type="submit" class="btn btn-outline-success">Ekle</button>
                        </div>
                    </form>

                    <!-- Kategori Listeleme -->
                    @if ($categories->isEmpty())
                        <p>Henüz kategori eklenmemiş.</p>
                    @else
                        <h2 class="mb-3">Mevcut Kategoriler:</h2>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Güncelleme</th>
                                    <th scope="col">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <th scope="row">{{ $category->id }}</th>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->updated_at->year == now()->year)
                                            {{ $category->updated_at->translatedFormat('d M H:i') }}
                                        @else
                                            {{ $category->updated_at->format('d.m.Y H:i') }}
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-warning"
                                            onclick="openEditModal({{ $category->id }}, '{{ $category->name }}')">Düzenle</button>
                                        <form action="{{ route('categories.index', ['category' => $category->id]) }}"
                                            method="POST" style="display:inline;" onsubmit="confirmDeletion(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Sil</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Kategori Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editCategoryId">
                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Kategori Adı:</label>
                            <input type="text" id="editCategoryName" name="name" required class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                            <button type="submit" class="btn btn-success">Güncelle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var editCategoryModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));

    function openEditModal(id, name) {
        $('#editCategoryId').val(id);
        $('#editCategoryName').val(name);
        editCategoryModal.show();
    }

    function closeEditModal() {
        editCategoryModal.hide();
    }

    $(document).ready(function () {
        $('#editCategoryForm').on('submit', function (e) {
            e.preventDefault();

            var categoryId = $('#editCategoryId').val();
            var formData = {
                _token: $('input[name=_token]').val(),
                _method: 'PUT',
                name: $('#editCategoryName').val(),
            };

            $.ajax({
                url: '/categories/' + categoryId,
                type: 'POST',
                data: formData,
                success: function (response) {
                    alert(response.success);
                    closeEditModal();
                    location.reload();
                },
                error: function (response) {
                    alert('Kategori güncellenirken bir hata oluştu.');
                }
            });
        });
    });
</script>
