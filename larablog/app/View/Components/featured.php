<?php

namespace App\View\Components;

use App\Post;
use Illuminate\View\Component;

class featured extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.featured', [
            'feature_posts' => $this->feature_posts(),
        ]);
    }

    public function feature_posts()
    {
        return Post::WithCount('comments')->with('category')->latest('updated_at')->take(6)->get();
    }
}
