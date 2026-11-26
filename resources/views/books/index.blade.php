<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Data Buku</h2>
    </x-slot>


    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('books.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+ Tambah Buku Baru</a>


                <form action="{{ route('books.index') }}" method="GET" style="display: flex; gap: 8px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, kategori..." style="border: 1px solid #d1d5db; padding: 6px 12px; border-radius: 4px;">
                    <button type="submit" style="background-color: #16a34a; color: white; padding: 6px 14px; border-radius: 4px; cursor: pointer;">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('books.index') }}" style="background-color: #6b7280; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center;">Reset</a>
                    @endif
                </form>
            </div>


            @if(session('success'))
                <div class="p-3 mb-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif


            <table border="1" cellpadding="8" cellspacing="0" class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Judul Buku</th>
                        <th class="border p-2">Kategori</th>
                        <th class="border p-2">Penulis</th>
                        <th class="border p-2">Tahun</th>
                        <th class="border p-2">Stok</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = $books->firstItem() ?? 1; @endphp
                    @forelse($books as $b)
                    <tr>
                        <td class="border p-2">{{ $no++ }}</td>
                        <td class="border p-2"><strong>{{ $b->title }}</strong></td>
                        <td class="border p-2">{{ $b->category->name ?? '-' }}</td>
                        <td class="border p-2">{{ $b->author }}</td>
                        <td class="border p-2">{{ $b->year }}</td>
                        <td class="border p-2"><strong>{{ $b->stock }}</strong></td>
                        <td class="border p-2">
                            <a href="{{ route('books.show', $b->id) }}" class="text-green-600 mr-2">Detail</a>
                            <a href="{{ route('books.edit', $b->id) }}" class="text-blue-600 mr-2">Edit</a>
                            <form action="{{ route('books.destroy', $b->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="border p-4 text-center text-gray-500">
                            {{ request('search') ? 'Buku dengan kata kunci "' . request('search') . '" tidak ditemukan.' : 'Belum ada data buku. Silakan tambah data baru.' }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $books->links() }}</div>
        </div>
    </div>
</x-app-layout>
