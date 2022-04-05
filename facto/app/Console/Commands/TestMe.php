<?php

namespace App\Console\Commands;

use App\CommentFix;
use App\CustomerFix;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\Post;
use App\PostFix;
use App\PostTagFix;
use Illuminate\Console\Command;

class TestMe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testme';

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

    public function handle(): void
    {

        // use repair;
        // update posts set fixed = 0;
        // update customers set fixed = 0;
        // ALTER TABLE post ADD COLUMN foo INT DEFAULT 0;
        // $post = Post::with('tags')->latest()->first();
        // dd($post->toArray());

        $customerfixes = CustomerFix::where('created_at', '>', '2021-02-06 00:00:01')
            ->where('fixed', 0)
            ->orderBy('created_at', 'asc')
            ->get();

        $total = $customerfixes->count();
        $iter = 1;

        foreach ($customerfixes  as $customerfix) {
            echo "\n";
            echo $iter . ' / ' . $total . "\n";
            echo 'old ID : ' . $customerfix->id . "\n";
            echo 'old title  : ' . $customerfix->title . "\n";
            echo 'old content  : ' . $customerfix->content . "\n";

            // dd($postfix->toArray());
            // $tags = $postfix->tags()->pluck('id');
            $created_at = $customerfix->created_at;
            $updated_at = $customerfix->updated_at;

            $commentfixes = CommentFix::where('customer_id', $customerfix->id)->get();

            $customer = $customerfix->toArray();
            unset($customer['id'], $customer['fixed']);

            $newcustomer = Customer::firstOrCreate($customer);
            $newcustomer->created_at = $created_at;
            $newcustomer->updated_at = $updated_at;
            $newcustomer->save();

            foreach ($commentfixes as $commentfix) {
                $created_at_comment = $commentfix->created_at;
                $updated_at_comment = $commentfix->updated_at;
                $comment = $commentfix->toArray();
                unset($comment['id']);
                $comment['customer_id'] = $newcustomer->id;

                $newcomment = Comment::firstOrCreate($comment);
                $newcomment->created_at = $created_at_comment;
                $newcomment->updated_at = $updated_at_comment;
                $newcomment->save();
            }

            $customerfix->fixed = 1;
            $customerfix->save();
            // dd($newcustomer->toArray());
            ++$iter;
        }

        $postfixes = PostFix::where('created_at', '>', '2021-02-06 00:00:01')
            ->where('id', '>', 8151)
            ->where('fixed', 0)
            ->get();

        $total = $postfixes->count();

        $iter = 1;
        foreach ($postfixes  as $postfix) {
            echo "\n";
            echo $iter . ' / ' . $total . "\n";
            echo 'old ID : ' . $postfix->id ,"\n";

            // dd($postfix->toArray());
            // $tags = $postfix->tags()->pluck('id');
            $created_at = $postfix->created_at;
            $updated_at = $postfix->updated_at;

            $tags = PostTagFix::where('post_id', $postfix->id)->get()->pluck('tag_id')->toArray();
            $tag_all = [];
            foreach ($tags as $key => $tag) {
                $tag_all[] = $tag;
            }
            // $post = $postfix->replicate();
            $post = $postfix->toArray();
            unset($post['fixed']);

            $newpost = Post::firstOrCreate($post);
            $newpost->created_at = $created_at;
            $newpost->updated_at = $updated_at;
            $newpost->save();
            $newpost->tags()->sync($tag_all);

            $postfix->fixed = 1;
            $postfix->save();

            $post = Post::with('tags')->find($newpost->id);

            // print_r( $post->toArray());
            ++$iter;
        }
        dd('done');
    }

    public function do()
    {
        return false;
    }
}
