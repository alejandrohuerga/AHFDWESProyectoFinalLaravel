<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf
        <!-- Nombre -->
        <div>
            <label class="block text-sm font-semibold text-white mb-2 ml-1">
                Nombre
            </label>
            <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" required autofocus
                class="block w-full px-4 py-3 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl text-white placeholder-gray-200 focus:outline-none focus:ring-2 focus:ring-white/50 transition"
                placeholder="Tu nombre"/>
            <x-input-error :messages="$errors->get('nombre')" class="mt-2 text-xs text-red-300" />
        </div>
        <!-- Correo -->
        <div>
            <label class="block text-sm font-semibold text-white mb-2 ml-1">
                Correo
            </label>
            <input id="correo" name="correo" type="email" value="{{ old('correo') }}" required
                class="block w-full px-4 py-3 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl text-white placeholder-gray-200 focus:outline-none focus:ring-2 focus:ring-white/50 transition"
                placeholder="correo@email.com"/>
            <x-input-error :messages="$errors->get('correo')" class="mt-2 text-xs text-red-300" />
        </div>
        <!-- Password -->
        <div>
            <label class="block text-sm font-semibold text-white mb-2 ml-1">
                Contraseña
            </label>
            <input id="password" name="password" type="password" required
                class="block w-full px-4 py-3 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-white/50 transition"
                placeholder="••••••••"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-300" />
        </div>
        <!-- Confirmar Password -->
        <div>
            <label class="block text-sm font-semibold text-white mb-2 ml-1">
                Confirmar contraseña
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                class="block w-full px-4 py-3 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-white/50 transition"
                placeholder="••••••••"/>
        </div>
        <!-- Botón -->
        <div>
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 rounded-xl text-sm font-bold text-gray-900 bg-white hover:bg-gray-100 transition-all">
                Registrarse
            </button>
        </div>
        <!-- Link a login -->
        <div class="text-center">
            <a href="{{ route('login') }}"
               class="text-sm text-white/70 hover:text-white underline">
                ¿Ya tienes cuenta? Inicia sesión
            </a>
        </div>
    </form>
</x-guest-layout>