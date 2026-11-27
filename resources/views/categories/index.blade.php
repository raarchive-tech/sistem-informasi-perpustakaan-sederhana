<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ auth()->user()->role === 'admin' ? 'Kelola Kategori Buku' : 'Daftar Kategori Buku' }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-2xl">

            @if(auth()->user()->role === 'admin')
                <div class="mb-6">
                    <a href="{{ route('categories.create') }}"
                       class="inline-flex items-center px-6 py-3 rounded-xl text-white font-bold shadow-lg transition hover:opacity-90"
                       style="background: #9286d2;">
                        + Tambah Kategori
                    </a>
                </div>
            @endif

            @if(session('success'))
                <div class="p-4 mb-5 rounded-xl text-green-700 bg-green-50 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-5 rounded-xl text-red-700 bg-red-50 border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr style="background: #f0effb; color: #7775a8;">
                            <th class="p-4 text-left rounded-tl-xl">NO</th>
                            <th class="p-4 text-left">NAMA KATEGORI</th>
                            <th class="p-4 text-left">DESKRIPSI</th>

                            @if(auth()->user()->role === 'admin')
                                <th class="p-4 text-left rounded-tr-xl">AKSI</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @php $no = $categories->firstItem() ?? 1; @endphp

                        @forelse($categories as $c)
                            <tr class="border-b border-gray-100 hover:bg-purple-50 transition">
                                <td class="p-5 text-gray-500">{{ $no++ }}</td>

                                <td class="p-5 font-bold text-gray-700">
                                    {{ $c->name }}
                                </td>

                                <td class="p-5 text-gray-500">
                                    {{ $c->description ?? '-' }}
                                </td>

                                @if(auth()->user()->role === 'admin')
                                    <td class="p-5">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('categories.edit', $c->id) }}"
                                               class="px-4 py-2 rounded-lg font-semibold text-blue-600"
                                               style="background: #e9efff;">
                                                Edit
                                            </a>

                                            <form action="{{ route('categories.destroy', $c->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="px-4 py-2 rounded-lg font-semibold text-red-500"
                                                        style="background: #fdebef;">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'admin' ? 4 : 3 }}"
                                    class="p-8 text-center text-gray-400">
                                    Belum ada kategori buku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
