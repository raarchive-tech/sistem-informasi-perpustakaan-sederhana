<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Data Anggota (Member)</h2>
    </x-slot>


    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('members.create') }}" style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block;">
                    + Tambah Anggota Baru
                </a>


                <form action="{{ route('members.index') }}" method="GET" style="display: flex; gap: 8px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama anggota..." style="border: 1px solid #d1d5db; padding: 6px 12px; border-radius: 4px;">
                    <button type="submit" style="background-color: #16a34a; color: white; padding: 6px 14px; border-radius: 4px; cursor: pointer;">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('members.index') }}" style="background-color: #6b7280; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center;">Reset</a>
                    @endif
                </form>
            </div>


            @if(session('success'))
                <div class="p-3 mb-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="p-3 mb-4 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
            @endif


            <table border="1" cellpadding="8" cellspacing="0" class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Kode Member</th>
                        <th class="border p-2">Nama Anggota</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = $members->firstItem() ?? 1; @endphp
                    @forelse($members as $m)
                    <tr>
                        <td class="border p-2">{{ $no++ }}</td>
                        <td class="border p-2"><code>{{ $m->member_code }}</code></td>
                        <td class="border p-2"><strong>{{ $m->name }}</strong></td>
                        <td class="border p-2">
                            <a href="{{ route('members.show', $m->id) }}" style="color: #16a34a; text-decoration: underline; margin-right: 8px;">Detail</a>
                            <a href="{{ route('members.edit', $m->id) }}" style="color: #2563eb; text-decoration: underline; margin-right: 8px;">Edit</a>
                            <form action="{{ route('members.destroy', $m->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus anggota ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #dc2626; text-decoration: underline; background: none; border: none; cursor: pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="border p-4 text-center text-gray-500">
                            {{ request('search') ? 'Anggota dengan kata kunci "' . request('search') . '" tidak ditemukan.' : 'Belum ada anggota.' }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $members->links() }}</div>
        </div>
    </div>
</x-app-layout>
