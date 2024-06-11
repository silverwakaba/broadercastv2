<nav class="main-header navbar navbar-expand navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <x-adminlte.navlinks route="index" value="Home" />
        </li>
    </ul>
</nav>
<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        <img src="https://public-cdn.broadercast.net/system/logo/50px.png" class="brand-image">
        <span class="brand-text">{{ config('app.name', 'Broadercast') }}</span>
    </a>
</aside>