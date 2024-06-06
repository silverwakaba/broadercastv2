<form action="{{ $action }}" method="{{ $method }}" enctype="{{ $encode }}">
    <div @class(["card", "card-outline card-$outline" => $outline])>
        @if($title)
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" role="tablist">
                    @if($title)
                        <li class="nav-item">
                            <h3 class="nav-link pt-2 h5">{{ $title }}</h3>
                        </li>
                    @endif
                </ul>
            </div>
        @endif
        <div class="card-body">
            <div class="form-row">
                {{ $slot }}
            </div>
        </div>
        <div class="card-footer text-right p-2">
            <button type="reset" class="btn btn-danger">Reset</button>    
            <button type="submit" class="btn btn-success">{{ $button }}</button>
            <input type="hidden" name="_token" class="d-none" value="{{ csrf_token() }}" readonly />
        </div>
    </div>
</form>