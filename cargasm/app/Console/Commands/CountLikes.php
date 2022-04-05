<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Console\Command;

class CountLikes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'likes:count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Likes count';

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
        $posts = Post::where('status', Post::POST_PUBLISHED)->withCount('likes', 'comments')->get();
        $photos = Photo::withCount('likes', 'comments')->get();
        $events = Event::withCount('likes', 'comments')->get();

        foreach ($photos as $photo) {
            $photo->update([
                'comment_count' => $photo->comments_count,
                'likeable_count' => $photo->likes_count,
            ]);
        }
        foreach ($posts as $post) {
            $post->update([
                'comment_count' => $post->comments_count,
                'likeable_count' => $post->likes_count,
            ]);
        }
        foreach ($events as $event) {
            $event->update([
                'comment_count' => $event->comments_count,
                'likeable_count' => $event->likes_count,
            ]);
        }
    }
}
