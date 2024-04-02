<div @class(["form-group", "col-$col" => $col])>
    <div class="icheck-primary">
        <input id="{{ $name }}" name="{{ $name }}" type="checkbox" value="{{ $value }}" @checked((old($name) || $errors->get($name)) ? (old($name) == $value) : (old($name) == $value)) {{ $attributes->class(['form-check-input', 'is-invalid' => $errors->get($name)]) }} />
        <label for="{{ $name }}" class="form-check-label">{{ $slot }}</label>
        @error($name) <div class="text-danger">{{ $message }}</div> @enderror
    </div>
</div>