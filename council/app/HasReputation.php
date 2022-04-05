<?php

namespace App;

trait HasReputation
{
    /**
     * Award reputation points to the model.
     *
     * @param  string $action
     */
    public function gainReputation($action): void
    {
        $this->increment('reputation', config("council.reputation.{$action}"));
    }

    /**
     * Reduce reputation points for the model.
     *
     * @param  string $action
     */
    public function loseReputation($action): void
    {
        $this->decrement('reputation', config("council.reputation.{$action}"));
    }
}
