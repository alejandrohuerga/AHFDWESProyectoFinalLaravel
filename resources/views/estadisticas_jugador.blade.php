<x-app-layout>
    {{-- Fondo con un gradiente suave para que el Glassmorphism resalte --}}
    <div class="min-h-screen bg-gradient-to-br from-black-100 to-black-300 py-12 px-4 relative overflow-hidden">
        {{-- Círculos decorativos de fondo para potenciar el efecto cristal --}}
        <div class="absolute top-0 -left-20 w-96 h-96 bg-cyan-200/40 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -right-20 w-96 h-96 bg-blue-200/40 rounded-full blur-3xl"></div>
        <div class="max-w-7xl mx-auto relative z-10">
            {{-- Botón Volver Minimalista --}}
            <a href="{{ route('jugadores') }}" class="inline-flex items-center text-slate-600 font-bold mb-8 hover:text-cyan-600 transition-all group">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="tracking-widest text-white text-xs">VOLVER AL RANKING</span>
            </a>

            {{-- Contenedor Principal Glassmorphism Blanco --}}
            <div class="bg-white/40 backdrop-blur-xl border border-white/60 rounded-[2.5rem] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.05)]">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    
                    {{-- COLUMNA IZQUIERDA: INFO DEL JUGADOR --}}
                    <div class="flex flex-col border-b border-white/20 lg:border-b-0 lg:border-r border-white/60">
                        
                        {{-- Cabecera Elegante --}}
                        <div class="bg-white/30 p-10 flex items-center space-x-8 border-b border-white/40">

                            {{--
                            <div class="w-32 h-32 rounded-3xl border-4 border-white shadow-xl overflow-hidden shrink-0 rotate-3 group hover:rotate-0 transition-transform duration-500">
                                <img src="{{ $info->foto_url ?? 'silueta.png' }}" class="w-full h-full object-cover shadow-inner">
                            </div>
                            --}}
                            <div>
                                <h1 class="text-4xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                                    {{ $info->nombreJugador }}
                                </h1>
                                <span class="inline-block mt-3 bg-cyan-500 text-white px-4 py-1 font-bold rounded-lg text-[10px] uppercase tracking-widest shadow-lg shadow-cyan-500/30">
                                    {{ $info->nombreEquipo }}
                                </span>
                            </div>
                        </div>
                        {{-- Stats Detalladas --}}
                        <div class="p-10 relative">
                            {{-- Texto de fondo decorativo --}}
                            <div class="absolute top-5 right-10 text-7xl font-black text-slate-900/[0.03] pointer-events-none uppercase tracking-tighter">DATA</div>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="bg-white/60 p-6 rounded-3xl border border-white shadow-sm hover:shadow-md transition-shadow">
                                    <p class="text-white-400 text-[10px] font-black uppercase tracking-widest mb-1">K/D Ratio</p>
                                    <p class="text-4xl font-black text-green-800">{{ number_format($info->KD_ratio, 2) }}</p>
                                </div>
                                <div class="bg-white/60 p-6 rounded-3xl border border-white shadow-sm hover:shadow-md transition-shadow">
                                    <p class="text-white-400 text-[10px] font-black uppercase tracking-widest mb-1">Impact</p>
                                    <p class="text-4xl font-black text-red-600">{{ $info->rating_de_impacto }}</p>
                                </div>
                            </div>
                            {{-- Barra de Stats Inferior --}}
                            <div class="mt-8 bg-slate-900/5 backdrop-blur-md p-6 rounded-[2rem] border border-white/20">
                                <div class="flex justify-around text-center">
                                    <div class="group">
                                        <p class="text-white-400 text-[12px] uppercase font-black mb-1 group-hover:text-cyan-500 transition-colors">K/R</p>
                                        <p class="text-2xl font-black text-slate-800">{{ $info->bajas_por_ronda }}</p>
                                    </div>
                                    <div class="group">
                                        <p class="text-white-400 text-[12px] uppercase font-black mb-1 group-hover:text-cyan-500 transition-colors">D/R</p>
                                        <p class="text-2xl font-black text-slate-800">{{ $info->muertes_por_ronda }}</p>
                                    </div>
                                    <div class="group">
                                        <p class="text-white-400 text-[12px] uppercase font-black mb-1 group-hover:text-cyan-500 transition-colors">A/R</p>
                                        <p class="text-2xl font-black text-slate-800">{{ $info->asistencias_por_ronda }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- COLUMNA DERECHA: GRÁFICA --}}
                    <div class="bg-white/20 p-10 flex flex-col items-center justify-center min-h-[450px]">
                        <div class="text-center mb-8">
                            <span class="bg-white/60 text-cyan-600 px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-sm border border-white">
                                Visual Analytics
                            </span>
                            <p class="text-white-500 text-[10px] uppercase font-bold mt-4 tracking-tight opacity-60">Kill/Death Distribution Per Round</p>
                        </div>
                    
                        <div class="w-full max-w-md mx-auto p-4 bg-white/40 rounded-[2rem] border border-white shadow-inner">
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
