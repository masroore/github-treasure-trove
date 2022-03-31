<?php

namespace App\Models\Back\Marketing\Slider;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Slider extends Model
{
    /**
     * @var string
     */
    protected $table = 'sliders';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;

    /**
     * Validate Page Request.
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'group' => 'required',
        ]);

        $this->request = $request;

        return $this;
    }

    /**
     * @return bool
     */
    public function store()
    {
        $id = $this->insertGetId([
            'group_id'       => $this->request->group,
            'message'        => '',
            'title'          => $this->request->title,
            'subtitle'       => $this->request->subtitle,
            'text_color'     => (isset($this->request->text_color) && 'on' == $this->request->text_color) ? 'white' : 'black',
            'text_placement' => (isset($this->request->text_placement) && 'on' == $this->request->text_placement) ? 'center' : 'left',
            'sort_order'     => !empty($this->request->sort_order) ? $this->request->sort_order : 0,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        if ($id) {
            return $this->find($id);
        }

        return false;
    }

    /**
     * @return bool|mixed
     */
    public function resave($id)
    {
        //dd($this);
        return $this->where('id', $id)->update([
            'group_id'       => $this->request->group,
            'message'        => '',
            'title'          => $this->request->title,
            'subtitle'       => $this->request->subtitle,
            'text_color'     => (isset($this->request->text_color) && 'on' == $this->request->text_color) ? 'white' : 'black',
            'text_placement' => (isset($this->request->text_placement) && 'on' == $this->request->text_placement) ? 'center' : 'left',
            'sort_order'     => !empty($this->request->sort_order) ? $this->request->sort_order : 0,
            'updated_at'     => Carbon::now(),
        ]);
    }

    public function resolveImage($id)
    {
        $data = json_decode($this->request->image);

        $group = SliderGroup::where('id', $this->request->group)->first();
        $path = $group->id . '/' . time() . '_' . $data->output->name;
        $img = Image::make($data->output->image)->encode(str_replace('image/', '', $data->output->type));

        Storage::disk('slider')->put($path, $img);

        $slider = self::where('id', $id)->first();

        if ($slider->image && 'media/temp/slider/1.jpg' != $slider->image) {
            $delete_path = str_replace(config('filesystems.disks.slider.url'), '', $slider->image);

            Storage::disk('slider')->delete($delete_path);
        }

        return $slider->update([
            'image' => config('filesystems.disks.slider.url') . $path,
        ]);
    }
}
