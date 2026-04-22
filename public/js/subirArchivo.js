document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('demo-input');
    const labelFile = document.getElementById('label-file');
    const statusInitial = document.getElementById('status-initial');
    const statusSelected = document.getElementById('status-selected');
    const fileNameDisplay = document.getElementById('file-name-display');
    const btnAnalyze = document.getElementById('btn-analyze');
    const uploadForm = document.getElementById('upload-form');

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            if (this.files && this.files.length > 0) {
                const fileName = this.files[0].name;
                
                // 1. Interfaz de archivo seleccionado
                fileNameDisplay.textContent = fileName;
                statusInitial.classList.add('hidden');
                statusSelected.classList.remove('hidden');

                // 2. Estilo visual de éxito
                labelFile.classList.remove('border-blue-200', 'text-blue-600');
                labelFile.classList.add('border-emerald-400', 'bg-emerald-50');

                // 3. Habilitar botón
                btnAnalyze.disabled = false;
                btnAnalyze.classList.remove('bg-slate-300', 'cursor-not-allowed');
                btnAnalyze.classList.add('bg-blue-600', 'hover:bg-blue-700', 'shadow-blue-200');
            }
        });
    }

    // Efecto de carga al enviar
    if (uploadForm) {
        uploadForm.addEventListener('submit', function() {
            btnAnalyze.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Analizando...
            `;
            btnAnalyze.classList.add('opacity-75', 'cursor-wait');
        });
    }
});