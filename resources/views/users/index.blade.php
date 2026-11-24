@extends('layouts.app')

@section('header', 'Kelola User')

@section('content')

@if(session('success'))
    <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-700">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-700">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-700">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm">

    <!-- Header -->
    <div class="p-6 border-b flex justify-between items-center">

        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                Daftar User
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Kelola pengguna aplikasi Stock Opname.
            </p>
        </div>

        <!-- Tombol Tambah User -->
        <a href="{{ route('users.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg
                  hover:bg-blue-700 transition">
            + Tambah User
        </a>

    </div>

    <!-- Tabel User -->
    <div class="p-6 overflow-x-auto">

        <table class="w-full text-left border-collapse">

            <thead>
                <tr class="bg-gray-100">

                    <th class="px-4 py-3 text-sm font-semibold text-gray-700">
                        No
                    </th>

                    <th class="px-4 py-3 text-sm font-semibold text-gray-700">
                        Nama
                    </th>

                    <th class="px-4 py-3 text-sm font-semibold text-gray-700">
                        Email
                    </th>

                    <th class="px-4 py-3 text-sm font-semibold text-gray-700">
                        Role
                    </th>

                    <th class="px-4 py-3 text-sm font-semibold text-gray-700">
                        Aksi
                    </th>

                </tr>
            </thead>

            <tbody>

                @forelse($users as $user)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="px-4 py-3">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $user->name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $user->email }}
                        </td>

                        <td class="px-4 py-3">
                            {{ ucfirst($user->role) }}
                        </td>

                        <!-- Aksi -->
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-4">

                                <!-- Tombol Edit -->
                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="text-blue-600 hover:text-blue-800">
                                    Edit
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('users.destroy', $user->id) }}"
                                      method="POST"
                                      class="inline-flex">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus user ini?')"
                                            class="text-red-600 hover:text-red-800">
                                        Hapus
                                    </button>

                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5"
                            class="px-4 py-6 text-center text-gray-500">
                            Belum ada user.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection