<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight tracking-widest uppercase">
            🏆 Ranking de Jugadores 2026
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($jugadores as $jugador)
                    <a href="{{ route('jugadores.show', $jugador->id) }}" class="block relative bg-black border-2 border-cyan-500 rounded-2xl overflow-hidden shadow-[0_0_20px_rgba(6,182,212,0.3)] transition-all hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(6,182,212,0.5)] group">
                        
                        <div class="p-6 relative z-10">
                            <div class="flex items-center space-x-5">
                                <div class="w-20 h-20 rounded-full bg-cyan-900 overflow-hidden border-2 border-white">
                                    <img src="{{ $jugador->foto_url ?? 'ruta/a/silueta.png' }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-3xl font-black text-white uppercase">{{ $jugador->nombreJugador }}</h3>
                                    <span class="text-cyan-400 text-xs font-bold uppercase">{{ $jugador->nombreEquipo }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-8 grid grid-cols-2 gap-4 border-t border-white/20 pt-6">
                                <div class="flex flex-col">
                                    <span class="text-white/50 text-[10px] uppercase">K/D Ratio</span>
                                    <span class="text-xl font-bold text-white">{{ number_format($jugador->KD_ratio, 2) }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-white/50 text-[10px] uppercase">Rating</span>
                                    <span class="text-xl font-bold text-cyan-400">{{ number_format($jugador->rating_de_impacto, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="absolute inset-0 bg-cyan-500/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="bg-cyan-500 text-black font-black px-4 py-2 rounded-full text-sm tracking-tighter">VER PERFIL COMPLETO</span>
                        </div>
                    </a>
                @empty
                    <p class="text-white">No hay jugadores.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
