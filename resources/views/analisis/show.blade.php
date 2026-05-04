<x-app-layout>
    <div class="bg-white/5 backdrop-blur-2xl rounded-3xl overflow-hidden border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
        {{-- HEADER --}}
        <div class="px-8 py-6 bg-white/5 border-b border-white/10 flex justify-between items-center">
            <h3 class="text-white font-black text-xl tracking-tighter italic">
                SCOREBOARD_ANALYTICS
            </h3>
            <span class="px-3 py-1 bg-white/10 text-white text-[10px] rounded-full uppercase tracking-[0.3em] font-bold border border-white/10">
                Match Data
            </span>
        </div>
        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                {{-- THEAD --}}
                <thead>
                    <tr class="text-white/50 text-[10px] uppercase tracking-[0.2em] font-black">
                        <th class="px-8 py-5 border-b border-white/5">Jugador</th>
                        <th class="px-6 py-5 border-b border-white/5 text-center">Kills</th>
                        <th class="px-6 py-5 border-b border-white/5 text-center">Deaths</th>
                        <th class="px-6 py-5 border-b border-white/5 text-center">KD</th>
                        <th class="px-6 py-5 border-b border-white/5 text-center">MVPs</th>
                        <th class="px-6 py-5 border-b border-white/5 text-center">HS</th>
                        <th class="px-8 py-5 border-b border-white/5 text-right">Score</th>
                    </tr>
                </thead>
                {{-- TBODY --}}
                <tbody class="divide-y divide-white/5">
                    @foreach($stats as $player)
                        @php
                            $kd = $player['deaths_total'] > 0
                                ? round($player['kills_total'] / $player['deaths_total'], 2)
                                : $player['kills_total'];
                        @endphp
                        <tr class="hover:bg-white/[0.07] transition-all group">
                            {{-- JUGADOR --}}
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="h-9 w-9 rounded-lg bg-white/10 border border-white/20 text-white flex items-center justify-center font-black text-xs group-hover:scale-110 transition-transform">
                                        {{ strtoupper(substr($player['name'], 0, 2)) }}
                                    </div>
                                    <span class="font-bold text-white text-base">
                                        {{ $player['name'] }}
                                    </span>
                                </div>
                            </td>
                            {{-- KILLS --}}
                            <td class="px-6 py-5 text-center font-mono font-black text-white text-xl">
                                {{ $player['kills_total'] }}
                            </td>
                            {{-- DEATHS --}}
                            <td class="px-6 py-5 text-center font-mono text-rose-400 font-bold opacity-80">
                                {{ $player['deaths_total'] }}
                            </td>
                            {{-- KD --}}
                            <td class="px-6 py-5 text-center font-black {{ $kd >= 1 ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ $kd }}
                            </td>
                            {{-- MVPs --}}
                            <td class="px-6 py-5 text-center text-amber-400 font-bold">
                                @if($player['mvps'] > 0)
                                    <span class="flex justify-center items-center gap-1">
                                        ⭐ {{ $player['mvps'] }}
                                    </span>
                                @else
                                    <span class="opacity-20">-</span>
                                @endif
                            </td>
                            {{-- HS --}}
                            <td class="px-6 py-5 text-center text-white/70 font-bold">
                                {{ $player['headshot_kills_total'] }}
                            </td>
                            {{-- SCORE --}}
                            <td class="px-8 py-5 text-right">
                                <span class="font-black text-white bg-white/10 px-4 py-2 rounded-xl border border-white/10 group-hover:bg-white group-hover:text-black transition-all">
                                    {{ number_format($player['score']) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>