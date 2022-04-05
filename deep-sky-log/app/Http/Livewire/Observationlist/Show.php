<?php

namespace App\Http\Livewire\Observationlist;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $observationList;

    public $numberOfLikes = 0;

    public $isLiked = 0;

    protected $listeners = [
        'like' => 'like',
    ];

    public function mount(): void
    {
        $reactantFacade = $this->observationList->viaLoveReactant();
        $reacterFacade = Auth::user()->viaLoveReacter();

        $reactionCounter = $reactantFacade->getReactionCounterOfType('Like');

        $this->numberOfLikes = $reactionCounter->getCount();

        if ($reacterFacade->hasReactedTo($this->observationList)) {
            $this->isLiked = 1;
        } else {
            $this->isLiked = 0;
        }
    }

    public function like(): void
    {
        $reacterFacade = Auth::user()->viaLoveReacter();

        // Check if the observation list is already liked by this user.
        if ($reacterFacade->hasReactedTo($this->observationList)) {
            // If already liked, unlike the list
            $reacterFacade->unreactTo($this->observationList, 'Like');
            $this->isLiked = 0;
            --$this->numberOfLikes;
        } else {
            // If not yet liked, like the list
            $reacterFacade->reactTo($this->observationList, 'Like');
            $this->isLiked = 1;
            ++$this->numberOfLikes;
        }
    }

    public function render()
    {
        return view('livewire.observationlist.show');
    }
}
