<?php

namespace App\Console\Commands;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class ActivateBlog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blogs:activate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to publish the registered blogs';

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
     * @return mixed
     */
    public function handle()
    {
        try {
            Blog::whereRaw("'" . Carbon::now()->toDateTimeString() . "'" . ' >= date_to_publish')
                ->update([
                    'status' => 1,
                ]);

            echo 'Blogs activados correctamente';
        } catch (QueryException $e) {
            echo 'Hubo un error al activar el blog' . $e->getMessage();
        }
    }
}
