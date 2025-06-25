<div class="mb-2">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}" class="form-select">
        <option>Selecione...</option>
        @foreach($options as $item)
            <option value="{{ $item->id }}" {{ $selected == $item->id ? 'selected' : '' }}>
                {{ $item[$campo] }}
            </option>
        @endforeach
    </select>
</div>