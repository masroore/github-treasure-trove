@props(['minDate' => null, 'defaultDate' => null, 'maxDate' => null, 'placeholder' => 'Date and Time...'])

<input wire:key="{{ Str::random(4) }}" placeholder="{{ $placeholder }}" type="text" class="rounded block" {{ $attributes->whereStartsWith('wire:model') }} name="datetimepickr" x-init="flatpickr($el, {
            enableTime: true,
            altInput: true,
            altFormat: `F j, Y h:i K`,
            minDate: '{{ $minDate?->toISOString() }}',
            defaultDate: '{{ $defaultDate?->toISOString() }}',
            maxDate: '{{$maxDate?->toISOString()}}',
        })">

