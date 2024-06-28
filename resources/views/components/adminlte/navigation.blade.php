<nav class="main-header navbar navbar-expand navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="#" class="nav-link" data-widget="pushmenu">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        @can('canLogin')
            <x-Adminlte.NavDropdown>
                <a id="dropdownSubMenuAccountMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
                    User Menu
                </a>
                <ul aria-labelledby="dropdownSubMenuAccountMenu" class="dropdown-menu border-0 shadow">
                    <li class="nav-item">
                        <x-Adminlte.NavLink route="logout" mode="dropdown" value="Logout" />
                    </li>
                </ul>
            </x-Adminlte.NavDropdown>
        @else
            <li class="nav-item">
                <x-Adminlte.NavLink route="register" value="Register" />
            </li>
            <li class="nav-item">
                <x-Adminlte.NavLink route="login" value="Login" />
            </li>
        @endcan
        <li class="nav-item">
            <a href="#" class="nav-link" data-widget="fullscreen">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-5">
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ config('app.cdn_public_url') . '/system/image/logo/broadercast/logo-100px.png' }}" class="brand-image">
        <span class="brand-text">{{ config('app.name', 'Broadercast') }}</span>
    </a>
    <div class="sidebar">
        @can('canLogin')
            <div class="user-panel pb-3 mt-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ $user->avatar->path }}" class="img-circle elevation-2" />
                </div>
                <div class="info">
                    <a href="{{ $user->page }}" class="d-block text-truncate">{{ $user->name }}</a>
                </div>
            </div>
        @endcan
        <nav class="my-2">
            <ul class="nav nav-pills nav-sidebar nav-flat nav-compact flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Navigation</li>
                <x-Adminlte.NavTree route="index">
                    <x-Adminlte.NavLink icon="1" parent="1" fa="fas fa-home" value="Main Menu" />
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <x-Adminlte.NavLink icon="1" route="index" value="Home" />
                        </li>
                    </ul>
                </x-Adminlte.NavTree>
                @can('canLogin')
                    <li class="nav-header">Apps</li>
                    <x-Adminlte.NavTree route="apps.front.*">
                        <x-Adminlte.NavLink icon="1" parent="1" fa="fas fa-tablet-alt" value="Apps" />
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <x-Adminlte.NavLink icon="1" route="apps.front.index" value="Dashboard" />
                            </li>
                        </ul>
                    </x-Adminlte.NavTree>
                    <li class="nav-header">Manager</li>
                    <x-Adminlte.NavTree route="apps.manager.*">
                        <x-Adminlte.NavLink icon="1" parent="1" fa="fas fa-tasks" value="Manager" />
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <x-Adminlte.NavLink icon="1" route="apps.manager.index" value="Summary" />
                            </li>
                            <li class="nav-item">
                                <x-Adminlte.NavLink icon="1" route="apps.manager.avatar" value="Avatar" />
                            </li>
                            <li class="nav-item">
                                <x-Adminlte.NavLink icon="1" route="apps.manager.biodata" value="Biodata" />
                            </li>
                            <li class="nav-item">
                                <x-Adminlte.NavLink icon="1" route="apps.manager.content" value="Content" />
                            </li>
                            <li class="nav-item">
                                <x-Adminlte.NavLink icon="1" route="apps.manager.gender" value="Gender" />
                            </li>
                            <li class="nav-item">
                                <x-Adminlte.NavLink icon="1" route="apps.manager.language" value="Language" />
                            </li>
                            <li class="nav-item">
                                <x-Adminlte.NavLink icon="1" route="apps.manager.link" value="Link" />
                            </li>
                            <li class="nav-item">
                                <x-Adminlte.NavLink icon="1" route="apps.manager.race" value="Race" />
                            </li>
                        </ul>
                    </x-Adminlte.NavTree>
                    @role('Admin')
                        <li class="nav-header">Management</li>
                        <x-Adminlte.NavTree route="apps.master.*, apps.base.*">
                            <x-Adminlte.NavLink icon="1" parent="1" fa="fas fa-cogs" value="Master Data" />
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <x-Adminlte.NavLink icon="1" route="apps.master.index" value="Summary" />
                                </li>
                                <li class="nav-item">
                                    <x-Adminlte.NavLink icon="1" route="apps.base.content.index" value="Content Type" />
                                </li>
                                <li class="nav-item">
                                    <x-Adminlte.NavLink icon="1" route="apps.base.gender.index" value="Gender Type" />
                                </li>
                                <li class="nav-item">
                                    <x-Adminlte.NavLink icon="1" route="apps.base.language.index" value="Language Type" />
                                </li>
                                <li class="nav-item">
                                    <x-Adminlte.NavLink icon="1" route="apps.base.link.index" value="Link Type" />
                                </li>
                                <li class="nav-item">
                                    <x-Adminlte.NavLink icon="1" route="apps.base.race.index" value="Race Type" />
                                </li>
                                <li class="nav-item">
                                    <x-Adminlte.NavLink icon="1" route="apps.master.user.index" value="User Account" />
                                </li>
                            </ul>
                        </x-Adminlte.NavTree>
                    @endrole('Admin')
                @endcan
            </ul>
        </nav>
    </div>
</aside>