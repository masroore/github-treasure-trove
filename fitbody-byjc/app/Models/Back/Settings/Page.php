<?php

namespace App\Models\Back\Settings;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Page extends Model
{
    /**
     * @var string
     */
    protected $table = 'pages';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blocks()
    {
        return $this->hasMany(PageBlock::class, 'page_id');
    }

    /**
     * Validate Page Request.
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
        ]);

        $this->request = $request;

        return $this;
    }

    /**
     * @return bool
     */
    public function storePage()
    {
        $description = preg_replace('/ style=("|\')(.*?)("|\')/', '', $this->request->description);
        $description = preg_replace('/ face=("|\')(.*?)("|\')/', '', $description);

        $id = $this->insertGetId([
            'category_id' => $this->request->category_id,
            'name' => $this->request->name,
            'slug' => isset($this->request->slug) ? Str::slug($this->request->slug) : Str::slug($this->request->name),
            'description' => $description,
            'seo_title' => $this->request->seo_title,
            'meta_description' => $this->request->meta_description,
            'meta_keywords' => $this->request->meta_keywords,
            'group' => $this->request->group ?? 0,
            'publish_date' => isset($this->request->date_published) ? new Carbon($this->request->date_published) : '',
            'status' => (isset($this->request->status) && 'on' == $this->request->status) ? 1 : 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($id) {
            return $this->find($id);
        }

        return false;
    }

    /**
     * @param array $id
     *
     * @return bool
     */
    public function updatePage($id)
    {
        $description = preg_replace('/ style=("|\')(.*?)("|\')/', '', $this->request->description);
        $description = preg_replace('/ face=("|\')(.*?)("|\')/', '', $description);

        return $this->where('id', $id)->update([
            'category_id' => $this->request->category_id,
            'name' => $this->request->name,
            'slug' => isset($this->request->slug) ? Str::slug($this->request->slug) : Str::slug($this->request->name),
            'description' => $description,
            'seo_title' => $this->request->seo_title,
            'meta_description' => $this->request->meta_description,
            'meta_keywords' => $this->request->meta_keywords,
            'group' => $this->request->group ?? 0,
            'publish_date' => isset($this->request->date_published) ? new Carbon($this->request->date_published) : '',
            'status' => (isset($this->request->status) && 'on' == $this->request->status) ? 1 : 0,
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * @param $page_id
     */
    public function resolveMainImage($page_id)
    {
        $page = $this->where('id', $page_id)->first();

        $path = $this->saveImage($page_id, $this->request->main_image);

        if ($page->image && $path) {
            $this->deleteImage($page->image);
        }

        return $this->where('id', $page_id)->update([
            'image' => $path,
        ]);
    }

    /**
     * @param $page_id
     */
    public function resolveGallery($page_id)
    {
        $page_block = new PageBlock();

        if (isset($this->request->gallery_images)) {
            foreach ($this->request->gallery_images as $key => $image) {
                if ($image['image']) {
                    $path = $this->saveImage($page_id, $image['image']);

                    $this->deleteImage($page_block->where('id', $key)->pluck('path'));

                    $page_block->updateImagePath($key, $path);
                }

                $page_block->updateSortOrder($key, $image['sort_order']);
            }
        }

        if (isset($this->request->new_gallery_images)) {
            foreach ($this->request->new_gallery_images as $image) {
                $path = $this->saveImage($page_id, $image['image']);

                $page_block->insertImageBlock($page_id, $path, $image);
            }
        }

        return true;
    }

    /**
     * @param      $page_id
     * @param null $files
     *
     * @return bool
     */
    public function resolveDocuments($page_id, $files = null)
    {
        $page_block = new PageBlock();

        foreach ($this->request->blocks_docs as $key => $doc) {
            if ($doc['id']) {
                $block = PageBlock::where('id', $doc['id'])->first();
                $doc['paths'] = [
                    'path' => $block->path,
                    'thumb' => $block->thumb,
                ];

                if (isset($files[$key])) {
                    $doc['paths'] = $this->saveDocument($page_id, $doc, $files[$key]);
                    $doc['paths']['thumb'] = $page_block->resolveFileThumb($files[$key]['file']->hashName());
                }

                //dd($doc);

                $page_block->updateDocBlock($doc);
            } else {
                if (isset($files[$key])) {
                    $doc['paths'] = $this->saveDocument($page_id, $doc, $files[$key]);
                    $doc['paths']['thumb'] = $page_block->resolveFileThumb($files[$key]['file']->hashName());
                }

                $page_block->insertDocBlock($page_id, $doc);
            }
        }

        return true;
    }

    /*
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     */
    // Static functions

    public static function getMenu()
    {
        return self::where('status', 1)->select('id', 'name')->get();
    }

    public static function groups()
    {
        return self::groupBy('group')->pluck('group');
    }

    /**
     * @param $page_id
     * @param $doc
     * @param $file
     *
     * @return array
     */
    private function saveDocument($page_id, $doc, $file)
    {
        $path = Storage::disk('page')->put($page_id, $file['file']);

        /*if ($doc['image']) {
            $thumb_path = $page_id . '/' . time() . '_thumb_' . Str::slug($doc['title']) . '.png';
            $img        = Image::make($doc['image'])->encode('png');

            Storage::disk('page')->put($thumb_path, $img);
        }*/

        if ('0' != $doc['id']) {
            $this->deleteOldDocument($doc);
        }

        return [
            'path' => config('filesystems.disks.page.url') . $path,
            'thumb' => isset($thumb_path) ? config('filesystems.disks.page.url') . $thumb_path : '',
        ];
    }

    /**
     * @param $doc
     *
     * @return bool
     */
    private function deleteOldDocument($doc)
    {
        $block = PageBlock::where('id', $doc['id'])->first();

        /*if ($block->thumb) {
            Storage::disk('page')->delete($block->thumb);
        }*/

        return Storage::disk('page')->delete(str_replace(config('filesystems.disks.page.url'), '', $block->path));
    }

    /**
     * @param      $page_id
     * @param      $image
     * @param bool $thumb
     *
     * @return string
     */
    private function saveImage($page_id, $image, $thumb = false)
    {
        $data = json_decode($image);

        /*if ($thumb) {
            $path = $page_id . '/' . time() . '_640x360_' . $data->output->name;
            $img = Image::make($data->output->image)->fit(640, 360)->encode(str_replace('image/', '', $data->output->type));

            Storage::disk('page')->put($path, $img);
        }*/

        $path = $page_id . '/' . time() . '_' . $data->output->name;
        $img = Image::make($data->output->image)->encode(str_replace('image/', '', $data->output->type));

        Storage::disk('page')->put($path, $img);

        return config('filesystems.disks.page.url') . $path;
    }

    /**
     * @param      $_path
     * @param bool $thumb
     *
     * @return bool
     */
    private function deleteImage($_path, $thumb = false)
    {
        /*if ($thumb) {
            $path = str_replace(config('filesystems.disks.page.url'), '', $_path);

            Storage::disk('page')->delete($path);
        }*/

        $path = str_replace(config('filesystems.disks.page.url'), '', $_path);

        return Storage::disk('page')->delete($path);
    }
}
