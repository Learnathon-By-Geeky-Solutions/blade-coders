<nav class="navbar-vertical navbar">
    <div class="h-screen" id="myScrollableElement" data-simplebar>
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo />
        </a>

        <ul class="navbar-nav flex-col" id="sideNavbar">
            <x-sidebar-nav-link :href="route('dashboard')" icon="home" :active="request()->is('dashboard')">
                {{ __('Dashboard') }}
            </x-sidebar-nav-link>

            <li class="nav-item">
                <a class="nav-link @if (request()->is('pages') || request()->is('blogs')) collapsed @endif" data-bs-toggle="collapse"
                    data-bs-target="#navPages" href="#" aria-expanded="false" aria-controls="navPages">
                    <i class="mr-2 h-4 w-4" data-feather="layers"></i>
                    Pages
                </a>
                <div class="@if (request()->is('blogs')) show @endif collapse" id="navPages"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-col">
                        <x-sidebar-nav-link :href="route('blogs')" :active="request()->is('blogs')">
                            {{ __('Blog') }}
                        </x-sidebar-nav-link>
                    </ul>
                </div>
            </li>

            @can('user.viewAny')
                <x-sidebar-nav-link :href="route('users.index')" icon="user" :active="request()->is('users')">
                    {{ __('Users') }}
                </x-sidebar-nav-link>
            @endcan

            @can('role.viewAny')
                <x-sidebar-nav-link :href="route('roles.index')" icon="shield" :active="request()->is('roles')">
                    {{ __('Roles') }}
                </x-sidebar-nav-link>
            @endcan

            @can('language.view')
                <x-sidebar-nav-link :href="route('languages.index')" icon="globe" :active="request()->is('languages')">
                    {{ __('Languages') }}
                </x-sidebar-nav-link>
            @endcan

            @can('setting.view')
                <x-sidebar-nav-link :href="route('settings.index')" icon="settings" :active="request()->is('settings')">
                    {{ __('Settings') }}
                </x-sidebar-nav-link>
            @endcan

            @can('currency.view')
                <x-sidebar-nav-link :href="route('currencies.index')" icon="dollar-sign" :active="request()->is('currencies')">
                    {{ __('Currencies') }}
                </x-sidebar-nav-link>
            @endcan
        </ul>
    </div>
</nav>
