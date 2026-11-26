<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Transaksi Peminjaman</h2>
    </x-slot>


    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg max-w-lg space-y-3">
            <p><strong>Peminjam:</strong> {{ $borrowing->member->name ?? '-' }} ({{ $borrowing->member->member_code ?? '-' }})</p>
            <p><strong>Petugas:</strong> {{ $borrowing->user->name ?? '-' }}</p>
            <p><strong>Tanggal Pinjam:</strong> {{ $borrowing->borrow_date }}</p>
            <p><strong>Tenggat (Due Date):</strong> {{ $borrowing->due_date }}</p>
            <p><strong>Tanggal Dikembalikan:</strong> {{ $borrowing->return_date ?? '-' }}</p>
            <p><strong>Status:</strong> <strong>{{ strtoupper($borrowing->status) }}</strong></p>


            <hr class="my-3">
            <h4 class="font-bold">Daftar Buku Dipinjam:</h4>
            <ul class="list-disc pl-5">
                @foreach($borrowing->details as $detail)
                    <li>{{ $detail->book->title ?? 'Buku dihapus' }} — {{ $detail->quantity }} eksemplar</li>
                @endforeach
            </ul>


            <div class="pt-4">
                <a href="{{ route('borrowings.index') }}" style="background-color: #6b7280; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block;">Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>
