<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // 1. Menampilkan daftar anggota
    public function index()
    {
        $members = Member::latest()->paginate(10);

        return view('members.index', compact('members'));
    }

    // 2. Menampilkan form tambah anggota
    public function create()
    {
        return view('members.create');
    }

    // 3. Menyimpan anggota baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_code' => 'required|string|max:255|unique:members,member_code',
            'name' => 'required|string|max:255',
        ]);

        $member = new Member();
        $member->member_code = $validated['member_code'];
        $member->name = $validated['name'];
        $member->save();

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
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
            'member_code' => 'required|string|max:255|unique:members,member_code,' . $member->id,
            'name' => 'required|string|max:255',
        ]);

        $member->member_code = $validated['member_code'];
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
