<?php

namespace App\Http\Livewire\Market;

use App\Models\Manager;
use Livewire\Component;

class CarouselChild extends Component
{
    public $manager_id;

    public $image_id;

    public $ids = [];

    // public $selected_img ;
    public function render()
    {
        $manager = Manager::where('id', $this->manager_id)
            ->with('all_images')
            ->first();

        $all_images = $manager->all_images;
        $this->ids = $all_images->pluck('id')->toArray();
        $image_id = $this->image_id;

        $path = config('filesystems.disks.public.url');

        $selected_img = $manager->all_images()->where('id', $image_id)->first();

        return view('livewire.market.carousel-child', [
            'selected_img' => $selected_img,
            'all_images' => $all_images,
            'path' => $path,
        ]);
    }

    public function mount($manager_id, $image_id): void
    {
        $this->manager_id = $manager_id;
        $this->image_id = $image_id;
    }

    public function setImageId($image_id): void
    {
        $this->image_id = $image_id;
    }

    public function goNext(): void
    {
        $key = array_search($this->image_id, $this->ids);
        if ($key == count($this->ids) - 1) {
            $key = 0;
        } else {
            ++$key;
        }
        $this->image_id = $this->ids[$key];
    }

    public function goPrev(): void
    {
        $key = array_search($this->image_id, $this->ids);
        if ($key == 0) {
            $key = count($this->ids) - 1;
        } else {
            --$key;
        }
        $this->image_id = $this->ids[$key];
    }
}
