<?php

namespace App\Console\Commands\Shop;

use Illuminate\Console\Command;

class MetaTagsGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:meta-tags-generate
                            {--force}
                            {--og-img}
                            {--regenerate}
                            {--model=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Meta-tags generate
                                {--force : Force run}
                                {--regenerate: Regenerate if isset}
                                {--model : Your model(s) namespace}';

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
        $models = $this->option('model') ?: [
            \App\Models\Taxonomy\Term::class,
            \App\Models\Page::class,
            \App\Models\Shop\Sale::class,
            \App\Models\Shop\Product::class,
        ];

        if ($this->option('force')) {
            $asc = true;
        } else {
            $asc = $this->ask('Regenerate meta-tags for models: [' . implode(', ', $models) . ']?');
        }

        if ($asc) {
            foreach ($models as $model) {
                if (class_exists($model)) {
                    $all = app()->make($model)::all();

                    $this->info("Model [$model]:");

                    $bar = $this->output->createProgressBar($all->count());
                    $bar->start();

                    foreach ($all as $item) {
                        if ($tags = $item->generateMetaTags()) {
                            if ($this->option('regenerate')) {
                                $metaTag = $item->metaTag()->updateOrCreate([], $tags);
                                if ($this->option('og-img')) {
                                    $this->createOgImage($item, $metaTag);
                                }
                                $bar->finish();
                            } elseif (!$item->metaTag) {
                                $metaTag = $item->metaTag()->create($tags);
                                if ($this->option('og-img')) {
                                    $this->createOgImage($item, $metaTag);
                                }
                                $bar->finish();
                            }
                        }
                    }

                    $this->output->newLine();
                } else {
                    $this->error("Class [$model] not found.");
                }
            }
        }
    }

    protected function createOgImage($node, $metaTag): void
    {
        $ogImgName = md5($metaTag->id);

        $imgData = $node->generateMetaTagOgImgData();

        $fileObj = $this->generateOgImg($imgData, $ogImgName);

        $metaTag->setAttribute('og_image', 'storage/og/' . $fileObj->basename);

        $metaTag->save();
    }

    protected function generateOgImg(array $imgData, $ogImgName)
    {
        $ogImgGenerator = new \App\Helpers\OgImageGenerator();

        if (isset($imgData['title'])) {
            $ogImgGenerator->setTitle($imgData['title']);
        }

        if (isset($imgData['subtitle'])) {
            $ogImgGenerator->setCategoryTitle($imgData['subtitle']);
        }

        if (isset($imgData['img']) && file_exists($imgData['img'])) {
            $ogImgGenerator->setLogoPath($imgData['img']);
        }

        return $ogImgGenerator->save($ogImgName);
    }
}
