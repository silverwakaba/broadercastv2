<div @class(["form-group", "col-$col" => $col])>
    <div class="form-outline">
        <label for="{{ $name }}" class="form-label">{{ $text }}</label>
        <input id="{{ $name }}" name="{{ $name }}" type="file" {{ $attributes->class(['form-control-file', 'is-invalid' => $errors->get($name)]) }} />
        @error($name) <div class="text-danger">{{ $message }}</div> @enderror
    </div>
</div>