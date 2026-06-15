<x-app-layout>
    <div class="py-12 bg-[#0a0a0a] min-h-screen relative overflow-hidden">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-900/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-900/10 rounded-full blur-[120px]"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 overflow-hidden shadow-2xl sm:rounded-2xl mb-12">
                <div class="p-8">
                    <h3 class="text-xl font-bold text-white mb-2 text-center tracking-tight">Importar Demo XL</h3>
                    <p class="text-white/30 text-[11px] text-center uppercase tracking-[0.2em] mb-6">Subida optimizada para archivos grandes</p>

                    {{-- SIN form, la subida la gestiona el JS por chunks --}}
                    <div class="flex flex-col items-center">
                        <x-demo-upload :show-size-hint="true" />

                        {{-- Barra de progreso --}}
                        <div id="progreso-container" class="w-full max-w-md mt-5" style="display:none;">
                            <div class="w-full bg-white/5 rounded-full h-2 border border-white/10">
                                <div id="barra-interior" class="h-2 rounded-full transition-all duration-300" style="width:0%; background: linear-gradient(90deg, #009FE3, #00e5ff);"></div>
                            </div>
                            <p id="progreso-texto" class="text-center text-[11px] text-white/50 uppercase tracking-[0.2em] mt-2">PREPARANDO...</p>
                            <p id="progreso-detalle" class="text-center text-[10px] text-white/20 tracking-wider mt-1"></p>
                        </div>

                        {{-- Mensaje de error --}}
                        <div id="mensaje-error" class="hidden w-full max-w-md mt-4 p-4 bg-red-500/10 border border-red-500/50 text-red-400 rounded-xl text-sm"></div>

                        <button id="btn-analyze" disabled
                            class="mt-6 px-10 py-3 bg-white text-black font-black rounded-xl hover:bg-gray-200 disabled:bg-white/10 disabled:text-white/20 disabled:cursor-not-allowed transition-all shadow-[0_0_20px_rgba(255,255,255,0.1)]">
                            ANALIZAR PARTIDA
                        </button>
                        <a href="{{ route('demo.ejemplo') }}" class="mt-4 px-6 py-2.5 border border-white/20 text-white/70 font-bold rounded-xl hover:bg-white/10 hover:text-white hover:border-white/40 transition-all text-sm tracking-wide">
                            DESCARGAR DEMO DE EJEMPLO
                        </a>
                    </div>

                    {{-- Config para el JS --}}
                    <div id="js-config"
                        data-chunk-url="{{ route('demo-xl.chunk') }}"
                        data-ensamblar-url="{{ route('demo-xl.ensamblar') }}"
                        data-csrf="{{ csrf_token() }}"
                        style="display:none;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/subirArchivoXL.js') }}"></script>
</x-app-layout>
