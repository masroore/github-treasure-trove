<?php

namespace App\Http\Livewire\TopPages;

use App\Models\Paragraph;
use Livewire\Component;

class StaticPage extends Component
{
    public $paras = [];

    public $page;

    public function mount($page): void
    {
        $this->page = $page;
    }

    public function render()
    {
        $this->paras = Paragraph::where('page_id', $this->page)->get();

        return view('livewire.top-pages.static-page');
    }
}
