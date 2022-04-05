<x-layout >
    <div>
        <x-common.top-title menu='매니저정보' mode='수정' />

        @livewire('manager-edit', ['manager_id'=> $manager->id])

</div>
</x-layout>

