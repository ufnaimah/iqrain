<?php

namespace App\Http\Controllers;

use App\Models\HasilGame;
use App\Models\Murid;
use App\Models\User; // <-- Dibutuhkan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        // 1. Query untuk menjumlahkan skor per murid
        // Ganti 'total_poin' ke 'skor' jika perlu
        $scores = HasilGame::select(
                'murid_id', 
                DB::raw('SUM(total_poin) as total_skor')
            )
            ->groupBy('murid_id')
            ->orderBy('total_skor', 'desc')
            ->get();

        // 2. Ambil ID murid dari hasil query
        $muridIds = $scores->pluck('murid_id');

        // 3. Ambil data murid DAN relasi user-nya (Eager Loading)
        $murids = Murid::with('user') // Ambil relasi 'user'
                       ->whereIn('murid_id', $muridIds)
                       ->get()
                       ->keyBy('murid_id');

        // 4. Gabungkan data skor, nama, dan avatar
        $rankedPlayers = $scores->map(function ($item, $key) use ($murids) {
            
            $muridName = 'Murid (No User)';
            // Ambil default avatar dari model User
            $defaultAvatar = (new User)->getAvatarUrlAttribute(); 
            $avatarUrl = $defaultAvatar;
            
            // Ambil data murid dari koleksi
            $murid = $murids->get($item->murid_id);

            // Cek apakah muridnya ada DAN relasi user-nya ada
            if ($murid && $murid->user) {
                // KITA TEMUKAN: pakai 'username'
                $muridName = $murid->user->username; 
                // KITA TEMUKAN: pakai 'avatar_url' (dari accessor)
                $avatarUrl = $murid->user->avatar_url; 
            }

            return [
                'rank' => $key + 1, // Peringkat
                'name' => $muridName,
                'score' => $item->total_skor,
                'avatar_url' => $avatarUrl, // <-- KITA TAMBAHKAN INI
            ];
        });

        // 5. Pisahkan data untuk podium (Top 3)
        $podium = [
            'rank_1' => $rankedPlayers->firstWhere('rank', 1),
            'rank_2' => $rankedPlayers->firstWhere('rank', 2),
            'rank_3' => $rankedPlayers->firstWhere('rank', 3),
        ];

        // 6. Sisa pemain (ranking 4 ke bawah)
        $otherPlayers = $rankedPlayers->where('rank', '>', 3);

        // 7. Kirim ke View
        return view('leaderboard', [ // Pastikan nama file view-mu 'leaderboard.blade.php'
            'podium' => $podium,
            'otherPlayers' => $otherPlayers
        ]);
    }
}