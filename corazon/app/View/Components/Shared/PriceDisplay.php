<?php

namespace App\View\Components\Shared;

use Closure;
use Illuminate\View\Component;

class PriceDisplay extends Component
{
    public $model;

    public $text = '';

    protected $price;

    /**
     * Create a new component instance.
     */
    public function __construct($model)
    {
        $this->model = $model;
        if ($model->is_free) {
            $this->text = 'Free';
        } else {
            if ($model->prices()->count() == 0) {
                $this->text = 'Not available';
            } elseif ($model->prices()->count() == 1) {
                $this->price = $model->prices()->first();
                $this->text = strtoupper($this->price->currency) . ' ' . abs($this->price->amount);
            } else {
                $this->price = $model->prices()->orderBy('amount', 'asc')->first();
                $this->text = 'from ' . strtoupper($this->price->currency) . ' ' . abs($this->price->amount);
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.shared.price-display');
    }
}
