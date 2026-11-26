<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Buku
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg max-w-lg">

            {{-- Pesan Error --}}
            @if($errors->any())
                <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                    <strong style="display: block; margin-bottom: 6px;">Terjadi kesalahan:</strong>

                    <ul style="padding-left: 20px; list-style-type: disc;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Edit Buku --}}
            <form
                action="{{ route('books.update', $book->id) }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-4"
            >
                @csrf
                @method('PUT')

                {{-- Cover Buku --}}
                <div>
                    <label class="block font-medium text-gray-700">
                        Cover Buku:
                    </label>

                    <div style="margin-top: 10px; padding: 18px; border: 2px dashed #dcd8ed; border-radius: 13px; background: #faf9ff; text-align: center;">

                        {{-- Cover Lama --}}
                        <div id="coverPlaceholder" style="margin-bottom: 12px;">
                            @if($book->cover)
                                <img
                                    src="{{ asset('storage/' . $book->cover) }}"
                                    alt="Cover {{ $book->title }}"
                                    style="max-width: 160px; max-height: 220px; margin: 0 auto 12px; border-radius: 8px; object-fit: contain; box-shadow: 0 5px 15px rgba(0,0,0,.12);"
                                >

                                <p style="color: #9692b4; font-size: 12px;">
                                    Cover yang sedang digunakan
                                </p>
                            @else
                                <div style="font-size: 38px; color: #aaa5df;">▧</div>

                                <p style="margin-top: 5px; color: #9692b4; font-size: 12px;">
                                    Buku ini belum memiliki cover
                                </p>
                            @endif
                        </div>

                        {{-- Pratinjau Cover Baru --}}
                        <img
                            id="coverPreview"
                            src=""
                            alt="Pratinjau Cover Baru"
                            style="display: none; max-width: 160px; max-height: 220px; margin: 0 auto 12px; border-radius: 8px; object-fit: contain; box-shadow: 0 5px 15px rgba(0,0,0,.12);"
                        >

                        <p style="margin-bottom: 10px; color: #77738f; font-size: 11px;">
                            Pilih gambar baru jika ingin mengganti cover
                        </p>

                        <input
                            type="file"
                            name="cover"
                            id="cover"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            style="display: block; width: 100%; font-size: 12px; color: #77738f;"
                        >
                    </div>

                    <p style="margin-top: 6px; color: #aaa7bb; font-size: 10px;">
                        Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                        Kosongkan jika tidak ingin mengganti cover.
                    </p>

                    @error('cover')
                        <span style="display: block; margin-top: 6px; color: #dc2626; font-size: 12px;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block font-medium text-gray-700">
                        Kategori:
                    </label>

                    <select name="category_id" class="w-full border rounded p-2 mt-1" required>
                        @foreach($categories as $cat)
                            <option
                                value="{{ $cat->id }}"
                                {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}
                            >
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Judul Buku --}}
                <div>
                    <label class="block font-medium text-gray-700">
                        Judul Buku:
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $book->title) }}"
                        class="w-full border rounded p-2 mt-1"
                        required
                    >

                    @error('title')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Penulis --}}
                <div>
                    <label class="block font-medium text-gray-700">
                        Penulis:
                    </label>

                    <input
                        type="text"
                        name="author"
                        value="{{ old('author', $book->author) }}"
                        class="w-full border rounded p-2 mt-1"
                        required
                    >

                    @error('author')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tahun Terbit --}}
                <div>
                    <label class="block font-medium text-gray-700">
                        Tahun Terbit (1900 - 2026):
                    </label>

                    <input
                        type="number"
                        name="year"
                        value="{{ old('year', $book->year) }}"
                        min="1900"
                        max="2026"
                        class="w-full border rounded p-2 mt-1"
                        required
                    >

                    @error('year')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Stok --}}
                <div>
                    <label class="block font-medium text-gray-700">
                        Jumlah Stok (Minimal 1):
                    </label>

                    <input
                        type="number"
                        name="stock"
                        value="{{ old('stock', $book->stock) }}"
                        min="1"
                        oninput="if(this.value < 1 && this.value !== '') this.value = 1;"
                        class="w-full border rounded p-2 mt-1"
                        required
                    >

                    @error('stock')
                        <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex space-x-2 pt-2">
                    <button
                        type="submit"
                        style="background-color: #918bcf; color: white; padding: 10px 18px; border-radius: 9px; cursor: pointer; border: none; font-weight: 700;"
                    >
                        Update Buku
                    </button>

                    <a
                        href="{{ route('books.index') }}"
                        style="background-color: #f0eff7; color: #77738f; padding: 10px 18px; border-radius: 9px; text-decoration: none; font-weight: 700;"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Pratinjau Cover Baru --}}
    <script>
        document.getElementById('cover').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('coverPreview');
            const placeholder = document.getElementById('coverPlaceholder');

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            } else {
                preview.src = '';
                preview.style.display = 'none';
                placeholder.style.display = 'block';
            }
        });
    </script>
</x-app-layout>