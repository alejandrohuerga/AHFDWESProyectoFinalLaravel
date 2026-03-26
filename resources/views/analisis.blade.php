<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ANALISIS DE PARTIDOS
        </h2>
    </x-slot>
    <div class="container">
        @foreach ($partidosSubidosUsuario as $partido)
            <div class="card border-2 border-gray-300 rounded-lg shadow-md mb-4 w-1/3">
                <div class="card-body">
                    <h5 class="card-title">{{ $partido->nombre_original }}</h5>
                    <p class="card-text">{{ $partido->fecha_subida }}</p>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>