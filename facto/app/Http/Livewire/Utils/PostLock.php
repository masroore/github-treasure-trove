<?php

namespace App\Http\Livewire\Utils;

use App\Models\Post;
use App\Models\Upso;
// use App\Models\Setting;
use Carbon\Carbon;
use Livewire\Component;

class PostLock extends Component
{
    public $post_id;

    public $page;

    public $update = false;

    public function render()
    {
        return view('livewire.utils.post-lock', [
            'status' => Upso::find($this->post_id)->status,
        ]);
    }

    public function mount($upsoid): void
    {
        $this->post_id = $upsoid;
        $this->page = request()->fullUrl();
    }

    public function setLock()
    {
        $post = Upso::find($this->post_id);
        $post->status = 'Locked';
        $post->save();
        $this->saveCache($post);

        return redirect($this->page);
    }

    public function setUnlock()
    {
        $post = Upso::find($this->post_id);
        $post->status = 'Active';
        $post->save();
        $this->saveCache($post);

        return redirect($this->page);
    }

    public function saveCache($post): void
    {
        /* $id= $post->id;
        $post_cat_id= $post->post_cat->id ;
        $cache_key = implode('.' , ['post-show', $id  ] );
        Cache::forget( $cache_key);

        $cache_key = 'best-posts-list-' . $post_cat_id . '.week' ;
        Cache::forget($cache_key);
        $cache_key = 'best-posts-list-' . $post_cat_id . '.month' ;
        Cache::forget($cache_key);

        $cache_key = 'wide-posts-recent-list-' . $post_cat_id ;
        Cache::forget($cache_key);
        $cache_key = 'wide-posts-recent-image-' . $post_cat_id ;
        Cache::forget($cache_key);

        $cache_key = 'front-posts-recent-image-' . $post_cat_id ;
        Cache::forget($cache_key);
        $cache_key = 'front-posts-recent-list-' . $post_cat_id ;
        Cache::forget($cache_key); */

        // $last =  Carbon::today()->subDays(1)->toDateString();
        // $count = $this->get_best_upsos_count();
        /* $post_cat_ids = [ $post_cat_id];
        $cache_key = 'upso-logs-best-' . $count . '-' . $last . '-'.  implode( '-', $post_cat_ids);
        Cache::forget($cache_key);

        $post_cat_ids= [33,34,35,36,37 ];
        $cache_key = 'upso-logs-best-' . $count . '-' . $last . '-'.  implode( '-', $post_cat_ids);
        Cache::forget($cache_key);
 */
    }

    /* function get_best_upsos_count(){
        $key = 'general';
        $setting = Setting::where('key', $key)
                ->first();
        $data = unserialize($setting->value);
        $best_upsos_count = $data['best_upsos_count'] ?? 5 ;

        return (int) $best_upsos_count;

    } */
}
