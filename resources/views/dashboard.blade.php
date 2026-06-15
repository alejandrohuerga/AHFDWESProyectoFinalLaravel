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
                        <x-demo-upload input-name="file" required />
                        <button type="submit" id="btn-analyze" class="mt-6 px-10 py-3 bg-white text-black font-black rounded-xl hover:bg-gray-200 disabled:bg-white/10 disabled:text-white/20 disabled:cursor-not-allowed transition-all shadow-[0_0_20px_rgba(255,255,255,0.1)]">
                                ANALIZAR PARTIDA
                            </button>
                            <a href="{{ route('demo.ejemplo') }}" class="mt-4 px-6 py-2.5 border border-white/20 text-white/70 font-bold rounded-xl hover:bg-white/10 hover:text-white hover:border-white/40 transition-all text-sm tracking-wide">
                                DESCARGAR DEMO DE EJEMPLO
                            </a>
                    </form>
                </div>
            </div>
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 rounded-xl">
                    <p class="font-bold flex items-center"><span class="mr-2">✔</span> {{ session('success') }}</p>
                </div>
            @endif
            @if(session('stats'))
                <x-scoreboard-table :players="session('stats')" title="SCOREBOARD_GENERAL" :show-aces="true" />
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
