<x-app-layout>
    {{-- Fondo con gradiente suave para que el Glassmorphism resalte --}}
    <div class="min-h-screen bg-gradient-to-br from-black-100 to-black-300 py-12 px-4 relative overflow-hidden">
        
        {{-- Decoración de fondo --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-cyan-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-200/30 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            
            <div class="mb-12">
                <h2 class="text-4xl font-black text-white-800 tracking-tighter uppercase italic">
                    Ranking <span class="text-cyan-600">Jugadores</span>
                </h2>
                <div class="h-1 w-20 bg-cyan-500 mt-2 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse ($jugadores as $jugador)
                    <a href="{{ route('jugadores.show', $jugador->id) }}" 
                       class="group relative bg-white/40 backdrop-blur-xl border border-white/60 rounded-[2rem] overflow-hidden shadow-[0_10px_30px_rgba(0,0,0,0.03)] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)]">
                        
                        <div class="p-8 relative z-10">
                            {{-- Cabecera de Tarjeta --}}
                            <div class="flex items-center space-x-5">
                                {{--  
                                <div class="w-20 h-20 rounded-2xl bg-white shadow-lg overflow-hidden border-2 border-white transform group-hover:rotate-3 transition-transform duration-500">
                                    <img src="{{ $jugador->foto_url ?? 'ruta/a/silueta.png' }}" class="w-full h-full object-cover">
                                </div>
                                --}}
                                <div class="flex-1">
                                    <h3 class="text-2xl font-black text-white-800 uppercase tracking-tighter leading-tight">
                                        {{ $jugador->nombreJugador }}
                                    </h3>
                                    <span class="inline-block mt-1 bg-white-500/10 text-white-700 px-3 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-cyan-500/20">
                                        {{ $jugador->nombreEquipo }}
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Grid de Stats rápidas --}}
                            <div class="mt-8 grid grid-cols-2 gap-4 border-t border-slate-200/60 pt-6">
                                <div class="flex flex-col bg-white/50 p-3 rounded-2xl border border-white/50 shadow-sm">
                                    <span class="text-slate-400 text-[9px] font-black uppercase tracking-widest">K/D Ratio</span>
                                    <span class="text-2xl font-black text-slate-800">{{ number_format($jugador->KD_ratio, 2) }}</span>
                                </div>
                                <div class="flex flex-col bg-white/50 p-3 rounded-2xl border border-white/50 shadow-sm">
                                    <span class="text-slate-400 text-[9px] font-black uppercase tracking-widest">Impact</span>
                                    <span class="text-2xl font-black text-cyan-600">{{ number_format($jugador->rating_de_impacto, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Overlay al hacer Hover (Efecto cristal de color) --}}
                        <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-6">
                            <span class="bg-slate-900 text-white font-black px-6 py-2 rounded-xl text-[10px] tracking-widest uppercase shadow-xl transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                Ver Perfil Full
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-20 text-center bg-white/30 backdrop-blur-md rounded-[2.5rem] border-2 border-dashed border-white/60">
                        <p class="text-slate-400 font-bold uppercase tracking-widest">No hay jugadores registrados en la base de datos.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
