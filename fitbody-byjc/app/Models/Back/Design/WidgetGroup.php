<?php

namespace App\Models\Back\Design;

use Carbon\Carbon;
use DirectoryIterator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WidgetGroup extends Model
{
    /**
     * @var string
     */
    protected $table = 'widget_groups';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    private $request;

    /**
     * @var
     */
    private $url;

    /**
     * @param $query
     */
    public function widgets()
    {
        return $this->hasMany(Widget::class, 'group_id', 'id');
    }

    /**
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'section' => 'required',
            'title' => 'required',
        ]);

        $this->setRequest($request);

        return $this;
    }

    /**
     * @return array
     */
    public function getSectionsList()
    {
        $blades = new DirectoryIterator('./../resources/views/front/layouts/widgets');
        $response = [];

        foreach ($blades as $file) {
            if (false !== strpos($file, 'blade.php')) {
                $filename = str_replace('.blade.php', '', $file);

                $response[] = [
                    'id' => str_replace('widget_', '', $filename),
                    'title' => str_replace('widget_', 'Dizajn ', $filename),
                ];
            }
        }

        return $response;
    }

    public function store()
    {
        $id = $this->insertGetId([
            'section_id' => $this->request->section,
            'title' => $this->request->title,
            'slug' => Str::slug($this->request->title),
            'width' => $this->request->width ? $this->request->width : null,
            'status' => (isset($this->request->status) && 'on' == $this->request->status) ? 1 : 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $this->find($id);
    }

    /**
     * @param $id
     *
     * @return false
     */
    public function edit($id)
    {
        $ok = $this->where('id', $id)->update([
            'section_id' => $this->request->section,
            'title' => $this->request->title,
            'slug' => Str::slug($this->request->title),
            'width' => $this->request->width ? $this->request->width : null,
            'status' => (isset($this->request->status) && 'on' == $this->request->status) ? 1 : 0,
            'updated_at' => Carbon::now(),
        ]);

        if ($ok) {
            return $this->find($id);
        }

        return false;
    }

    /**
     * @return array[]
     */
    public function sizes()
    {
        return [
            [
                'value' => 12,
                'title' => '1:1 - Puna širina',
            ],
            [
                'value' => 6,
                'title' => '1:2 - Pola širine',
            ],
            [
                'value' => 4,
                'title' => '1:3 - Trećina širine',
            ],
            [
                'value' => 8,
                'title' => '2:3 - 2 trećine širine',
            ],
        ];
    }

    /**
     * Set Product Model request variable.
     *
     * @param $request
     */
    private function setRequest($request): void
    {
        $this->request = $request;
    }
}
