<div>
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            DETALLES DEL DEPARTAMENTO
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h3>Información de: {{$departamento -> DescDepartamento}}</h3>
            </div>
            <div class="grid grid-cols-1 gap-4">
                        <div class="flex">
                            <span class="font-bold w-48">Código / ID:</span>
                            <span>{{ $departamento->CodDepartamento }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-bold w-48">Nombre del Depto:</span>
                            <span>{{ $departamento->DescDepartamento }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-bold w-48">Volumen de Negocio:</span>
                            <span class="text-green-600 font-semibold">
                                {{ number_format($departamento->VolumenDeNegocio, 2, ',', '.') }} €
                            </span>
                        </div>
                        <div class="flex">
                            <span class="font-bold w-48">Fecha de Baja:</span>
                            <span>
                                {{ $departamento->FechaBajaDepartamento ?? 'Actualmente en activo' }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-8 border-t pt-4">
                        <a href="{{ route('dashboard') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            &larr; Volver al Dashboard
                        </a>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>
</div>
