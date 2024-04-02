<div @class(["form-group", "col-$col" => $col])>
    <label for="{{ $name }}">{{ $text }}</label>
    <select id="{{ $name }}" name="{{ $name }}" {{ $attributes->class(['form-control', 'is-invalid' => $errors->get($name)]) }}>
        <option value="">Please select the "{{ $text }}" option...</option>
        @foreach($data as $key => $datas)
            <option value="{{ $datas }}" @selected((old($name) || $errors->get($name)) ? (old($name) == $datas) : (isset($value) == isset($datas)))>{{ $datas }}</option>
        @endforeach
    </select>
    @error($name) <div class="text-danger">{{ $message }}</div> @enderror
</div>