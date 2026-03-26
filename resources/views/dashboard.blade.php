<x-app-layout>
    <x-slot name="header">
        <h2>Subir Archivo</h2>
    </x-slot>

    <div class="container">
        <!-- Formulario para subir archivo -->
        <form action="{{ route('demo.guardar') }}" method="POST" enctype="multipart/form-data">
            <!--Token de seguridad para evitar ataques CSRF (Cross-Site Request Forgery) -->
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

        <!-- Mostrar errores de validación del archivo (IMPORTANTE PARA DEPURACIÓN) -->
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Mostrar la tabla de resultados según subamos el archivo -->
        <pre>
            {{ var_dump(session('stats')) }}
        </pre>        
        @if(session('stats'))
            <div class="mt-8">
                <h3>Resultados del Partido</h3>
                <table border="1" style="width: 100%; text-align: left; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th>Nombre</th>
                            <th>Kills</th>
                            <th>Muertes</th>
                            <th>Asistencias</th>
                            <th>K/D</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('stats') as $jugador)
                            <tr>
                                <td>{{ $jugador['name'] ?? 'Jugador' }}</td>
                                <td>{{ $jugador['kills_total'] ?? 0 }}</td>
                                <td>{{ $jugador['deaths_total'] ?? 0 }}</td>
                                <td>{{ $jugador['mvps'] ?? 0 }}</td>
                                <td>{{ $jugador['score'] ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>