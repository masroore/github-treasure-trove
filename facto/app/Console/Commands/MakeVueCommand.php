<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeVueCommand extends Command
{
    protected $signature = 'make:vue {vue}';

    protected $description = 'Create a new Vue Component';

    public function __construct()
    {
        parent::__construct();
    }

    protected function getStub()
    {
        return __DIR__ . '/../stubs/vue-component.stub';
    }

    public function handle(): void
    {
        $view = $this->argument('vue');

        $path = $this->viewPath($view);

        $this->createDir($path);

        if (File::exists($path)) {
            $this->error("File {$path} already exists!");

            return;
        }

        // $content = File::get( $this->getStub() );
        File::put($path, $this->getContent());

        $this->info("File {$path} created.");
    }

    public function viewPath($view)
    {
        $view = str_replace('.', '/', $view) . '.vue';
        $path = "resources/js/components/{$view}";

        return $path;
    }

    public function createDir($path): void
    {
        $dir = dirname($path);
        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }
    }

    protected function getContent()
    {
        return '<script>
    export default {
        data() {
            return {
                //
            };
        }
    }
</script>

<template>
    <!-- Your {Component} component\'s template -->
</template>';
    }
}
