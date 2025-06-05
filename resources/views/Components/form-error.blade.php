@props(['name'])
@error($name)
    <p class="text-danger ms-4">{{ $message }} </p>
@enderror
