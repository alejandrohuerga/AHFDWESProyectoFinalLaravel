<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        <div>
            <label for="nombre" class="block text-sm font-semibold text-white mb-2 ml-1 drop-shadow-sm">
                {{ __('Nombre de usuario') }}
            </label>
            <div class="relative">
                <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" required autofocus 
                    class="block w-full px-4 py-3 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl text-white placeholder-gray-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent transition duration-200 ease-in-out shadow-sm" 
                    placeholder="Tu nombre"/>
            </div>
            <x-input-error :messages="$errors->get('nombre')" class="mt-2 text-xs text-red-300" />
        </div>
        <div>
            <label for="password" class="block text-sm font-semibold text-white mb-2 ml-1 drop-shadow-sm">
                {{ __('Contraseña') }}
            </label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                class="block w-full px-4 py-3 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl text-white placeholder-gray-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent transition duration-200 ease-in-out shadow-sm"
                placeholder="••••••••"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-300" />
        </div>
        <div class="flex items-center justify-between mt-2 px-1">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-md border-white/40 bg-white/20 text-gray-800 shadow-sm focus:ring-0 transition duration-150" name="remember">
                <span class="ms-2 text-sm text-white/90 group-hover:text-white transition-colors">{{ __('Recordarme') }}</span>
            </label>
        </div>
        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-gray-900 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-all duration-200 transform active:scale-[0.98]">
                {{ __('Iniciar Sesión') }}
            </button>
        </div>
        <div class="pt-2">
            <a href="{{ route('register') }}" class="w-full flex justify-center py-3 px-4 border border-white/30 rounded-xl shadow-lg text-sm font-bold text-white bg-transparent hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-all duration-200 transform active:scale-[0.98]">
                {{ __('Registrarse') }}
            </a>
        </div>
    </form>
</x-guest-layout>
