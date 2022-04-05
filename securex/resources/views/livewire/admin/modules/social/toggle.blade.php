<div>
    <label class="switch" data-toggle="tooltip" @if($this->enabled) title="@lang('snippets.enabled')" @else title="@lang('snippets.disabled')" @endif >
        <input wire:click="switch" type="checkbox" @if($this->enabled) checked @endif>
        <span class="slider"></span>
    </label>
</div>