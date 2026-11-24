@extends('layouts.app')

@section('header', 'Edit User')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-xl shadow-sm">

        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">
                Edit User
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Ubah data pengguna aplikasi Stock Opname.
            </p>
        </div>


        <form method="POST"
              action="{{ route('users.update', $user->id) }}"
              class="p-6 space-y-5">

            @csrf
            @method('PUT')


            <!-- Nama -->
            <div>
                <label for="name"
                       class="block text-sm font-medium text-gray-700 mb-2">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    class="w-full border-gray-300 rounded-lg
                           focus:border-blue-500 focus:ring-blue-500">

                @error('name')
                    <p class="text-sm text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            <!-- Username -->
            <div>
                <label for="email"
                       class="block text-sm font-medium text-gray-700 mb-2">
                    Username
                </label>

                <input
                    type="text"
                    name="email"
                    id="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    class="w-full border-gray-300 rounded-lg
                           focus:border-blue-500 focus:ring-blue-500">

                @error('email')
                    <p class="text-sm text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            <!-- Password -->
            <div>
                <label for="password"
                       class="block text-sm font-medium text-gray-700 mb-2">
                    Password Baru
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full border-gray-300 rounded-lg
                           focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Kosongkan jika tidak ingin mengubah password">

                @error('password')
                    <p class="text-sm text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation"
                       class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password Baru
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="w-full border-gray-300 rounded-lg
                           focus:border-blue-500 focus:ring-blue-500">
            </div>


            <!-- Role -->
            <div>
                <label for="role"
                       class="block text-sm font-medium text-gray-700 mb-2">
                    Role User
                </label>

                <select
                    name="role"
                    id="role"
                    required
                    class="w-full border-gray-300 rounded-lg
                           focus:border-blue-500 focus:ring-blue-500">

                    <option value="viewer"
                        {{ old('role', $user->role) == 'viewer' ? 'selected' : '' }}>
                        Viewer - Hanya melihat Dashboard
                    </option>

                    <option value="admin"
                        {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                        Admin - Akses penuh
                    </option>

                </select>

                @error('role')
                    <p class="text-sm text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            <!-- Tombol -->
            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('users.index') }}"
                   class="px-4 py-2 rounded-lg border border-gray-300
                          text-gray-700 hover:bg-gray-100">
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-4 py-2 rounded-lg bg-blue-600
                           text-white hover:bg-blue-700">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection