<div @class(["form-group", "col-$col" => $col])>
    <div class="form-outline">
        <label for="{{ $name }}" class="form-label">{{ $text }}</label>
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ (old($name) || $errors->get($name)) ? (old($name)) : ($value) }}" {{ $attributes->class(['form-control', 'is-invalid' => $errors->get($name)]) }} />
        @error($name) <div class="text-danger">{{ $message }}</div> @enderror
    </div>
</div>