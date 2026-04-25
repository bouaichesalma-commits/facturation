@props(['value'])

<label {{ $attributes->merge(['class' => 'col-md-4 col-lg-3 col-form-label']) }}>
    {{ $value ?? $slot }}
</label>
