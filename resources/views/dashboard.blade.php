<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            MANTENIMIENTO DEPARTAMENTOS
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Nombre</th>
                            <th class="border border-gray-300 px-4 py-2">Fecha Alta</th>
                            <th class="border border-gray-300 px-4 py-2">Volumen Negocio</th>
                            <th class="border border-gray-300 px-4 py-2">Fecha Baja</th>
                            <th class="border border-gray-300 px-4 py-2">Mostrar Departamento</th>
                        </tr>
                    </thead>
                        @foreach ($departamentos as $depto)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    {{ $depto->CodDepartamento }} 
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $depto->DescDepartamento }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    {{ $depto->FechaCreacionDepartamento }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    {{ $depto->VolumenDeNegocio }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    {{ $depto->FechaBajaDepartamento }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <a href="{{ route('departamentos.mostrarDepartamento', $depto->CodDepartamento) }}">Ver</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($departamentos->isEmpty())
                    <p class="mt-4 text-red-500">No hay departamentos registrados.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
