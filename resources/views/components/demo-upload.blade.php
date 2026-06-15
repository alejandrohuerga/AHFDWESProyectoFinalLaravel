@props(['inputName' => 'file', 'inputId' => 'demo-input', 'showSizeHint' => false])

<div class="w-full max-w-md">
    <label for="{{ $inputId }}" id="label-file"
        class="relative flex flex-col items-center px-4 py-8 bg-white/5 text-white rounded-xl border-2 border-dashed border-white/20 cursor-pointer hover:bg-white/10 hover:border-white/40 transition-all group">
        <div id="status-initial" class="flex flex-col items-center">
            <svg class="w-10 h-10 mb-3 text-white/60 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <span class="text-sm font-semibold tracking-wide">Selecciona un archivo .dem</span>
            @if($showSizeHint)
                <span class="text-[10px] text-white/30 mt-1 uppercase tracking-[0.2em]">Sin límite de tamaño</span>
            @endif
        </div>
        <div id="status-selected" class="hidden flex-col items-center text-white">
            <svg class="w-10 h-10 mb-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
            </svg>
            <span id="file-name-display" class="text-sm font-bold truncate max-w-xs">Nombre del archivo</span>
            <span id="file-size-display" class="text-[10px] text-white/40 mt-1 uppercase tracking-[0.2em]"></span>
        </div>
        <input type="file" id="{{ $inputId }}" name="{{ $inputName }}" class="hidden" accept=".dem" {{ $attributes }} />
    </label>
</div>
