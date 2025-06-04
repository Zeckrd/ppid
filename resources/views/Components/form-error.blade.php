@props(['name'])
@error($name)
    <p class="text-danger ms-1">{{ $message }} </p>
@enderror
