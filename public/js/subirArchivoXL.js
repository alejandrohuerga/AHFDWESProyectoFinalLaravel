document.addEventListener('DOMContentLoaded', function () {
    const fileInput         = document.getElementById('demo-input');
    const labelFile         = document.getElementById('label-file');
    const statusInitial     = document.getElementById('status-initial');
    const statusSelected    = document.getElementById('status-selected');
    const fileNameDisplay   = document.getElementById('file-name-display');
    const fileSizeDisplay   = document.getElementById('file-size-display');
    const btnAnalyze        = document.getElementById('btn-analyze');
    const progresoContainer = document.getElementById('progreso-container');
    const barraInterior     = document.getElementById('barra-interior');
    const progresoTexto     = document.getElementById('progreso-texto');
    const progresoDetalle   = document.getElementById('progreso-detalle');
    const mensajeError      = document.getElementById('mensaje-error');
    const config            = document.getElementById('js-config');

    const CHUNK_URL     = config.dataset.chunkUrl;
    const ENSAMBLAR_URL = config.dataset.ensamblarUrl;
    const CSRF_TOKEN    = config.dataset.csrf;
    const CHUNK_SIZE    = 10 * 1024 * 1024; // 10MB por chunk

    console.log('✅ Demo XL JS cargado');
    console.log('Chunk URL:', CHUNK_URL);
    console.log('Ensamblar URL:', ENSAMBLAR_URL);

    // ── Selección de archivo ──────────────────────────────────────────
    fileInput.addEventListener('change', function () {
        if (!this.files || this.files.length === 0) return;

        const file     = this.files[0];
        const sizeMB   = (file.size / (1024 * 1024)).toFixed(1);
        const chunks   = Math.ceil(file.size / CHUNK_SIZE);

        fileNameDisplay.textContent = file.name;
        fileSizeDisplay.textContent = `${sizeMB} MB · ${chunks} partes`;
        statusInitial.classList.add('hidden');
        statusSelected.classList.remove('hidden');
        statusSelected.classList.add('flex');
        labelFile.style.borderColor = '#34d399';
        mensajeError.classList.add('hidden');

        btnAnalyze.disabled = false;
        btnAnalyze.style.backgroundColor = '#ffffff';
        btnAnalyze.style.color = '#000000';
        btnAnalyze.style.cursor = 'pointer';
        btnAnalyze.style.opacity = '1';
    });

    // ── Click en el botón ─────────────────────────────────────────────
    btnAnalyze.addEventListener('click', subirPorChunks);

    async function subirPorChunks() {
        const file = fileInput.files[0];
        if (!file) return;

        const totalChunks = Math.ceil(file.size / CHUNK_SIZE);
        const uploadId    = crypto.randomUUID();

        btnAnalyze.disabled = true;
        btnAnalyze.style.opacity = '0.6';
        btnAnalyze.textContent = 'SUBIENDO...';
        progresoContainer.style.display = 'block';
        mensajeError.classList.add('hidden');

        try {
            // 1. Subir chunks
            for (let i = 0; i < totalChunks; i++) {
                const inicio = i * CHUNK_SIZE;
                const fin    = Math.min(inicio + CHUNK_SIZE, file.size);
                const chunk  = file.slice(inicio, fin);

                const formData = new FormData();
                formData.append('chunk', chunk, 'chunk');
                formData.append('chunkIndex', i);
                formData.append('uploadId', uploadId);
                formData.append('_token', CSRF_TOKEN);

                const res = await fetch(CHUNK_URL, { method: 'POST', body: formData });

                if (!res.ok) {
                    const texto = await res.text();
                    throw new Error(`Error en parte ${i + 1}: ${res.status}`);
                }

                const porcentaje = Math.round(((i + 1) / totalChunks) * 70);
                actualizarBarra(porcentaje, `SUBIENDO... ${porcentaje}%`, `Parte ${i + 1} de ${totalChunks}`);
            }

            // 2. Ensamblar
            actualizarBarra(72, 'ENSAMBLANDO ARCHIVO...', 'Uniendo todas las partes');
            btnAnalyze.textContent = 'PROCESANDO...';

            const formEnsamblar = new FormData();
            formEnsamblar.append('uploadId', uploadId);
            formEnsamblar.append('totalChunks', totalChunks);
            formEnsamblar.append('_token', CSRF_TOKEN);

            actualizarBarra(80, 'ANALIZANDO DEMO...', 'Esto puede tardar varios minutos');

            const resEnsamblar = await fetch(ENSAMBLAR_URL, { method: 'POST', body: formEnsamblar });
            const data = await resEnsamblar.json();

            if (data.error) throw new Error(data.error);

            // 3. Éxito
            actualizarBarra(100, '✔ ANÁLISIS COMPLETADO', '');
            btnAnalyze.textContent = '✔ COMPLETADO';

            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1000);

        } catch (err) {
            console.error('❌ Error:', err.message);
            mensajeError.classList.remove('hidden');
            mensajeError.textContent = 'Error: ' + err.message;
            btnAnalyze.disabled = false;
            btnAnalyze.style.opacity = '1';
            btnAnalyze.textContent = 'ANALIZAR PARTIDA';
            progresoContainer.style.display = 'none';
        }
    }

    function actualizarBarra(porcentaje, texto, detalle) {
        barraInterior.style.width = porcentaje + '%';
        progresoTexto.textContent = texto;
        progresoDetalle.textContent = detalle;
    }
});