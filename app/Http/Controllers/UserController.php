<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $users = User::oldest()->paginate(10);

        return view('users.index', compact('users'));
    }

    // Menampilkan form tambah pengguna
    public function create()
    {
        return view('users.create');
    }

    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\',\-]+$/'],
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,petugas',
        ], [
            'name.required'     => 'Nama pengguna wajib diisi.',
            'name.regex'        => 'Nama pengguna hanya boleh berisi huruf (tidak boleh angka).',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid (contoh: nama@gmail.com).',
            'email.unique'      => 'Email sudah terdaftar, silakan gunakan email lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal harus 8 karakter.',
            'role.required'     => 'Role pengguna wajib dipilih.',
            'role.in'           => 'Role hanya boleh Admin atau Petugas.',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role = $validated['role'];
        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Menampilkan detail pengguna
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Menampilkan form edit pengguna
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Memperbarui data pengguna
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\',\-]+$/'],
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role'     => 'required|in:admin,petugas',
        ], [
            'name.required'  => 'Nama pengguna wajib diisi.',
            'name.regex'     => 'Nama pengguna hanya boleh berisi huruf (tidak boleh angka).',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid (contoh: nama@gmail.com).',
            'email.unique'   => 'Email sudah digunakan oleh pengguna lain.',
            'password.min'   => 'Password baru minimal harus 8 karakter.',
            'role.required'  => 'Role pengguna wajib dipilih.',
            'role.in'        => 'Role hanya boleh Admin atau Petugas.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // Menghapus pengguna
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}