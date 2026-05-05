<nav x-data="{ open: false }" class="bg-black/40 backdrop-blur-2xl border-b border-white/5 sticky top-0 z-50 shadow-[0_4px_30px_rgba(0,0,0,0.1)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-28"> 
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group flex items-center gap-2">
                        <img src="/images/logos/logo-SinFondo.png" alt="Parser CS2" class="h-20 w-auto object-contain drop-shadow-[0_0_15px_rgba(255,255,255,0.1)] group-hover:drop-shadow-[0_0_20px_rgba(6,182,212,0.5)] transition-all duration-500">
                    </a>
                </div>
                <div class="hidden space-x-10 sm:-my-px sm:ms-12 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="!text-white/70 hover:!text-white text-[10px] font-black uppercase tracking-[0.3em] transition-all duration-300 border-b-2 py-11
                        {{ request()->routeIs('dashboard') ? 'border-cyan-500 !text-white drop-shadow-[0_0_10px_rgba(6,182,212,0.5)]' : 'border-transparent' }}">
                        {{ __('Subir Archivos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('analisis')" :active="request()->routeIs('analisis')"
                        class="!text-white/70 hover:!text-white text-[10px] font-black uppercase tracking-[0.3em] transition-all duration-300 border-b-2 py-11
                        {{ request()->routeIs('analisis') ? 'border-cyan-500 !text-white drop-shadow-[0_0_10px_rgba(6,182,212,0.5)]' : 'border-transparent' }}">
                        {{ __('Análisis') }}
                    </x-nav-link>
                    <x-nav-link :href="route('jugadores')" :active="request()->routeIs('jugadores')"
                        class="!text-white/70 hover:!text-white text-[10px] font-black uppercase tracking-[0.3em] transition-all duration-300 border-b-2 py-11
                        {{ request()->routeIs('jugadores') ? 'border-cyan-500 !text-white drop-shadow-[0_0_10px_rgba(6,182,212,0.5)]' : 'border-transparent' }}">
                        {{ __('Jugadores') }}
                    </x-nav-link>
                    <x-nav-link :href="route('ayuda')" :active="request()->routeIs('ayuda')"
                        class="!text-white/70 hover:!text-white text-[10px] font-black uppercase tracking-[0.3em] transition-all duration-300 border-b-2 py-11
                        {{ request()->routeIs('ayuda') ? 'border-cyan-500 !text-white drop-shadow-[0_0_10px_rgba(6,182,212,0.5)]' : 'border-transparent' }}">
                        {{ __('Ayuda') }}
                    </x-nav-link>
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-5 py-3 border border-white/10 text-[10px] tracking-[0.2em] font-black rounded-xl bg-white/5 text-white hover:bg-white/10 hover:border-cyan-500/50 transition-all duration-500 focus:outline-none">
                            <span class="w-1.5 h-1.5 bg-cyan-500 rounded-full animate-pulse mr-2.5 shadow-[0_0_8px_#06b6d4]"></span>
                            <div class="uppercase">{{ Auth::user()->name }}</div>
                            <svg class="ms-2 h-4 w-4 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="bg-[#0f0f0f]/95 backdrop-blur-xl border border-white/10 rounded-lg overflow-hidden shadow-2xl">
                            <x-dropdown-link :href="route('profile.edit')" class="!text-white/80 hover:!bg-cyan-500/20 hover:!text-white text-[10px] uppercase tracking-widest py-3">
                                {{ __('Perfil') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" class="!text-red-400/80 hover:!bg-red-500/10 hover:!text-red-400 text-[10px] uppercase tracking-widest py-3"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Cerrar Sesión') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-3 rounded-lg text-white/50 hover:text-cyan-500 hover:bg-white/5 transition-all">
                    <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-black/90 backdrop-blur-2xl border-t border-white/5">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="!text-white border-l-4 border-cyan-500 bg-cyan-500/10">
                {{ __('Subir Archivos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('analisis')" :active="request()->routeIs('analisis')" class="!text-white/70 border-l-4 border-transparent">
                {{ __('Análisis') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>