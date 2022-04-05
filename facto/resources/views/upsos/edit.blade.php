<x-layout >
    <div>
        <x-common.top-title menu='업소정보' mode='수정' />

        @livewire('upso-edit', ['upso_id'=> $upso->id])

    {{-- @livewire('upso-edit', ['upso_id'=> $upso->id]) --}}

</div>
</x-layout>

