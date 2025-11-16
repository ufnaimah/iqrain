<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HasilGameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // ASUMSI: Kamu punya data di tabel 'jenis_games'
        // Jika tabel 'jenis_games' kosong, ini akan error.
        // Ganti '1' dengan ID jenis_game yang valid.
        
        return [
            // 'murid_id' akan diisi otomatis oleh Seeder
            'jenis_game_id' => 1, // <-- ASUMSI ID 1 ADA
            'skor' => $this->faker->numberBetween(50, 100),
            'total_poin' => $this->faker->numberBetween(100, 1000),
            'dimainkan_at' => now()->subDays($this->faker->numberBetween(0, 30)),
        ];
    }
}