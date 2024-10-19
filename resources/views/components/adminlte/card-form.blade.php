<form id="{{ $formID }}" action="{{ $action }}" method="{{ $method }}" enctype="{{ $encode }}">
    <div @class(["card", "card-outline card-$outline" => $outline])>
        @if($title)
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" role="tablist">
                    @if($title)
                        <li class="nav-item">
                            <h3 class="nav-link card-title h3 pt-2">{{ $title }}</h3>
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
            @if($captcha == true)
                <x-Form.Hcaptcha :id="$formID" :button="$button" class="btn btn-success" />
            @else
                <button type="submit" class="btn btn-success">{{ $button }}</button>
            @endif
            <input type="hidden" name="_token" class="d-none" value="{{ csrf_token() }}" readonly />
        </div>
    </div>
</form>