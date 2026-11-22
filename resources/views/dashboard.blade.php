<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Utama') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Statistik Perpustakaan:</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    <li><strong>Total Judul Buku:</strong> {{ $totalBooks }}</li>
                    <li><strong>Total Stok Buku:</strong> {{ $totalStock }}</li>
                    <li><strong>Total Member:</strong> {{ $totalMembers }}</li>
                    <li><strong>Buku Sedang Dipinjam:</strong> {{ $totalBorrowed }}</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>