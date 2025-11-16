<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    @vite('resources/css/app.css')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    <style>
        /* CSS Scrollbar (Tidak berubah) */
        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #e0e7ff; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #3182ce; border-radius: 10px; }
    </style>
</head>
<body class="bg-blue-200 min-h-screen p-8 flex items-center justify-center font-sans">

    {{-- 
      Kita buat 1 wrapper utama untuk mengatur lebar 'max-w-lg'
      dan menampung 2 div terpisah kita.
    --}}
    <div class="w-full max-w-lg">
        
        {{-- 
          DIV 1: Bagian Tab Atas (TERPISAH)
          Ini adalah div tersendiri. Kita beri 'mb-4' (margin-bottom)
          untuk memberi jarak ke card putih di bawahnya.
        --}}
        <div class="flex justify-center mb-4">
            <div class="flex bg-gray-100 rounded-full p-1">
                <button class="bg-red-700 text-white rounded-full py-2 px-8 text-sm font-semibold">Leaderboard</button>
                <button class="bg-transparent text-gray-500 rounded-full py-2 px-8 text-sm font-semibold">Evaluasi</button>
            </div>
        </div>

        {{-- 
          DIV 2: Card Putih Utama (TERPISAH)
          Ini adalah div card-nya. Kita kembalikan 'p-6' seperti semula
          dan buang semua trik '-mt-6' dan 'pt-12'.
        --}}
        <div class="bg-white rounded-3xl shadow-xl p-6 relative">
            
            {{-- Dropdown Lingkup (Posisinya tetap aman di dalam card) --}}
            <div class="absolute top-6 right-6">
                <button class="bg-blue-800 text-white text-xs font-medium py-2 px-4 rounded-full flex items-center">
                    Lingkup Umum
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin-round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
            </div>

            {{-- 
              Konten Podium.
              Padding 'p-6' dari card di atas sudah memberi ruang
              agar konten tidak terlalu mepet ke atas.
            --}}
            <div class="flex items-end justify-center gap-4 text-center mb-8">
                
                {{-- Peringkat 2 --}}
                @if ($podium['rank_2'])
                <div class="w-1/3 order-1">
                    <img src="{{ $podium['rank_2']['avatar_url'] }}" alt="{{ $podium['rank_2']['name'] }}" class="w-16 h-16 rounded-full mx-auto mb-2 object-cover border-2 border-gray-300">
                    <h3 class="text-blue-900 font-bold text-sm truncate">{{ $podium['rank_2']['name'] }}</h3>
                    <p class="text-gray-500 text-xs">Skor {{ $podium['rank_2']['score'] }}</p>
                    <div class="bg-gray-200 rounded-t-lg h-32 mt-2 relative flex items-center justify-center">
                        <span class="text-gray-400 font-bold text-7xl opacity-70">2</span>
                    </div>
                </div>
                @endif

                {{-- Peringkat 1 --}}
                @if ($podium['rank_1'])
                <div class="w-1/3 order-2">
                    <img src="{{ $podium['rank_1']['avatar_url'] }}" alt="{{ $podium['rank_1']['name'] }}" class="w-20 h-20 rounded-full mx-auto mb-2 object-cover border-4 border-yellow-400">
                    <h3 class="text-blue-900 font-bold text-base truncate">{{ $podium['rank_1']['name'] }}</h3>
                    <p class="text-gray-500 text-xs">Skor {{ $podium['rank_1']['score'] }}</p>
                    <div class="bg-gray-200 rounded-t-lg h-48 mt-2 relative flex items-center justify-center">
                        <span class="text-gray-400 font-bold text-9xl opacity-70">1</span>
                    </div>
                </div>
                @endif

                {{-- Peringkat 3 --}}
                @if ($podium['rank_3'])
                <div class="w-1/3 order-3">
                    <img src="{{ $podium['rank_3']['avatar_url'] }}" alt="{{ $podium['rank_3']['name'] }}" class="w-16 h-16 rounded-full mx-auto mb-2 object-cover border-2 border-gray-300">
                    <h3 class="text-blue-900 font-bold text-sm truncate">{{ $podium['rank_3']['name'] }}</h3>
                    <p class="text-gray-500 text-xs">Skor {{ $podium['rank_3']['score'] }}</p>
                    <div class="bg-gray-200 rounded-t-lg h-24 mt-2 relative flex items-center justify-center">
                        <span class="text-gray-400 font-bold text-6xl opacity-70">3</span>
                    </div>
                </div>
                @endif
            </div>

            {{-- Daftar Peringkat 4+ (Tidak berubah) --}}
            <div class="space-y-4 pr-4 h-48 overflow-y-auto custom-scrollbar">
                
                @forelse ($otherPlayers as $player)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 font-bold text-lg w-10">
                            {{ str_pad($player['rank'], 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <span class="text-blue-900 font-bold text-sm text-left flex-1 ml-4 truncate">
                            {{ $player['name'] }}
                        </span>
                        <span class="text-gray-500 text-sm">
                            Skor {{ $player['score'] }}
                        </span>
                    </div>
                @empty
                    <div class="text-center text-gray-500 pt-8">
                        Data leaderboard kosong. <br>
                        Silakan mainkan game terlebih dahulu.
                    </div>
                @endforelse

            </div>
        </div>

    </div> {{-- Penutup div wrapper utama --}}

</body>
</html>