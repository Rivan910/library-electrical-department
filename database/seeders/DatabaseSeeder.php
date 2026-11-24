<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Salin akun user dari database stock opname sebelumnya (jika ada di MySQL lokal)
        try {
            $oldUsers = DB::select('SELECT name, email, password, role FROM stok_opname_fix.users');
            foreach ($oldUsers as $oldUser) {
                if (!User::where('name', $oldUser->name)->exists() && !User::where('email', $oldUser->email)->exists()) {
                    DB::table('users')->insert([
                        'name' => $oldUser->name,
                        'email' => $oldUser->email,
                        'password' => $oldUser->password,
                        'role' => $oldUser->role ?? 'viewer',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        } catch (Throwable $e) {
            // Abaikan jika database stok_opname_fix tidak ada
        }

        // Pastikan akun default admin tersedia
        if (!User::where('name', 'admin')->exists()) {
            User::updateOrCreate(
                ['email' => 'admin@p611.local'],
                [
                    'name' => 'admin',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                ]
            );
        }

        // Pastikan akun default viewer tersedia
        if (!User::where('name', 'viewer')->exists()) {
            User::updateOrCreate(
                ['email' => 'viewer@p611.local'],
                [
                    'name' => 'viewer',
                    'password' => Hash::make('viewer123'),
                    'role' => 'viewer',
                ]
            );
        }
    }
}
