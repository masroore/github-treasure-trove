<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class MakeViewCommand extends Command
{
    protected $signature = 'make:view {view}';

    protected $description = 'Create a new blade template.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $view = $this->argument('view');

        $path = $this->viewPath($view);

        $this->createDir($path);

        if (File::exists($path)) {
            $this->error("File {$path} already exists!");

            return;
        }

        File::put($path, $path);

        $this->info("File {$path} created.");
    }

    public function viewPath($view)
    {
        $view = str_replace('.', '/', $view) . '.blade.php';

        $path = "resources/views/{$view}";

        return $path;
    }

    public function createDir($path): void
    {
        $dir = dirname($path);

        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }
    }
}
