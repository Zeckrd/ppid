<button {{ $attributes->merge(['class' => 'btn btn-primary btn-lg mx-auto d-block mt-3 w-75', 'type' => 'submit']) }}>
    <small><i class="far fa-user pr-2"></i>{{ $slot }}</small>
</button>
