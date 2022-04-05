<?php

namespace App\Http\Middleware;

use App\Category;
use Closure;

class VerifyCategoryCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Category::count() == 0) {
            session()->flash('error', 'You have to add categories first inorder to add products.');

            return redirect(route('categories.create'));
        }

        return $next($request);
    }
}
