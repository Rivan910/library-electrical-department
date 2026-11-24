<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user.
     */
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan formulir tambah user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Menyimpan user baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                // Kolom email sementara digunakan untuk menyimpan username.
                'email' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users', 'email'),
                ],

                'password' => [
                    'required',
                    'string',
                    'confirmed',
                    'min:8',
                ],

                // Sistem hanya menggunakan admin dan viewer.
                'role' => [
                    'required',
                    Rule::in(['admin', 'viewer']),
                ],
            ],
            [],
            [
                'email' => 'username',
            ]
        );

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Memperbarui data user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                // Username boleh berupa teks biasa, bukan harus email.
                'email' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($user->id),
                ],

                'password' => [
                    'nullable',
                    'string',
                    'confirmed',
                    'min:8',
                ],

                'role' => [
                    'required',
                    Rule::in(['admin', 'viewer']),
                ],
            ],
            [],
            [
                'email' => 'username',
            ]
        );

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        // Password hanya diperbarui jika diisi.
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus user.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'Akun yang sedang digunakan tidak dapat dihapus.'
                );
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
