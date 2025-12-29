@props([
    'type' => 'text',
    'name',
    'label' => null,
    'value' => null,
])

<div class="mb-3 text-start">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <input type="{{ $type }}"
           name="{{ $name }}"
           id="{{ $name }}"
           value="{{ old($name, $value) }}"
           {{ $attributes->merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : '')]) }}
           autocomplete="{{ $name }}"
           {{ $type === 'email' ? 'autofocus' : '' }}>

    <x-form-error :name="$name" />
</div>
