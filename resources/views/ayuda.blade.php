<x-app-layout>
    <div class="flex items-center justify-center min-h-[60vh]">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Documento 1 -->
            <a href="{{ asset('doc/PROYECTO FINAL DESARROLLO APLICACIONES WEB ESTUDIO LARAVEL 7.0.0.pdf') }}" target="_blank" class="group flex flex-col items-center text-center transition-all duration-300">
                <div class="mb-4 p-6 bg-white/10 rounded-2xl group-hover:bg-white/20 group-hover:scale-110 transition-all border border-white/5 backdrop-blur-sm">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span class="text-white/70 group-hover:text-white text-[10px] font-black uppercase tracking-[0.3em] transition-colors">
                    {{ __('Estudio Aplicación') }}
                </span>
            </a>
            <!-- Documento 2 -->
            <a href="{{ asset('doc/ManualArchivosDemo.pdf') }}" target="_blank" class="group flex flex-col items-center text-center transition-all duration-300">
                <div class="mb-4 p-6 bg-white/10 rounded-2xl group-hover:bg-white/20 group-hover:scale-110 transition-all border border-white/5 backdrop-blur-sm">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span class="text-white/70 group-hover:text-white text-[10px] font-black uppercase tracking-[0.3em] transition-colors">
                    {{ __('Guía Archivos Demo') }}
                </span>
            </a>
            <!-- Documento 3 -->
            {{-- <a href="{{ asset('doc/DiagramaCasosDeUso.pdf') }}" target="_blank" class="group flex flex-col items-center text-center transition-all duration-300">
                <div class="mb-4 p-6 bg-white/10 rounded-2xl group-hover:bg-white/20 group-hover:scale-110 transition-all border border-white/5 backdrop-blur-sm">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
                <span class="text-white/70 group-hover:text-white text-[10px] font-black uppercase tracking-[0.3em] transition-colors">
                    {{ __('Diagrama Casos De Uso') }}
                </span>
            </a> --}}
        </div>
    </div>
</x-app-layout>
