@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-xs text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
