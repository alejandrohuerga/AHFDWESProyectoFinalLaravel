<x-app-layout>
    <div class="min-h-screen bg-gray-950 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            {{-- Botón Volver --}}
            <a href="{{ route('jugadores') }}" class="inline-flex items-center text-cyan-500 font-bold mb-8 hover:text-white transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                VOLVER AL RANKING
            </a>

            {{-- Contenedor Principal Mitad y Mitad --}}
            <div class="bg-black border-4 border-cyan-500 rounded-3xl overflow-hidden shadow-[0_0_50px_rgba(6,182,212,0.4)]">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    
                    {{-- COLUMNA IZQUIERDA: INFO DEL JUGADOR --}}
                    <div class="flex flex-col border-b-4 lg:border-b-0 lg:border-r-4 border-cyan-500">
                        {{-- Cabecera con Foto y Nombre --}}
                        <div class="bg-gradient-to-r from-cyan-900 to-black p-8 flex items-center space-x-6 border-b-2 border-white/10">
                            <div class="w-32 h-32 rounded-full border-4 border-white shadow-2xl overflow-hidden shrink-0">
                                <img src="{{ $info->foto_url ?? 'silueta.png' }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic leading-none">
                                    {{ $info->nombreJugador }}
                                </h1>
                                <span class="inline-block mt-2 bg-white text-black px-3 py-1 font-black rounded-full text-xs uppercase">
                                    {{ $info->nombreEquipo }}
                                </span>
                            </div>
                        </div>

                        {{-- Stats Detalladas --}}
                        <div class="p-8 relative">
                            <div class="absolute top-5 right-5 text-6xl font-black text-white/5 pointer-events-none uppercase">STATS</div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                                    <p class="text-white/40 text-[10px] font-bold uppercase">K/D Ratio</p>
                                    <p class="text-3xl font-black text-white">{{ number_format($info->KD_ratio, 2) }}</p>
                                </div>
                                <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                                    <p class="text-white/40 text-[10px] font-bold uppercase">Impact</p>
                                    <p class="text-3xl font-black text-cyan-400">{{ $info->rating_de_impacto }}</p>
                                </div>
                            </div>

                            <div class="mt-6 bg-cyan-500/10 p-4 rounded-xl border border-cyan-500/30">
                                <div class="flex justify-around text-center">
                                    <div><p class="text-white/50 text-[9px] uppercase italic font-bold">K/R</p><p class="text-xl font-black text-white">{{ $info->bajas_por_ronda }}</p></div>
                                    <div><p class="text-white/50 text-[9px] uppercase italic font-bold">D/R</p><p class="text-xl font-black text-white">{{ $info->muertes_por_ronda }}</p></div>
                                    <div><p class="text-white/50 text-[9px] uppercase italic font-bold">A/R</p><p class="text-xl font-black text-white">{{ $info->asistencias_por_ronda }}</p></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- COLUMNA DERECHA: GRÁFICA --}}
                    <div class="bg-white/[0.02] p-10 flex flex-col items-center justify-center min-h-[400px]">
                        <div class="text-center mb-6">
                            <h3 class="text-cyan-400 font-black uppercase tracking-[0.2em] text-sm">Visual Analytics</h3>
                            <p class="text-white/30 text-[10px] uppercase mt-1">Kill/Death Distribution Per Round</p>
                        </div>
                        
                        <div class="w-full max-w-md mx-auto">
                            {!! $grafica->container() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {!! $grafica->script() !!}
</x-app-layout>
