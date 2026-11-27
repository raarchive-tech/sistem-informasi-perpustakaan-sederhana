<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Peminjaman Baru</h2>
    </x-slot>


    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg max-w-2xl">
            @if(session('error'))
                <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
                    <strong>Gagal:</strong> {{ session('error') }}
                </div>
            @endif


            @if($errors->any())
                <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
                    <strong>Perhatian! Transaksi gagal disimpan:</strong>
                    <ul style="margin-top: 6px; padding-left: 20px; list-style-type: disc;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('borrowings.store') }}" method="POST" onsubmit="return cekStokSebelumSubmit()" class="space-y-4">
                @csrf


                <div>
                    <label class="block font-medium text-gray-700">Pilih Anggota (Member):</label>
                    <select name="member_id" class="w-full border rounded p-2 mt-1" required>
                        <option value="">-- Pilih Member --</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}" {{ old('member_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->member_code }} - {{ $m->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div>
                    <label class="block font-medium text-gray-700">Tanggal Peminjaman:</label>
                    <input type="date" name="borrow_date" class="w-full border rounded p-2 mt-1" value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                    <small class="text-gray-500">* Tenggat pengembalian 7 hari dari tanggal peminjaman.</small>
                </div>


                <hr class="my-4">


                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label class="font-bold text-gray-800">Daftar Buku yang Dipinjam:</label>
                        <button type="button" onclick="tambahBarisBuku()" style="background-color: #16a34a; color: white; padding: 6px 12px; border-radius: 4px; font-size: 14px; cursor: pointer;">
                            + Tambah Buku
                        </button>
                    </div>


                    @php
                        $oldDetails = old('details', [['book_id' => '', 'quantity' => 1]]);
                    @endphp


                    <div id="daftar-buku" class="space-y-3">
                        @foreach($oldDetails as $idx => $item)
                        <div class="baris-buku" style="display: flex; gap: 10px; align-items: center;">
                            <select name="details[{{ $idx }}][book_id]" class="border rounded p-2" style="flex: 3;" required>
                                <option value="">-- Pilih Buku --</option>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}" data-stok="{{ $book->stock }}" data-judul="{{ $book->title }}" {{ ($item['book_id'] ?? '') == $book->id ? 'selected' : '' }}>
                                        {{ $book->title }} (Stok: {{ $book->stock }})
                                    </option>
                                @endforeach
                            </select>


                            <input type="number" name="details[{{ $idx }}][quantity]" value="{{ $item['quantity'] ?? 1 }}" min="1" oninput="if(this.value < 1 && this.value !== '') this.value = 1;" class="border rounded p-2" style="flex: 1;" placeholder="Jumlah" required>


                            <button type="button" onclick="hapusBarisBuku(this)" style="background-color: #dc2626; color: white; padding: 8px 12px; border-radius: 4px; cursor: pointer;">
                                Hapus
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <small class="text-gray-500">* Jangan memilih judul buku yang sama di dua baris berbeda.</small>
                </div>


                <div class="flex space-x-2 pt-4">
                    <button type="submit" style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 4px; font-weight: 600; cursor: pointer;">
                        Simpan Peminjaman
                    </button>
                    <a href="{{ route('borrowings.index') }}" style="background-color: #6b7280; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block;">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>


    <script>
        let indexBuku = {{ count($oldDetails) }};


        function tambahBarisBuku() {
            const container = document.getElementById('daftar-buku');
            const barisPertama = container.querySelector('.baris-buku');
            const barisBaru = barisPertama.cloneNode(true);


            const selectBuku = barisBaru.querySelector('select');
            const inputQty = barisBaru.querySelector('input[type="number"]');


            selectBuku.name = `details[${indexBuku}][book_id]`;
            selectBuku.value = '';


            inputQty.name = `details[${indexBuku}][quantity]`;
            inputQty.value = 1;


            indexBuku++;
            container.appendChild(barisBaru);
        }


        function hapusBarisBuku(tombol) {
            const container = document.getElementById('daftar-buku');
            if (container.querySelectorAll('.baris-buku').length > 1) {
                tombol.closest('.baris-buku').remove();
            } else {
                alert('Minimal harus meminjam 1 buku.');
            }
        }


        function cekStokSebelumSubmit() {
            const barisList = document.querySelectorAll('.baris-buku');
            const bukuDipilih = new Set();


            for (let baris of barisList) {
                const select = baris.querySelector('select');
                const option = select.options[select.selectedIndex];
                const qty = parseInt(baris.querySelector('input[type="number"]').value, 10);


                if (!select.value) continue;


                if (isNaN(qty) || qty < 1) {
                    alert('Jumlah buku yang dipinjam minimal 1.');
                    return false;
                }


                if (bukuDipilih.has(select.value)) {
                    alert(`Buku "${option.dataset.judul}" dipilih lebih dari sekali. Silakan gabungkan jumlahnya dalam satu baris saja.`);
                    return false;
                }
                bukuDipilih.add(select.value);


                const stok = parseInt(option.dataset.stok, 10);
                if (qty > stok) {
                    alert(`Stok buku "${option.dataset.judul}" tidak mencukupi! (Tersedia: ${stok}, diminta: ${qty})`);
                    return false;
                }
            }
            return true;
        }
    </script>
</x-app-layout>
