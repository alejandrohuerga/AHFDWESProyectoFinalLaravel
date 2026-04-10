<nav x-data="{ open: false }" class="bg-[#0b0e14]/90 backdrop-blur-xl border-b border-cyan-500/20 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group flex items-center gap-2">
                        <div class="w-8 h-8 bg-cyan-500 rounded-sm flex items-center justify-center rotate-45 group-hover:rotate-180 transition-transform duration-500 shadow-[0_0_15px_rgba(6,182,212,0.8)]">
                            <span class="text-black font-black -rotate-45 group-hover:-rotate-180 transition-transform duration-500">CS</span>
                        </div>
                        <span class="ms-3 text-xl font-black tracking-tighter text-white uppercase group-hover:drop-shadow-[0_0_10px_rgba(6,182,212,1)] transition-all duration-300">
                            Parser<span class="text-cyan-500">.io</span>
                        </span>
                    </a>
                </div>

                <div class="hidden space-x-10 sm:-my-px sm:ms-12 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="text-[11px] font-bold uppercase tracking-[0.25em] transition-all duration-300 border-b-2 py-5 text-white hover:drop-shadow-[0_0_10px_rgba(6,182,212,1)] focus:outline-none 
                        {{ request()->routeIs('dashboard') ? 'border-cyan-500 drop-shadow-[0_0_8px_rgba(6,182,212,0.8)]' : 'border-transparent' }}">
                        {{ __('Subir Archivos') }}
                    </x-nav-link>

                    <x-nav-link :href="route('analisis')" :active="request()->routeIs('analisis')"
                        class="text-[11px] font-bold uppercase tracking-[0.25em] transition-all duration-300 border-b-2 py-5 text-white hover:drop-shadow-[0_0_10px_rgba(6,182,212,1)] focus:outline-none
                        {{ request()->routeIs('analisis') ? 'border-cyan-500 drop-shadow-[0_0_8px_rgba(6,182,212,0.8)]' : 'border-transparent' }}">
                        {{ __('Análisis') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-1.5 border border-cyan-500/30 text-[10px] tracking-widest font-mono rounded-full bg-black text-white hover:drop-shadow-[0_0_8px_rgba(6,182,212,0.6)] transition-all duration-300 focus:outline-none">
                            <span class="w-2 h-2 bg-cyan-500 rounded-full animate-pulse mr-2 shadow-[0_0_8px_#06b6d4]"></span>
                            <div class="uppercase">{{ Auth::user()->name }}</div>
                            <div class="ms-1 opacity-50">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-[#161b22] border border-cyan-500/20 shadow-xl">
                            <x-dropdown-link :href="route('profile.edit')" class="text-white hover:bg-cyan-500/10 hover:text-cyan-400 text-[10px] uppercase tracking-widest transition-colors">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" class="text-red-400/80 hover:bg-red-500/10 hover:text-red-400 text-[10px] uppercase tracking-widest transition-colors"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Cerrar Sesión') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-cyan-500 hover:bg-cyan-500/10 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#0b0e14] border-t border-cyan-500/20">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white bg-cyan-500/10 border-l-4 border-cyan-500">
                {{ __('Subir Archivos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('analisis')" :active="request()->routeIs('analisis')" class="text-white border-l-4 border-transparent">
                {{ __('Análisis') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>