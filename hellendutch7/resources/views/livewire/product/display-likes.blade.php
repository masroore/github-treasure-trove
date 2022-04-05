<div class="mr-6">
    <div>
        @if($liked == false)
            <div wire:click='addCount'><i class="far fa-thumbs-up"></i>
                {{ $count }}
            </div>
        @else
            <div wire:click='minusCount'><i class="far fa-thumbs-down"></i>
                {{ $count }}
            </div>
        @endif
    </div>

</div>