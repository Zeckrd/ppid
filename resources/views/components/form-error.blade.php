@props(['name', 'class' => ''])
@error($name)
    <p class="text-danger {{ $class }}">{{ $message }} </p>
@enderror