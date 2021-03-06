<?php

namespace App\Http\Livewire\Filter;

use App\Models\Filter;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class Create extends Component
{
    use ValidatesMedia;
    use WithFileUploads;
    use WithMedia;

    public $filter;

    public $sel_filter;

    public $update;

    public $name;

    public $type;

    public $firsttype;

    public $color;

    public $firstcolor;

    public $wratten;

    public $schott;

    public $media;

    public $mediaComponentNames = ['media'];

    public $disableColorFields;

    protected $rules = [
        'name' => ['required', 'min:6'],
        'type' => ['required'],
        'wratten' => ['max:5'],
    ];

    public function mount(): void
    {
        if ($this->filter->exists) {
            $this->update = true;
            $this->name = $this->filter->name;
            $this->type = $this->filter->type;
            $this->firsttype = $this->type;
            if ($this->type == 0 || $this->type == 6) {
                $this->color = $this->filter->color;
                $this->firstcolor = $this->color;
                $this->wratten = $this->filter->wratten;
                $this->schott = $this->filter->schott;
                $this->disableColorFields = false;
            } else {
                $this->disableColorFields = true;
            }
        } else {
            $this->update = false;
            $this->firsttype = -1;
            $this->firstcolor = 0;
            $this->disableColorFields = false;
        }
    }

    /**
     * Real time validation.
     *
     * @param mixed $propertyName The name of the property
     */
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);

        if ($propertyName == 'sel_filter') {
            $this->filter = \App\Models\Filter::where('id', $this->sel_filter)->first();
            $this->name = $this->filter->name;
            $this->type = $this->filter->type;
            if ($this->type == 0 || $this->type == 6) {
                $this->color = $this->filter->color;
                $this->wratten = $this->filter->wratten;
                $this->schott = $this->filter->schott;
                $this->disableColorFields = false;
            } else {
                $this->disableColorFields = true;
            }
        }

        if ($propertyName == 'type') {
            if ($this->type != 0 && $this->type != 6) {
                $this->color = '';
                $this->wratten = '';
                $this->schott = '';
                $this->disableColorFields = true;
            } else {
                $this->disableColorFields = false;
            }
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->update) {
            // Update the existing filter
            $this->filter->update(['name' => $this->name]);
            $this->filter->update(['type' => $this->type]);
            if ($this->color == '') {
                $this->filter->update(['color' => null]);
            } else {
                $this->filter->update(['color' => $this->color]);
            }
            if ($this->wratten == '') {
                $this->filter->update(['wratten' => null]);
            } else {
                $this->filter->update(['wratten' => $this->wratten]);
            }
            if ($this->schott == '') {
                $this->filter->update(['schott' => null]);
            } else {
                $this->filter->update(['schott' => $this->schott]);
            }
            $filter = $this->filter;
            laraflash(_i('Filter %s updated', $filter->name))->success();
        } else {
            // Create a new filter
            $filter = Filter::create(
                ['user_id' => Auth::user()->id,
                    'name' => $this->name,
                    'type' => $this->type,
                    'color' => $this->color,
                    'wratten' => $this->wratten,
                    'schott' => $this->schott,
                    'active' => 1, ]
            );
            laraflash(_i('Filter %s created', $filter->name))->success();
        }

        // Upload of the image
        if ($this->media) {
            if (Filter::find($filter->id)->getFirstMedia('filter') != null) {
                // First remove the current image
                Filter::find($filter->id)
                    ->getFirstMedia('filter')
                    ->delete();
            }
            // Update the picture
            Filter::find($filter->id)
                ->addFromMediaLibraryRequest($this->media)
                ->toMediaCollection('filter');
        }

        // View the page with all filters for the user
        return redirect(route('filter.index'));
    }

    public function render()
    {
        return view('livewire.filter.create');
    }
}
