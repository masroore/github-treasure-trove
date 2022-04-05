<?php

namespace App\Http\Traits;

trait ReservedPageSlugs
{
    public function reserved($slug)
    {
        if (strcasecmp($slug, 'privacy') == 0 || strcasecmp($slug, 'terms') == 0 || strcasecmp($slug, 'tfa') == 0) {
            return true;
        }

        return false;
    }
}
