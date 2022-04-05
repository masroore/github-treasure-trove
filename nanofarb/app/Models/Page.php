<?php

namespace App\Models;

use App\Models\Traits\Metatagable;
use App\Models\Traits\Navigable;
use App\Traits\UrlAliasGenerator;
use Fomvasss\UrlAliases\Traits\UrlAliasable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Metatagable;
    use Navigable;
    use UrlAliasable;
    use UrlAliasGenerator;

    public $timestamps = false;

    protected $guarded = ['id'];

    public function scopeIsPublish($query)
    {
        return $query->where('publish', 1);
    }

    /**
     * @return string
     */
    public function generateUrlAlias(?string $alias = null)
    {
        $name = str_replace('/', '-', $this->name);

        return $this->getUniqueAliasedPath($this, $alias ?? request('url_alias', $name));
    }

    /**
     * @return string
     */
    public function generateUrlSource()
    {
        return trim(route('page.show', $this, false), '/');
    }
}
