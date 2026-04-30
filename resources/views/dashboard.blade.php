<x-app-layout>
    {{--  
    <x-slot name="header">
        <h2 class="font-black text-3xl text-white leading-tight tracking-tighter">
            {{ __('Análisis de Partidas CS2') }}
        </h2>
    </x-slot>
    --}}
    <div class="py-12 bg-[#0a0a0a] min-h-screen relative overflow-hidden">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-900/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-900/10 rounded-full blur-[120px]"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 overflow-hidden shadow-2xl sm:rounded-2xl mb-12">
                <div class="p-8">
                    <h3 class="text-xl font-bold text-white mb-6 text-center tracking-tight">Importar Nueva Demo</h3>
                    <form action="{{ route('demo.guardar') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                        @csrf
                        <div class="w-full max-w-md">
                            <label for="demo-input" class="relative flex flex-col items-center px-4 py-8 bg-white/5 text-white rounded-xl border-2 border-dashed border-white/20 cursor-pointer hover:bg-white/10 hover:border-white/40 transition-all group" id="label-file">
                                <div id="status-initial" class="flex flex-col items-center">
                                    <svg class="w-10 h-10 mb-3 text-white/60 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <span class="text-sm font-semibold tracking-wide">Selecciona un archivo .dem</span>
                                </div>
                                <div id="status-selected" class="hidden flex flex-col items-center text-white">
                                    <svg class="w-10 h-10 mb-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span id="file-name-display" class="text-sm font-bold truncate max-w-xs">Nombre del archivo</span>
                                    <span class="text-[10px] text-white/40 mt-1 uppercase tracking-[0.2em]">Ready to analyze</span>
                                </div>
                                <input type='file' id="demo-input" name="file" class="hidden" required accept=".dem" />
                            </label>
                        </div>
                        <button type="submit" id="btn-analyze" class="mt-6 px-10 py-3 bg-white text-black font-black rounded-xl hover:bg-gray-200 disabled:bg-white/10 disabled:text-white/20 disabled:cursor-not-allowed transition-all shadow-[0_0_20px_rgba(255,255,255,0.1)]">
                            ANALIZAR PARTIDA
                        </button>
                    </form>
                </div>
            </div>
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 rounded-xl">
                    <p class="font-bold flex items-center"><span class="mr-2">✔</span> {{ session('success') }}</p>
                </div>
            @endif
            @if(session('stats'))
                <div class="bg-white/5 backdrop-blur-2xl rounded-3xl overflow-hidden border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
                    <div class="px-8 py-6 bg-white/5 border-b border-white/10 flex justify-between items-center">
                        <h3 class="text-white font-black text-xl tracking-tighter italic">SCOREBOARD_GENERAL</h3>
                        <span class="px-3 py-1 bg-white/10 text-white text-[10px] rounded-full uppercase tracking-[0.3em] font-bold border border-white/10">Match Data</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-white/50 text-[10px] uppercase tracking-[0.2em] font-black">
                                    <th class="px-8 py-5 border-b border-white/5">Jugador</th>
                                    <th class="px-6 py-5 border-b border-white/5 text-center">Kills</th>
                                    <th class="px-6 py-5 border-b border-white/5 text-center">Deaths</th>
                                    <th class="px-6 py-5 border-b border-white/5 text-center">MVPs</th>
                                    <th class="px-6 py-5 border-b border-white/5 text-center">Aces</th>
                                    <th class="px-8 py-5 border-b border-white/5 text-right">Score</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach(session('stats') as $player)
                                    <tr class="hover:bg-white/[0.07] transition-all group">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center">
                                                <div class="h-9 w-9 rounded-lg bg-white/10 border border-white/20 text-white flex items-center justify-center font-black text-xs mr-4 group-hover:scale-110 transition-transform">
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
                                        <td class="px-6 py-5 text-center text-amber-400">
                                            @if(($player['mvps'] ?? 0) > 0)
                                                <span class="flex justify-center items-center gap-1 font-bold">
                                                    <span class="text-xs">⭐</span> {{ $player['mvps'] }}
                                                </span>
                                            @else
                                                <span class="opacity-20">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="px-3 py-1 {{ ($player['ace_rounds_total'] ?? 0) > 0 ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : 'bg-white/5 text-white/20' }} rounded-md text-[10px] font-black uppercase">
                                                {{ ($player['ace_rounds_total'] ?? 0) > 0 ? 'ACE x' . $player['ace_rounds_total'] : '0' }}
                                            </span>
                                        </td>
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
            @else
                <div class="text-center py-24 bg-white/5 backdrop-blur-md rounded-3xl border border-dashed border-white/10">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 mb-4 border border-white/10">
                        <svg class="w-8 h-8 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <p class="text-white/40 font-medium tracking-wide uppercase text-xs">No hay datos disponibles</p>
                    <p class="text-white/20 text-[10px] mt-1">Sube una demo para renderizar las estadísticas</p>
                </div>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/subirArchivo.js') }}"></script>
</x-app-layout>