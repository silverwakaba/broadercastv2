<div @class(["form-group", "col-$col" => $col])>
    <label for="{{ $name }}">{{ $text }}</label>
    <select id="{{ $name }}" name="{{ $name }}" multiple size="10" {{ $attributes->class(['form-control']) }}>
        <option value="">Please select the "{{ $text }}" option below...</option>
        @foreach($data as $key => $datas)
            <option value="{{ $datas->id }}" @selected((in_array($datas->id, $value)))>{{ $datas->name }}</option>
        @endforeach
    </select>
    @error($name) <div class="text-danger">{{ $message }}</div> @enderror
</div>