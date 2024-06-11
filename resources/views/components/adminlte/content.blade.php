<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">
                @if($previous)
                    <a href="{{ route($previous) }}" class="btn btn-light">
                        <i class="fas fa-step-backward"></i>
                    </a>
                @endif
                <span>{{ $title }}</span>
            </h1>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(session()->has('class') && session()->has('message'))
                        <x-Adminlte.Callout class="{{ session()->get('class') }}">
                            {{ session()->get('message') }}
                        </x-Adminlte.Callout>
                    @endif
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>