<?php

namespace App\Http\Livewire\Admin\Pages;

use App\Http\Traits\ReservedPageSlugs;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class Edit extends Component
{
    use ReservedPageSlugs;

    public $page;

    public $title;

    public $slug;

    public $body;

    public $last_updated;

    public $status;

    protected $listeners = ['pageUpdated' => '$refresh'];

    public function mount($page): void
    {
        $this->page = $page;
        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->body = $page->body;
        $this->last_updated = $page->last_updated->format('d-m-Y');
        $this->status = $page->status;
    }

    public function updatePage()
    {
        $this->validate([
            'title' => 'required|string|max:100',
            'body' => 'required',
            'slug' => 'required',
            'status' => 'required',
            'last_updated' => 'required|date',
        ]);

        if ($this->page->slug != $this->slug) {
            if ($this->reserved($this->slug)) {
                return $this->addError('slug', 'This is reserved slug. Choose another one.');
            }
        }

        if ($this->reserved($this->page->slug) && $this->slug != $this->page->slug) {
            $this->slug = $this->page->slug;

            return $this->addError('slug', 'You cannot change the slug of this page.');
        }

        $this->page->update([
            'title' => $this->title,
            'body' => $this->body,
            'slug' => $this->slug,
            'status' => $this->status,
            'last_updated' => $this->last_updated,
        ]);

        $this->emit('pageUpdated', Lang::get('alerts.admin.pages.updated_success'));
    }

    public function render()
    {
        return view('livewire.admin.pages.edit');
    }
}
