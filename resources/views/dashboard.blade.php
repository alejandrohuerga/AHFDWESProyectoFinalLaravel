<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Análisis de Partidas CS2') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-8">
                <div class="p-8 border-b border-slate-100">
                    <h3 class="text-lg font-semibold text-slate-700 mb-4 text-center">Importar Nueva Demo</h3>
                    <form action="{{ route('demo.guardar') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                        @csrf
                        <div class="w-full max-w-md">
                            <label for="demo-input" class="relative flex flex-col items-center px-4 py-6 bg-slate-50 text-blue-600 rounded-lg shadow-sm border-2 border-dashed border-blue-200 cursor-pointer hover:bg-blue-50 transition-all" id="label-file">
                                
                                <div id="status-initial" class="flex flex-col items-center">
                                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <span class="text-sm font-medium">Selecciona un archivo .dem</span>
                                </div>

                                <div id="status-selected" class="hidden flex flex-col items-center text-emerald-600">
                                    <svg class="w-8 h-8 mb-2" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                                    <span id="file-name-display" class="text-sm font-bold truncate max-w-xs">Nombre del archivo</span>
                                    <span class="text-xs text-slate-400 mt-1 uppercase tracking-tighter">Archivo listo para procesar</span>
                                </div>

                                <input type='file' id="demo-input" name="file" class="hidden" required accept=".dem" />
                            </label>
                        </div>
                        <button type="submit" id="btn-analyze" class="mt-4 px-8 py-2.5 bg-slate-300 text-white font-bold rounded-lg cursor-not-allowed transition-all shadow-lg" disabled>
                            Analizar Partida
                        </button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-lg shadow-sm">
                    <p class="font-bold">¡Éxito!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-r-lg shadow-sm">
                    <p class="font-bold">Error de Procesamiento</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            @endif

            @if(session('stats'))
                <div class="bg-white shadow-xl shadow-slate-200/50 rounded-2xl overflow-hidden border border-slate-100">
                    <div class="px-6 py-5 bg-slate-800 flex justify-between items-center">
                        <h3 class="text-white font-bold text-lg">Scoreboard General</h3>
                        <span class="px-3 py-1 bg-slate-700 text-slate-300 text-xs rounded-full uppercase tracking-widest">Match Data</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                                    <th class="px-6 py-4 font-semibold">Jugador</th>
                                    <th class="px-6 py-4 text-center font-semibold">Kills</th>
                                    <th class="px-6 py-4 text-center font-semibold">Deaths</th>
                                    <th class="px-6 py-4 text-center font-semibold">MVPs</th>
                                    <th class="px-6 py-4 text-center font-semibold">Aces</th>
                                    <th class="px-6 py-4 text-right font-semibold">Score</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach(session('stats') as $player)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs mr-3">
                                                    {{ substr($player['name'] ?? '?', 0, 2) }}
                                                </div>
                                                <span class="font-bold text-slate-700">{{ $player['name'] ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center font-mono font-bold text-slate-800 text-lg">
                                            {{ $player['kills_total'] ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 text-center font-mono text-rose-500">
                                            {{ $player['deaths_total'] ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 text-center text-amber-500 font-bold">
                                            @if(($player['mvps'] ?? 0) > 0)
                                                ⭐ {{ $player['mvps'] }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-2 py-1 {{ ($player['ace_rounds_total'] ?? 0) > 0 ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-400' }} rounded text-xs font-bold">
                                                {{ $player['ace_rounds_total'] ?? 0 }}
                                            </td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="font-black text-slate-900 bg-slate-100 px-3 py-1 rounded-lg">
                                                {{ number_format($player['score'] ?? 0) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-2xl border border-dashed border-slate-300">
                    <p class="text-slate-400">No hay datos que mostrar. Sube una demo para comenzar el análisis.</p>
                </div>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/subirArchivo.js') }}"></script>
</x-app-layout>