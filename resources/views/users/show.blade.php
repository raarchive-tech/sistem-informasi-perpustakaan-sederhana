<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail User</h2>
    </x-slot>


    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg max-w-lg space-y-3">
            <p><strong>Nama Pengguna:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> <strong>{{ strtoupper($user->role) }}</strong></p>
            <p><strong>Akun Dibuat:</strong> {{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}</p>


            <div class="flex space-x-2 pt-4">
                <a href="{{ route('users.edit', $user->id) }}" style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block; font-weight: 500;">
                    Edit User
                </a>
                <a href="{{ route('users.index') }}" style="background-color: #6b7280; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block;">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
