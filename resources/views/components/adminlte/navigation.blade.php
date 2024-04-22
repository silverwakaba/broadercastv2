<nav class="main-header navbar navbar-expand navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <x-adminlte.navlink route="index" value="Home" />
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        @can('canLogin')
            <x-adminlte.navdropdown>
                <a id="dropdownSubMenuAccountMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
                    User Menu
                </a>
                <ul aria-labelledby="dropdownSubMenuAccountMenu" class="dropdown-menu border-0 shadow">
                    <li class="nav-item">
                        <x-adminlte.navlink route="logout" mode="dropdown" value="Logout" />
                    </li>
                </ul>
            </x-adminlte.navdropdown>
        @else
            <li class="nav-item">
                <x-adminlte.navlink route="register" value="Register" />
            </li>
            <li class="nav-item">
                <x-adminlte.navlink route="login" value="Login" />
            </li>
        @endcan
    </ul>
</nav>
<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        <img src="https://laravel.com/img/logomark.min.svg" class="brand-image">
        <span class="brand-text">{{ config('app.name', 'Gampangan') }}</span>
    </a>
    <div class="sidebar">
        @can('canLogin')
            <div class="user-panel pb-3 mt-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" />
                </div>
                <div class="info">
                    <a class="d-block text-truncate">{{ request()->user()->email }}</a>
                </div>
            </div>
        @endcan
        <nav class="my-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Navigation</li>
                <x-adminlte.navtree route="index">
                    <x-adminlte.navlink icon="1" parent="1" fa="fas fa-home" value="Main Menu" />
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <x-adminlte.navlink icon="1" route="index" value="Home" />
                        </li>
                    </ul>
                </x-adminlte.navtree>
                @can('canLogin')
                    <li class="nav-header">Base Data</li>
                    <x-adminlte.navtree route="apps.base.*">
                        <x-adminlte.navlink icon="1" parent="1" fa="fas fa-cogs" value="Base Data" />
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <x-adminlte.navlink icon="1" route="apps.base.index" value="Summary" />
                            </li>
                            <li class="nav-item">
                                <x-adminlte.navlink icon="1" route="apps.base.content.index" value="Content" />
                            </li>
                            <li class="nav-item">
                                <x-adminlte.navlink icon="1" route="apps.base.gender.index" value="Gender" />
                            </li>
                            <li class="nav-item">
                                <x-adminlte.navlink icon="1" route="apps.base.language.index" value="Language" />
                            </li>
                            <li class="nav-item">
                                <x-adminlte.navlink icon="1" route="apps.base.link.index" value="Link" />
                            </li>
                            <li class="nav-item">
                                <x-adminlte.navlink icon="1" route="apps.base.race.index" value="Race" />
                            </li>
                        </ul>
                    </x-adminlte.navtree>
                @endcan
                @role('UserXXX')
                    <x-adminlte.navtree route="apps.front.*">
                        <x-adminlte.navlink icon="1" parent="1" fa="fas fa-tablet-alt" value="Apps" />
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <x-adminlte.navlink icon="1" route="apps.front.index" value="Dashboard" />
                            </li>
                        </ul>
                    </x-adminlte.navtree>
                @elserole('Admin')
                    <li class="nav-header">Management</li>
                    <x-adminlte.navtree route="apps.master.*">
                        <x-adminlte.navlink icon="1" parent="1" fa="fas fa-cogs" value="Master Data" />
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <x-adminlte.navlink icon="1" route="apps.master.index" value="Summary" />
                            </li>
                            <li class="nav-item">
                                <x-adminlte.navlink icon="1" route="apps.master.user.index" value="User Account" />
                            </li>
                        </ul>
                    </x-adminlte.navtree>
                @endrole
            </ul>
        </nav>
    </div>
</aside>