<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\ClickLog\Entities\ClickLog;

class BackupDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sql = 'select thumb_path, count(thumb_path) from posts group by ( thumb_path) having count(thumb_path)>1 ;';

        $posts = DB::table('posts')
            ->select('thumb_path', DB::raw('count(*) as count'))
            ->whereBetween('created_at', ['2021-02-01 00:00:01', '2021-04-14 00:00:01'])
            ->groupBy('thumb_path')
            ->havingRaw('count( thumb_path) > 1 ')
            ->get();

        // $posts = DB::table('posts')
        //         ->select('title', DB::raw('count(*) as count'))
        //         ->groupBy('title')
        //         ->havingRaw( 'count( title) > 1 ')
        //         ->get();

        dd($posts->count());
        $total = $posts->count();
        $it = 0;
        foreach ($posts as $post) {
            // dd($post);
            // $title = $post->title ;

            $thumb_path = $post->thumb_path;
            $remove_post = Post::where('thumb_path', $thumb_path)
                ->orderBy('id', 'desc')
                ->skip(1)
                ->first();
            // ->get();
            $post_id = $remove_post->id;
            $remove_post->delete();

            $click_log = ClickLog::find($post_id);
            $click_log->delete();

            echo $it++ . ' / ' . $total . ' deleted ' . "\n";
        }
        // dd($posts->count());
        // $posts = DB::select($sql );
        // dd(count($posts));
    }
}
