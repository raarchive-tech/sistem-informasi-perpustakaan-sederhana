<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // 1. Menampilkan daftar anggota + pencarian
    public function index(Request $request)
    {
        $search = $request->input('search');

        $members = Member::when($search, function ($query, $search) {
                $query->where('member_code', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%");
            })
            ->oldest()
            ->paginate(10)
            ->withQueryString();

        return view('members.index', compact('members'));
    }

    // 2. Menampilkan form tambah anggota dengan kode otomatis
    public function create()
    {
        $lastMember = Member::orderBy('id', 'desc')->first();
        $nextNumber = $lastMember ? ($lastMember->id + 1) : 1;
        $nextCode = 'MBR-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('members.create', compact('nextCode'));
    }

    // 3. Menyimpan anggota baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\',\-]+$/'],
        ], [
            'name.regex' => 'Nama anggota hanya boleh berisi huruf (tidak boleh angka).',
        ]);

        // Generate kode member otomatis yang konsisten (MBR-001, MBR-002, dst.)
        $lastMember = Member::orderBy('id', 'desc')->first();
        $nextNumber = $lastMember ? ($lastMember->id + 1) : 1;
        $memberCode = 'MBR-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $member = new Member();
        $member->member_code = $memberCode;
        $member->name = $validated['name'];
        $member->save();

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil ditambahkan dengan kode ' . $memberCode . '.');
    }

    // 4. Menampilkan detail anggota
    public function show(Member $member)
    {
        return view('members.show', compact('member'));
    }

    // 5. Menampilkan form edit anggota
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    // 6. Memperbarui data anggota
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\',\-]+$/'],
        ], [
            'name.regex' => 'Nama anggota hanya boleh berisi huruf (tidak boleh angka).',
        ]);

        // Kode member tetap dipertahankan agar tidak berubah sembarangan
        $member->name = $validated['name'];
        $member->save();

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    // 7. Menghapus anggota
    public function destroy(Member $member)
    {
        // Mencegah penghapusan anggota yang memiliki riwayat peminjaman
        if ($member->borrowings()->exists()) {
            return redirect()->route('members.index')
                ->with('error', 'Anggota tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}