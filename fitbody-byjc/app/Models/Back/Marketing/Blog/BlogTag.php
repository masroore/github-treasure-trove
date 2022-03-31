<?php

namespace App\Models\Back\Marketing\Blog;

use App\Models\Back\Tag;
use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    /**
     * @var string
     */
    protected $table = 'blog_tag';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @param $blog_id
     * @param $tags
     *
     * @return bool
     */
    public static function store($blog_id, $tags)
    {
        self::where('blog_id', $blog_id)->delete();

        foreach ($tags as $tag) {
            $tag_id = Tag::store($tag);

            if ($tag_id) {
                self::firstOrCreate([
                    'blog_id' => $blog_id,
                    'tag_id'  => $tag_id,
                ]);
            }
        }

        return true;
    }
}
