<?php

namespace App\Http\Livewire\Market;

use App\Models\Manager;
use Livewire\Component;

class Carousels extends Component
{
    public $manager_id;

    public $open;

    public $image_id;

    public $image_ids = [];

    public function render()
    {
        $manager = Manager::where('id', $this->manager_id)
            ->with('all_images')
            ->first();
        $images = $manager->all_images->pluck('org_path')->all();

        $all_images = $manager->all_images;
        $all_images = $all_images->pluck('org_path', 'id')->toArray();

        $path = config('filesystems.disks.public.url');
        $selected_img = $manager->all_images()->where('id', $this->image_id)->first();
        // dd($selected_image);

        return view('livewire.market.carousels', [
            'manager' => $manager,
            'images' => $images,
            'all_images' => $all_images,
            'path' => $path,
            'selected_img' => $selected_img,
        ]);
    }

    public function mount($manager_id): void
    {
        $this->manager_id = $manager_id;
    }

    public function setOpen($image_id): void
    {
        $this->image_id = $image_id;
        $this->open = true;
        $this->emit('CarouselOpen', $image_id);
    }

    public function dadatedImageId($value): void
    {
        dd($value);
    }

    public function setClose(): void
    {
        $this->open = false;
        $this->image_id = null;
    }

    public function goNext(): void
    {
    }

    public function goPrev(): void
    {
    }
}
