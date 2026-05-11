<x-app-layout>
    <div class="py-12 bg-[#0a0a0a] min-h-screen relative overflow-hidden">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-900/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-900/10 rounded-full blur-[120px]"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 overflow-hidden shadow-2xl sm:rounded-2xl mb-12">
                <div class="p-8">
                    <h3 class="text-xl font-bold text-white mb-2 text-center tracking-tight">Importar Demo XL</h3>
                    <form action="{{ route('demo.guardar') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center" id="upload-form">
                        <p class="text-white/30 text-[11px] text-center uppercase tracking-[0.2em] mb-6">Subida optimizada para archivos grandes</p>
                        <div class="flex flex-col items-center">
                            <div class="w-full max-w-md">
                                <label for="demo-input" id="label-file"
                                    class="relative flex flex-col items-center px-4 py-8 bg-white/5 text-white rounded-xl border-2 border-dashed border-white/20 cursor-pointer hover:bg-white/10 hover:border-white/40 transition-all group">
                                    <div id="status-initial" class="flex flex-col items-center">
                                        <svg class="w-10 h-10 mb-3 text-white/60 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <span class="text-sm font-semibold tracking-wide">Selecciona un archivo .dem</span>
                                        <span class="text-[10px] text-white/30 mt-1 uppercase tracking-[0.2em]">Sin límite de tamaño</span>
                                    </div>
                                    <div id="status-selected" class="hidden flex-col items-center text-white">
                                        <svg class="w-10 h-10 mb-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span id="file-name-display" class="text-sm font-bold truncate max-w-xs">Nombre del archivo</span>
                                        <span id="file-size-display" class="text-[10px] text-white/40 mt-1 uppercase tracking-[0.2em]"></span>
                                    </div>
                                    <input type="file" id="demo-input" class="hidden" accept=".dem" />
                                </label>
                            </div>
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
                        </div>
                    </form>
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
