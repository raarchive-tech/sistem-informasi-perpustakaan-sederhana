<x-app-layout>
    <x-slot name="header">
        <h2>Kelola Data Peminjaman</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-2xl">

            <div class="flex flex-wrap justify-between items-center gap-4 mb-6">

                <a href="{{ route('borrowings.create') }}"
                   class="inline-flex items-center px-6 py-3 rounded-xl text-white font-bold shadow-lg transition hover:opacity-90"
                   style="background: #9286d2;">
                    + Tambah Peminjaman Baru
                </a>

                <form action="{{ route('borrowings.index') }}"
                      method="GET"
                      class="flex flex-wrap gap-3">

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari member, petugas, status..."
                           class="px-4 py-3 rounded-xl border border-purple-100 focus:ring-2 focus:ring-purple-200"
                           style="min-width: 250px; background: #faf9ff;">

                    <button type="submit"
                            class="px-6 py-3 rounded-xl font-bold text-white"
                            style="background: #9ebfe0;">
                        Cari
                    </button>

                    @if(request('search'))
                        <a href="{{ route('borrowings.index') }}"
                           class="px-5 py-3 rounded-xl font-bold text-gray-600"
                           style="background: #eeeeF7;">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Notifikasi hanya muncul jika ada pesan --}}
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
                            <th class="p-4 text-left">MEMBER</th>
                            <th class="p-4 text-left">PETUGAS</th>
                            <th class="p-4 text-left">TGL PINJAM</th>
                            <th class="p-4 text-left">TGL DUE (TENGGAT)</th>
                            <th class="p-4 text-left">TGL KEMBALI</th>
                            <th class="p-4 text-left">STATUS</th>
                            <th class="p-4 text-left rounded-tr-xl">AKSI</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $no = $borrowings->firstItem() ?? 1; @endphp

                        @forelse($borrowings as $b)
                            <tr class="border-b border-gray-100 hover:bg-purple-50 transition">

                                <td class="p-5 text-gray-500">{{ $no++ }}</td>

                                <td class="p-5 font-semibold text-gray-700">
                                    {{ $b->member->name ?? '-' }}
                                </td>

                                <td class="p-5 text-gray-600">
                                    {{ $b->user->name ?? '-' }}
                                </td>

                                <td class="p-5 text-gray-600">
                                    {{ $b->borrow_date }}
                                </td>

                                <td class="p-5 text-gray-600">
                                    {{ $b->due_date }}
                                </td>

                                <td class="p-5 text-gray-600">
                                    {{ $b->return_date ?? '-' }}
                                </td>

                                <td class="p-5">
                                    @if($b->status === 'borrowed')
                                        <span class="px-3 py-2 rounded-full text-xs font-bold"
                                              style="background: #fff0d9; color: #c28a35;">
                                            DIPINJAM
                                        </span>
                                    @else
                                        <span class="px-3 py-2 rounded-full text-xs font-bold"
                                              style="background: #e3f7ed; color: #38966a;">
                                            SELESAI
                                        </span>
                                    @endif
                                </td>

                                <td class="p-5">
                                    <div class="flex flex-wrap items-center gap-2">

                                        <a href="{{ route('borrowings.show', $b->id) }}"
                                           class="px-4 py-2 rounded-lg font-semibold text-blue-600"
                                           style="background: #e9efff;">
                                            Detail
                                        </a>

                                        @if($b->status === 'borrowed')
                                            <form action="{{ route('borrowings.return', $b->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Kembalikan buku ini?')">
                                                @csrf

                                                <button type="submit"
                                                        class="px-4 py-2 rounded-lg font-semibold text-green-700"
                                                        style="background: #e3f7ed;">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-sm">
                                                Selesai
                                            </span>
                                        @endif

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-400">
                                    {{ request('search')
                                        ? 'Transaksi peminjaman dengan kata kunci "' . request('search') . '" tidak ditemukan.'
                                        : 'Belum ada transaksi peminjaman.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $borrowings->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
