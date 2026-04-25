@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'text-danger offset-md-4 col-md-8 offset-lg-3 col-lg-9']) }}>
        @foreach ((array) $messages as $message)
            {{ $message }}
        @endforeach
    </div>
@endif
