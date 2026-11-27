<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Anggota</h2>
    </x-slot>


    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg max-w-lg space-y-3">
            <p><strong>Kode Member:</strong> <code>{{ $member->member_code }}</code></p>
            <p><strong>Nama Anggota:</strong> {{ $member->name }}</p>


            <div class="pt-4">
                <a href="{{ route('members.index') }}" style="background-color: #6b7280; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block;">Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>
