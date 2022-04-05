<?php

namespace App\Models;

use App\Models\Traits\Metatagable;
use App\Models\Traits\Navigable;
use App\Traits\UrlAliasGenerator;
use Fomvasss\UrlAliases\Traits\UrlAliasable;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use Metatagable;
    use Navigable;
    use UrlAliasable;
    use UrlAliasGenerator;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

        return $this->getUniqueAliasedPath($this, $alias ?? request('url_alias', 'news/' . $name));
    }

    /**
     * @return string
     */
    public function generateUrlSource()
    {
        return trim(route('news.show', $this, false), '/');
    }
}
