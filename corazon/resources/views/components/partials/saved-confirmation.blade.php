<div>
    @if (session()->has('success'))
    <span x-data="{show: true}" x-show="show" x-init="setTimeout( () => show = false, 3000)"
        class="text-sm font-medium text-green-700 mr-2">
        {{ session()->get('success') }}
    </span>
    @endif
</div>