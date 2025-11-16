<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Kita butuh semua model ini
use App\Models\User;
use App\Models\Murid;
use App\Models\HasilGame;
use App\Models\JenisGame;
use Illuminate\Support\Facades\Hash; // <-- Tambahkan ini

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Panggil Seeder bawaanmu (Ini sudah benar)
        $this->call([
            DashboardTableSeeder::class,
            RolePermissionSeeder::class,
            AdminSeeder::class,
            TingkatanIqraSeeder::class,
            JenisGameSeeder::class,
        ]);

        // 2. Buat 20 Murid (Sekarang kita panggil Murid::factory() langsung)
        // Setiap MuridFactory::create() akan auto-create 1 User
        Murid::factory()
            ->count(20) // Buat 20 Murid (otomatis 20 User baru)
            ->has(
                HasilGame::factory()
                    ->count(5) // Setiap Murid punya 5 riwayat game
                    ->state(function (array $attributes) {
                        // Ambil ID game acak (Ini sudah benar)
                        return ['jenis_game_id' => JenisGame::all()->random()->jenis_game_id];
                    })
            )
            ->create();

        // 3. Buat 1 Jagoan (Kita buat manual biar 100% aman)
        $jagoanUser = User::create([
            'username' => 'JAGOAN_KITA',
            'password' => Hash::make('password'),
            'avatar_path' => null
        ]);

        $jagoanMurid = Murid::create([
            'user_id' => $jagoanUser->user_id,
            'sekolah' => 'Sekolah Juara',
            'preferensi_terisi' => false, // Pastikan kolom ini diisi
        ]);

        HasilGame::factory()
            ->count(10) // Dia main 10x
            ->state(function (array $attributes) {
                return [
                    'total_poin' => 1000, // Skornya selalu tinggi
                    'jenis_game_id' => JenisGame::all()->random()->jenis_game_id
                ];
            })
            ->for($jagoanMurid) // Tautkan ke Murid jagoan
            ->create();
    }
}