<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data User</h2>
    </x-slot>


    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow sm:rounded-lg max-w-lg">
            @if($errors->any())
                <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
                    <ul style="padding-left: 20px; list-style-type: disc;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-medium text-gray-700">Nama Lengkap:</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded p-2 mt-1" required>
                    @error('name') <span style="color: #dc2626; font-size: 13px;">{{ $message }}</span> @enderror
                </div>


                <div>
                    <label class="block font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded p-2 mt-1" required>
                    @error('email') <span style="color: #dc2626; font-size: 13px;">{{ $message }}</span> @enderror
                </div>


                <div>
                    <label class="block font-medium text-gray-700">Password Baru (Kosongkan jika tidak ingin mengubah):</label>
                    <input type="password" name="password" minlength="8" class="w-full border rounded p-2 mt-1">
                    @error('password') <span style="color: #dc2626; font-size: 13px;">{{ $message }}</span> @enderror
                </div>


                <div>
                    <label class="block font-medium text-gray-700">Role:</label>
                    <select name="role" class="w-full border rounded p-2 mt-1" required>
                        <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role') <span style="color: #dc2626; font-size: 13px;">{{ $message }}</span> @enderror
                </div>


                <div class="flex space-x-2 pt-2">
                    <button type="submit" style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Update User</button>
                    <a href="{{ route('users.index') }}" style="background-color: #6b7280; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
