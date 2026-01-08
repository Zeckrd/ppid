@props(['name' => 'phone', 'label' => 'Nomor WhatsApp'])

<div class="mb-3 text-start">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <div class="input-group">
        <span class="input-group-text">+</span>
        <input type="tel" 
               name="{{ $name }}"
               id="{{ $name }}"
               class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}"
               value="{{ old($name) }}"
               required
               autocomplete="tel"
               placeholder="628123456789"
               pattern="[0-9]{8,15}">
    </div>
    <div class="form-text">
        <i class="bi bi-info-circle me-1"></i>
        Gunakan format: 628123456789 (tanpa spasi atau tanda hubung)
    </div>
    <x-form.error :name="$name" />
</div>
