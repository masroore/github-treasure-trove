<?php

namespace App\Models\Back\Marketing\Blog;

use App\Models\Back\Photo;
use App\Models\Back\Tag;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Blog extends Model
{
    /**
     * @var string
     */
    public $image_path;

    /**
     * @var int
     */
    public $resource_id;

    /**
     * @var string
     */
    protected $table = 'blogs';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;

    /**
     * @return Relation
     */
    public function tags()
    {
        return $this->hasManyThrough(Tag::class, BlogTag::class, 'blog_id', 'id', 'id', 'tag_id');
    }

    public function scopeMenu($query)
    {
        return $query->where('is_published', 1);
    }

    /**
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'description' => 'required',
        ]);

        $this->setRequest($request);

        return $this;
    }

    /**
     * @return bool
     */
    public function storeData()
    {
        try {
            $this->resource_id = $this->insertGetId($this->setDbData('insert'));
        } catch (\Throwable $e) {
            Log::info($e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * @param array $id
     *
     * @return bool
     */
    public function updateData($id)
    {
        $this->resource_id = $id;

        try {
            $this->where('id', $id)->update($this->setDbData());
        } catch (\Throwable $e) {
            Log::info($e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function storeTags()
    {
        return BlogTag::store($this->resource_id, explode(',', $this->request->tags));
    }

    /**
     * Uploads the photo and
     * return it's path.
     *
     * @return $this
     */
    public function storeImage()
    {
        $this->image_path = Photo::imageUpload(
            $this->request->file('image'),
            $this->find($this->resource_id)
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function updateImagePath()
    {
        $this->where('id', $this->resource_id)->update([
            'image' => $this->image_path,
        ]);

        return $this;
    }

    /**
     * @param $id
     */
    public static function destroyAll($id)
    {
        $deleted = self::where('id', $id)->delete();

        if ($deleted) {
            BlogTag::where('blog_id', $id)->delete();
        }

        return $deleted;
    }

    /**
     * @param string $type
     *
     * @return array
     */
    private function setDbData($type = 'update')
    {
        $data = [
            'title'            => $this->request->title,
            'description'      => $this->request->description,
            'meta_description' => $this->request->meta_description,
            'slug'             => Str::slug($this->request->title),
            'category_id'      => 0,
            'is_published'     => (isset($this->request->status) && 'on' == $this->request->status) ? 1 : 0,
            'updated_at'       => Carbon::now(),
        ];

        if ('insert' == $type) {
            $data += [
                'user_id'    => Auth::user()->id,
                'client_id'  => Auth::user()->clientId(),
                'created_at' => Carbon::now(),
            ];
        }

        return $data;
    }

    /**
     * Set Model request variable.
     *
     * @param $request
     */
    private function setRequest($request)
    {
        $this->request = $request;
    }
}
