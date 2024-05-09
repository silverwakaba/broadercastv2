<div @class(["form-group", "col-$col" => $col])>
    <label for="{{ $name }}">{{ $text }}</label>
    <select id="{{ $name }}" name="{{ $name }}" multiple="multiple" data-placeholder="Select an option..." data-allow-clear="1" {{ $attributes->class(['form-control select2bs4']) }}>
        @foreach($data as $key => $datas)
            <option value="{{ $datas->id }}" @selected((in_array($datas->id, $value)))>{{ $datas->name }}</option>
        @endforeach
    </select>
    @error($name) <div class="text-danger">{{ $message }}</div> @enderror
</div>