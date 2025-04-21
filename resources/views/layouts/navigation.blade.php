<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <img src="{{ asset('Logo/logo_menu.png') }}" alt="TavoCell 504"
                            class="h-10 w-auto transition-transform hover:scale-105">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:space-x-2 ml-6">
                    <!-- Productos -->
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true"
                        @mouseleave="open = false">
                        <button class="nav-dropdown-btn">
                            <span class="nav-icon">📦</span>
                            <span>Productos</span>
                            <svg class="w-4 h-4 ml-1 transition-transform" :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="nav-dropdown-menu" x-show="open" x-transition>
                            <x-nav-link :href="route('productos.index')" class="nav-dropdown-item">
                                <span class="nav-icon">📋</span> Ver Productos
                            </x-nav-link>
                            <x-nav-link :href="route('inventario.index')" class="nav-dropdown-item">
                                <span class="nav-icon">📥</span> Ingreso Inventario
                            </x-nav-link>
                        </div>
                    </div>

                    <!-- Facturación -->
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true"
                        @mouseleave="open = false">
                        <button class="nav-dropdown-btn">
                            <span class="nav-icon">💸</span>
                            <span>Facturación</span>
                            <svg class="w-4 h-4 ml-1 transition-transform" :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="nav-dropdown-menu" x-show="open" x-transition>
                            <x-nav-link :href="route('facturas_productos.create')" class="nav-dropdown-item">
                                <span class="nav-icon">🛒</span> Nueva Factura Producto
                            </x-nav-link>
                            <x-nav-link :href="route('facturas_productos.index')" class="nav-dropdown-item">
                                <span class="nav-icon">📄</span> Historial Productos
                            </x-nav-link>
                            <x-nav-link :href="route('facturas_reparaciones.index')" class="nav-dropdown-item">
                                <span class="nav-icon">🔧</span> Historial Reparaciones
                            </x-nav-link>

                            <x-nav-link :href="route('cierres.index')" class="nav-dropdown-item">
                                <span class="nav-icon">🔒</span> Cierres Diarios
                            </x-nav-link>
                        </div>
                    </div>




                    <!-- Clientes -->
                    <x-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')" class="nav-item">
                        <span class="nav-icon">👤</span>
                        <span>Clientes</span>
                    </x-nav-link>

                    <!-- Reparaciones -->
                    <x-nav-link :href="route('reparaciones.index')" :active="request()->routeIs('reparaciones.*')" class="nav-item">
                        <span class="nav-icon">🛠️</span>
                        <span>Reparaciones</span>
                    </x-nav-link>
                </div>
            </div>

            <!-- Menú de Usuario con Alpine.js -->
            <div class="hidden sm:flex sm:items-center sm:ms-6" x-data="{ openUser: false }" @click.away="openUser = false">
                <div class="relative">
                    <button @click="openUser = !openUser" class="user-menu-btn flex items-center">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <svg class="dropdown-chevron" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="openUser" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white rounded shadow-md z-50 py-2">
                        <a href="{{ route('profile.edit') }}"
                            class="user-menu-item block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="user-menu-item w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">
                                <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Hamburger (mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="mobile-menu-btn">
                    <svg class="h-6 w-6" :class="{ 'hidden': open, 'block': !open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" :class="{ 'hidden': !open, 'block': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="mobile-nav-item">
                <span class="nav-icon">📊</span> Dashboard
            </x-responsive-nav-link>

            <div class="mobile-nav-group">
                <div class="mobile-nav-header">
                    <span class="nav-icon">📦</span> Productos
                </div>
                <div class="mobile-nav-submenu">
                    <x-responsive-nav-link :href="route('productos.index')" class="mobile-nav-subitem">
                        <span class="nav-icon">📋</span> Ver Productos
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inventario.index')" class="mobile-nav-subitem">
                        <span class="nav-icon">📥</span> Ingreso Inventario
                    </x-responsive-nav-link>
                </div>
            </div>

            <div class="mobile-nav-group">
                <div class="mobile-nav-header">
                    <span class="nav-icon">💸</span> Ventas
                </div>
                <div class="mobile-nav-submenu">
                    <x-responsive-nav-link :href="route('facturas_productos.create')" class="mobile-nav-subitem">
                        <span class="nav-icon">🛒</span> Nueva Factura Producto
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('facturas_productos.index')" class="mobile-nav-subitem">
                        <span class="nav-icon">📄</span> Historial Productos
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('facturas_reparaciones.index')" class="mobile-nav-subitem">
                        <span class="nav-icon">🔧</span> Historial Reparaciones
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('cierres.index')" class="mobile-nav-subitem">
                        <span class="nav-icon">🔒</span> Cierres
                    </x-responsive-nav-link>
                </div>

            </div>

            <x-responsive-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')" class="mobile-nav-item">
                <span class="nav-icon">👤</span> Clientes
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('reparaciones.index')" :active="request()->routeIs('reparaciones.*')" class="mobile-nav-item">
                <span class="nav-icon">🛠️</span> Reparaciones
            </x-responsive-nav-link>
        </div>

        <!-- Responsive user menu -->
        <div class="pt-4 pb-1 border-t border-gray-200 px-4">
            <div class="flex items-center space-x-3 mb-3">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="mobile-user-item">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Perfil
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="mobile-user-item"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Cerrar Sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Navigation styles */
    .nav-icon {
        margin-right: 0.5rem;
    }

    /* Desktop navigation */
    .nav-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #4b5563;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }

    .nav-item:hover {
        color: #1e40af;
        background-color: #f3f4f6;
    }

    .nav-item.active {
        color: #1e40af;
        background-color: #e0e7ff;
    }

    .nav-dropdown-btn {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #4b5563;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }

    .nav-dropdown-btn:hover {
        color: #1e40af;
        background-color: #f3f4f6;
    }

    .nav-dropdown-menu {
        position: absolute;
        z-index: 50;
        min-width: 200px;
        margin-top: 0.5rem;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .nav-dropdown-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        color: #4b5563;
        transition: all 0.2s ease;
    }

    .nav-dropdown-item:hover {
        background-color: #f3f4f6;
        color: #1e40af;
    }

    /* User menu */
    .user-menu-btn {
        display: flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }

    .user-menu-btn:hover {
        background-color: #f3f4f6;
    }

    .user-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 9999px;
        background-color: #1e40af;
        color: white;
        font-weight: 500;
        margin-right: 0.5rem;
    }

    .user-name {
        font-size: 0.875rem;
        font-weight: 500;
        color: #4b5563;
    }

    .dropdown-chevron {
        width: 1rem;
        height: 1rem;
        margin-left: 0.25rem;
        transition: transform 0.2s ease;
    }

    .user-menu-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        color: #4b5563;
        transition: all 0.2s ease;
    }

    .user-menu-item:hover {
        background-color: #f3f4f6;
        color: #1e40af;
    }

    /* Mobile menu */
    .mobile-menu-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        border-radius: 0.375rem;
        color: #6b7280;
        transition: all 0.2s ease;
    }

    .mobile-menu-btn:hover {
        color: #4b5563;
        background-color: #f3f4f6;
    }

    .mobile-nav-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 0.375rem;
        color: #4b5563;
        transition: all 0.2s ease;
    }

    .mobile-nav-item:hover {
        background-color: #f3f4f6;
        color: #1e40af;
    }

    .mobile-nav-item.active {
        background-color: #e0e7ff;
        color: #1e40af;
    }

    .mobile-nav-group {
        margin-bottom: 0.5rem;
    }

    .mobile-nav-header {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        font-weight: 500;
        color: #4b5563;
    }

    .mobile-nav-submenu {
        padding-left: 1.5rem;
    }

    .mobile-nav-subitem {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        color: #4b5563;
        transition: all 0.2s ease;
    }

    .mobile-nav-subitem:hover {
        color: #1e40af;
    }

    .mobile-user-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 0.375rem;
        color: #4b5563;
        transition: all 0.2s ease;
    }

    .mobile-user-item:hover {
        background-color: #f3f4f6;
        color: #1e40af;
    }
</style>
