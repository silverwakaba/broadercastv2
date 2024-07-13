<nav class="main-header navbar navbar-expand-md navbar-dark">
    @if(request()->routeIs('apps.*'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="nav-link" data-widget="pushmenu">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item">
                <x-Adminlte.NavLink route="creator.index" value="Creator" />
            </li>
            <li class="nav-item">
                <x-Adminlte.NavLink route="creator.live" value="Live" />
            </li>
            <li class="nav-item">
                <x-Adminlte.NavLink route="creator.scheduled" value="Scheduled" />
            </li>
            <li class="nav-item">
                <x-Adminlte.NavLink route="creator.archived" value="Archived" />
            </li>
            <li class="nav-item">
                <x-Adminlte.NavLink route="creator.uploaded" value="Uploaded" />
            </li>
            <li class="nav-item">
                <x-Adminlte.NavLink route="creator.setting" value="Setting" />
            </li>
            <ul class="navbar-nav">
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
            </ul>
        </ul>
    @else
        <a href="{{ route('index') }}" class="navbar-brand">
            <img src="{{ config('app.cdn_public_url') . '/system/image/logo/broadercast/logo-100px.png' }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" />
            <span class="brand-text font-weight-light text-light">{{ config('app.name', 'vTual') }}</span>
        </a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <x-Adminlte.NavLink route="index" value="Home" />
            </li>
        </ul>
        @can('canLogin')
            <ul class="navbar-nav">
                <li class="nav-item">
                    <x-Adminlte.NavLink route="apps.front.index" value="App" />
                </li>                
            </ul>
        @endcan
        <ul class="navbar-nav">
            <x-Adminlte.NavDropdown route="creator.*">
                <a id="dropdownSubMenuCreators" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
                    Creator
                </a>
                <ul aria-labelledby="dropdownSubMenuCreators" class="dropdown-menu border-0 shadow">
                    <li class="nav-item">
                        <x-Adminlte.NavLink route="creator.index" mode="dropdown" value="Discover" />
                    </li>
                    <li class="nav-item">
                        <x-Adminlte.NavLink route="creator.live" mode="dropdown" value="Live" />
                    </li>
                    <li class="nav-item">
                        <x-Adminlte.NavLink route="creator.scheduled" mode="dropdown" value="Scheduled" />
                    </li>
                    <li class="nav-item">
                        <x-Adminlte.NavLink route="creator.archived" mode="dropdown" value="Archived" />
                    </li>
                    <li class="nav-item">
                        <x-Adminlte.NavLink route="creator.uploaded" mode="dropdown" value="Uploaded" />
                    </li>
                    <li class="nav-item">
                        <x-Adminlte.NavLink route="creator.setting" mode="dropdown" value="Setting" />
                    </li>
                </ul>
            </x-Adminlte.NavDropdown>
        </ul>
        @can('canLogin')
            <ul class="navbar-nav">
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
            </ul>
        @else
            <ul class="navbar-nav">
                <li class="nav-item">
                    <x-Adminlte.NavLink route="register" value="Register" />
                </li>
                <li class="nav-item">
                    <x-Adminlte.NavLink route="login" value="Login" />
                </li>
            </ul>
        @endcan
    @endif
</nav>
@if(request()->routeIs('apps.*'))
    <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-5">
        <div class="brand-link">
            <img src="{{ config('app.cdn_public_url') . '/system/image/logo/broadercast/logo-100px.png' }}" class="brand-image" />
            <span class="brand-text">{{ config('app.name', 'vTual') }}</span>
        </div>
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
                            <x-Adminlte.NavLink icon="1" parent="1" fa="fas fa-user" value="Account Manager" />
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
                                    <x-Adminlte.NavLink icon="1" route="apps.manager.persona" value="Persona" />
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
                                        <x-Adminlte.NavLink icon="1" route="apps.base.persona.index" value="Persona Type" />
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
@endif