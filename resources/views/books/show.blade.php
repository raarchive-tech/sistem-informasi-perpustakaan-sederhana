<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Buku
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg" style="max-width: 850px;">

            <div style="display: flex; align-items: flex-start; gap: 30px; flex-wrap: wrap;">

                {{-- Cover Buku --}}
                <div style="width: 210px; flex-shrink: 0; text-align: center;">
                    @if($book->cover)
                        <img
                            src="{{ asset('storage/' . $book->cover) }}"
                            alt="Cover {{ $book->title }}"
                            style="width: 190px; max-height: 280px; object-fit: contain; border-radius: 12px; box-shadow: 0 8px 22px rgba(70,60,110,.15);"
                        >
                    @else
                        <div style="width: 190px; height: 260px; margin: 0 auto; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 12px; background: linear-gradient(135deg, #eeecff, #e4effb); color: #918bcf;">
                            <span style="font-size: 55px;">▧</span>
                            <span style="margin-top: 10px; font-size: 12px; font-weight: 700;">
                                Cover Belum Tersedia
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Informasi Buku --}}
                <div style="flex: 1; min-width: 230px;">

                    <div style="margin-bottom: 20px;">
                        <span style="display: inline-block; padding: 6px 12px; border-radius: 20px; background: #eeecff; color: #817bc5; font-size: 11px; font-weight: 700;">
                            DETAIL KOLEKSI
                        </span>

                        <h3 style="margin: 12px 0 5px; color: #4e4b6b; font-size: 24px; font-weight: 800; line-height: 1.3;">
                            {{ $book->title }}
                        </h3>

                        <p style="margin: 0; color: #9692aa; font-size: 13px;">
                            Karya {{ $book->author }}
                        </p>
                    </div>

                    <div style="border-top: 1px solid #eeedf5;">

                        <div style="display: flex; justify-content: space-between; gap: 15px; padding: 15px 0; border-bottom: 1px solid #eeedf5;">
                            <span style="color: #9692aa; font-size: 12px;">Kategori</span>
                            <strong style="color: #56536f; font-size: 12px; text-align: right;">
                                {{ $book->category->name ?? '-' }}
                            </strong>
                        </div>

                        <div style="display: flex; justify-content: space-between; gap: 15px; padding: 15px 0; border-bottom: 1px solid #eeedf5;">
                            <span style="color: #9692aa; font-size: 12px;">Penulis</span>
                            <strong style="color: #56536f; font-size: 12px; text-align: right;">
                                {{ $book->author }}
                            </strong>
                        </div>

                        <div style="display: flex; justify-content: space-between; gap: 15px; padding: 15px 0; border-bottom: 1px solid #eeedf5;">
                            <span style="color: #9692aa; font-size: 12px;">Tahun Terbit</span>
                            <strong style="color: #56536f; font-size: 12px; text-align: right;">
                                {{ $book->year }}
                            </strong>
                        </div>

                        <div style="display: flex; justify-content: space-between; gap: 15px; padding: 15px 0; border-bottom: 1px solid #eeedf5;">
                            <span style="color: #9692aa; font-size: 12px;">Stok Tersedia</span>
                            <strong style="color: #639b7e; font-size: 12px; text-align: right;">
                                {{ $book->stock }} Buku
                            </strong>
                        </div>

                    </div>

                    {{-- Tombol Aksi --}}
                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 25px;">
                        <a
                            href="{{ route('books.index') }}"
                            style="display: inline-block; padding: 10px 18px; border-radius: 9px; background: #f0eff7; color: #77738f; font-size: 12px; font-weight: 700; text-decoration: none;"
                        >
                            ← Kembali
                        </a>

                        @if(auth()->user()->role === 'admin')
                            <a
                                href="{{ route('books.edit', $book->id) }}"
                                style="display: inline-block; padding: 10px 18px; border-radius: 9px; background: #e9efff; color: #718bd0; font-size: 12px; font-weight: 700; text-decoration: none;"
                            >
                                Edit Buku
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>