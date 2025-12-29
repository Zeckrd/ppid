@props(['name'])

@error($name)
    <div class="invalid-feedback d-block small">
        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
    </div>
@enderror