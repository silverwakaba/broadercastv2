<div @class(["form-group", "col-$col" => $col, "$extclass" => $extclass])>
    <label for="{{ $name }}">{{ $text }}</label>
    <select id="{{ $name }}" name="{{ $name }}" data-placeholder="Select an option..." data-allow-clear="1" {{ $attributes->class(['form-control select2bs4', 'is-invalid' => $errors->get($name)]) }}>
        <option value=""></option>
        @foreach($data as $key => $datas)
            <option value="{{ $datas->$grab }}" @selected((old($name) || $errors->get($name)) ? (old($name) == $datas->$grab) : ($value == $datas->$grab))>{{ $datas->name }}</option>
        @endforeach
    </select>
    @error($name) <div class="text-danger">{{ $message }}</div> @enderror
</div>