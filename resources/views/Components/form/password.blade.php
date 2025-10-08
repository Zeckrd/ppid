@props(['name', 'label' => 'Password'])

<div class="mb-3 text-start">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <div class="input-group">
        <input type="password"
               name="{{ $name }}"
               id="{{ $name }}"
               class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}"
               required
               autocomplete="current-password">
        <button class="btn btn-outline-secondary" 
                type="button" 
                data-toggle="password" 
                data-target="{{ $name }}">
            <i class="bi bi-eye"></i>
        </button>
    </div>
    <x-form-error :name="$name" />
</div>