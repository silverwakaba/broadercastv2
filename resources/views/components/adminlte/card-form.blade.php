<form id="{{ $formID }}" action="{{ $action }}" method="{{ $method }}" enctype="{{ $encode }}">
    <div @class(["card", "card-outline card-$outline" => $outline])>
        @if($title)
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
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