<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Data User</h2>
    </x-slot>


    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('users.create') }}" style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block;">
                    + Tambah User Baru
                </a>
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
                        <th class="border p-2">Nama</th>
                        <th class="border p-2">Email</th>
                        <th class="border p-2">Role</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = $users->firstItem() ?? 1; @endphp
                    @forelse($users as $u)
                    <tr>
                        <td class="border p-2">{{ $no++ }}</td>
                        <td class="border p-2"><strong>{{ $u->name }}</strong></td>
                        <td class="border p-2">{{ $u->email }}</td>
                        <td class="border p-2"><strong>{{ strtoupper($u->role) }}</strong></td>
                        <td class="border p-2">
                            <a href="{{ route('users.edit', $u->id) }}" style="color: #2563eb; text-decoration: underline; margin-right: 8px;">Edit</a>
                            @if($u->id !== auth()->id())
                                <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: #dc2626; text-decoration: underline; background: none; border: none; cursor: pointer;">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="border p-4 text-center text-gray-500">Belum ada user.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>
