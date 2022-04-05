<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Http\Traits\ReservedPageSlugs;
use App\Models\Admin\Page;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class Add extends Component
{
    use ReservedPageSlugs;

    public $title;

    public $body;

    public $slug;

    public $status = 'Draft';

    public $last_updated;

    public function updated($field): void
    {
        $this->validateOnly($field, [
            'slug' => 'unique:pages',
        ]);
    }

    public function addPage()
    {
        $this->validate([
            'title' => 'required|string|max:100',
            'body' => 'required',
            'slug' => 'required',
            'status' => 'required',
            'last_updated' => 'required',
        ]);

        if ($this->reserved($this->slug)) {
            return $this->addError('slug', 'This is reserved slug. Choose another one.');
        }

        $page = Page::create([
            'title' => $this->title,
            'body' => $this->body,
            'slug' => $this->slug,
            'status' => $this->status,
            'last_updated' => $this->last_updated,
        ]);

        laraflash(Lang::get('alerts.admin.pages.created_success'), Lang::get('alerts.success'))->success();

        return redirect()->route('admin.pages.index');
    }

    public function render()
    {
        return view('livewire.admin.pages.add');
    }
}
