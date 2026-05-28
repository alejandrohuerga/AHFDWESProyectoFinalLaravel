<x-app-layout>
    <div class="relative min-h-screen">
        <div class="absolute inset-0 z-0">
            <img src="/images/logos/fondoLogin.jpg" class="w-full h-full object-cover" alt="Background">
            <div class="absolute inset-0 bg-black/20"></div>
        </div>

        <div class="relative z-10 flex justify-center py-12 px-4">
            <div class="w-full sm:max-w-md px-8 py-10 bg-white/10 backdrop-blur-xl border border-white/40 shadow-2xl rounded-3xl">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 mx-auto rounded-full bg-white/20 backdrop-blur-md border-2 border-white/40 flex items-center justify-center shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h1 class="mt-4 text-2xl font-bold text-white drop-shadow-lg">{{ __('Mi Perfil') }}</h1>
                </div>

                <div class="border-t border-white/20 pt-6">
                    <p class="text-sm font-semibold text-white/70 mb-4 uppercase tracking-wider">{{ __('Información Personal') }}</p>

                    <div class="space-y-5">
                        <div>
                            <label for="nombre" class="block text-sm font-semibold text-white mb-2 ml-1 drop-shadow-sm">
                                {{ __('Nombre de usuario') }}
                            </label>
                            <input id="nombre" name="nombre" type="text" value="{{ $user->nombre }}" disabled
                                class="block w-full px-4 py-3 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl text-white/90 placeholder-gray-200 cursor-not-allowed select-none shadow-sm" />
                        </div>
                        <div>
                            <label for="correo" class="block text-sm font-semibold text-white mb-2 ml-1 drop-shadow-sm">
                                {{ __('Correo Electrónico') }}
                            </label>
                            <input id="correo" name="correo" type="email" value="{{ $user->correo }}" disabled
                                class="block w-full px-4 py-3 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl text-white/90 placeholder-gray-200 cursor-not-allowed select-none shadow-sm" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
