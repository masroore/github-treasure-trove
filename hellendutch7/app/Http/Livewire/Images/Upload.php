<?php

namespace App\Http\Livewire\Images;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class Upload extends Component
{
    use WithFileUploads;

    public $fileTitle;

    public $fileName;

    public $product_id;

    public function mount($product): void
    {
        $this->product_id = $product->id;
    }

    public function submit()
    {
        $this->validate([
            'fileName' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
        ]);

        $product = Product::find($this->product_id);

        $product->addMedia($this->fileName->getRealPath())
            ->usingName($this->fileName->getClientOriginalName())
            ->toMediaCollection('photos', 's3');

        return redirect('/product/' . $this->product_id);
    }

    public function render()
    {
        return view('livewire.images.upload');
    }
}
