<div>
    <button wire:click="increment">+</button>
    	<h1>{{$count}}</h1>
    	<input type="text" name="you" wire:model="display">
    	{{$display}}
    <button wire:click="decrement">-</button>
</div>
</div>
