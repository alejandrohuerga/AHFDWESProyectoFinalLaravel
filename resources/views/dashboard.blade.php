<x-app-layout>
    <x-slot name="header">
        <h2>Subir Archivo</h2>
    </x-slot>

    <div class="container">
        <!-- Formulario para subir archivo -->
        <form action="{{ route('demo.guardar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <!-- Campo para elegir el archivo -->
                <input type="file" name="file" required>
            </div>
            <div>
                <!-- Botón para enviar el formulario -->
                <button type="submit">Subir archivo</button>
            </div>
        </form>

        <!-- Mostrar mensajes de éxito o error -->
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif
        
        <!-- Mostrar errores de validación del archivo-->
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</x-app-layout>