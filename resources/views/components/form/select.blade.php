@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'required' => false,
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <select name="{{ $name }}" id="{{ $name }}" 
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-select']) }}>
        
        <option value="" selected disabled>Pilih...</option>

        @foreach ($options as $value => $text)
            <option value="{{ $value }}" 
                {{ ($selected == $value) ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>
</div>
