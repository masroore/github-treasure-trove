<?php

namespace App\Models;

use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableInterface;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;

class ObservationList extends Model implements ReactableInterface
{
    use HasTags;
    use Reactable;
    use Sluggable;

    protected $table = 'observation_list';

    protected $fillable = [
        'user_id', 'name', 'description', 'discoverable', 'love_reactant_id',
    ];

    /**
     * Toggle the discoverable status of the list.
     *
     * @return None
     */
    public function toggleDiscoverable()
    {
        if ($this->discoverable) {
            $this->update(['discoverable' => 0]);
        } else {
            $this->update(['discoverable' => 1]);
        }
    }

    /**
     * Adds the link to the observer.
     *
     * @return BelongsTo the observer this lens belongs to
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }
}
