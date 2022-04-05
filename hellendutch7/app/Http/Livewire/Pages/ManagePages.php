<?php

namespace App\Http\Livewire\Pages;

use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class ManagePages extends Component
{
    public $name;

    public $slug;

    public $featured_img;

    public $title;

    public $pages;

    public $thisid;

    public $currentuser;

    public $updateMode = false;

    public $active = 0;

    public $addPageVisible = false;

    public $owner_id;

    public $templates;

    public function render()
    {
        $this->pages = Page::all();

        return view('livewire.pages.manage-pages');
    }

    public function updatedName(): void
    {
        $this->validate(['name' => 'unique:pages']);
    }

    public function add(): void
    {
        $data = $this->validate([
            'name' => 'required | min:5| max:24 |unique:pages',
            'title' => 'required | min:5| max:24',
            'featured_img' => '',
        ]);

        Page::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name'] . '-' . $data['title'], '-'),
            'title' => $data['title'],
            'owner_id' => 1,
            'featured_img' => $data['featured_img'],
            'active' => $this->active,
        ]);

        $this->reset('name', 'title', 'active');
    }

    public function edit($id): void
    {
        $editpage = Page::find($id);

        $this->thisid = $editpage->id;
        $this->name = $editpage->name;
        $this->title = $editpage->title;
        $this->featured_img = $editpage->featured_img;
        $this->active = $editpage->active;
        $this->owner_id = Auth::id();

        $this->updateMode = 'true';
    }

    public function update(): void
    {
        $data = $this->validate([
            'name' => 'required | min:5| max:24',
            'title' => 'required | min:5| max:24',
            'featured_img' => '',
            'active' => '',
            'owner_id' => 'required',
        ]);
        $updated = Page::find($this->thisid);

        $updated->name = $data['name'];
        $updated->slug = Str::slug($data['name'] . '-' . $data['title'], '-');
        $updated->title = $data['title'];
        $updated->featured_img = $data['featured_img'];
        $updated->active = $data['active'];
        $updated->owner_id = $data['owner_id'];
        $updated->save();
        //  dd($updated);

        $this->activity = 'S';
        $this->reset('name', 'title', 'active', 'updateMode');
    }

    public function destroy($id): void
    {
        if ($id) {
            $record = Page::where('id', $id);
            $record->delete();
            $this->reset('name', 'title', 'active', 'updateMode');
        }
    }
}
