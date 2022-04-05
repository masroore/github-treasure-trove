<div>
    @if (session('flash_message'))
        <div x-data x-init="
             @this.emitSelf('flashtoast', `{{ session('flash_message') }}`);
        ">
        </div>
    @endif
</div>
