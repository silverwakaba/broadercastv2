<div class="form-group col-{{ $col }}">
    <div class="form-outline">
        <label for="{{ $name }}" class="form-label">{{ $text }}</label>
        <textarea id="{{ $name }}" name="{{ $name }}" {{ $attributes->class(['form-control', 'is-invalid' => $errors->get($name)]) }}>{{ $errors->get($name) ? old($name) : $value }}</textarea>
        @error($name) <div class="text-danger">{{ $message }}</div> @enderror
    </div>
</div>