@props(['players', 'showKd' => false, 'showHs' => false, 'showAces' => false, 'title' => 'SCOREBOARD_GENERAL'])

<div class="bg-white/5 backdrop-blur-2xl rounded-3xl overflow-hidden border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
    <div class="px-8 py-6 bg-white/5 border-b border-white/10 flex justify-between items-center">
        <h3 class="text-white font-black text-xl tracking-tighter italic">{{ $title }}</h3>
        <span class="px-3 py-1 bg-white/10 text-white text-[10px] rounded-full uppercase tracking-[0.3em] font-bold border border-white/10">
            Match Data
        </span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-white/50 text-[10px] uppercase tracking-[0.2em] font-black">
                    <th class="px-8 py-5 border-b border-white/5">Jugador</th>
                    <th class="px-6 py-5 border-b border-white/5 text-center">Kills</th>
                    <th class="px-6 py-5 border-b border-white/5 text-center">Deaths</th>
                    @if($showKd)
                        <th class="px-6 py-5 border-b border-white/5 text-center">KD</th>
                    @endif
                    <th class="px-6 py-5 border-b border-white/5 text-center">MVPs</th>
                    @if($showHs)
                        <th class="px-6 py-5 border-b border-white/5 text-center">HS</th>
                    @endif
                    @if($showAces)
                        <th class="px-6 py-5 border-b border-white/5 text-center">Aces</th>
                    @endif
                    <th class="px-8 py-5 border-b border-white/5 text-right">Score</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($players as $player)
                    @php
                        $kd = ($player['deaths_total'] ?? 0) > 0
                            ? round(($player['kills_total'] ?? 0) / $player['deaths_total'], 2)
                            : ($player['kills_total'] ?? 0);
                    @endphp
                    <tr class="hover:bg-white/[0.07] transition-all group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="h-9 w-9 rounded-lg bg-white/10 border border-white/20 text-white flex items-center justify-center font-black text-xs group-hover:scale-110 transition-transform">
                                    {{ strtoupper(substr($player['name'] ?? '?', 0, 2)) }}
                                </div>
                                <span class="font-bold text-white text-base">{{ $player['name'] ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center font-mono font-black text-white text-xl">
                            {{ $player['kills_total'] ?? 0 }}
                        </td>
                        <td class="px-6 py-5 text-center font-mono text-rose-400 font-bold opacity-80">
                            {{ $player['deaths_total'] ?? 0 }}
                        </td>
                        @if($showKd)
                            <td class="px-6 py-5 text-center font-black {{ $kd >= 1 ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ $kd }}
                            </td>
                        @endif
                        <td class="px-6 py-5 text-center text-amber-400">
                            @if(($player['mvps'] ?? 0) > 0)
                                <span class="flex justify-center items-center gap-1 font-bold">
                                    <span class="text-xs">⭐</span> {{ $player['mvps'] }}
                                </span>
                            @else
                                <span class="opacity-20">-</span>
                            @endif
                        </td>
                        @if($showHs)
                            <td class="px-6 py-5 text-center text-white/70 font-bold">
                                {{ $player['headshot_kills_total'] ?? 0 }}
                            </td>
                        @endif
                        @if($showAces)
                            <td class="px-6 py-5 text-center">
                                <span class="px-3 py-1 {{ ($player['ace_rounds_total'] ?? 0) > 0 ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : 'bg-white/5 text-white/20' }} rounded-md text-[10px] font-black uppercase">
                                    {{ ($player['ace_rounds_total'] ?? 0) > 0 ? 'ACE x' . $player['ace_rounds_total'] : '0' }}
                                </span>
                            </td>
                        @endif
                        <td class="px-8 py-5 text-right">
                            <span class="font-black text-white bg-white/10 px-4 py-2 rounded-xl border border-white/10 group-hover:bg-white group-hover:text-black transition-all">
                                {{ number_format($player['score'] ?? 0) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
