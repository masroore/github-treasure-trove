<?php

namespace App\Console\Commands\Shop;

use Illuminate\Console\Command;

class ProductRatingCalculate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:product-rating-calculate {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate/recalculate product ratings
                                {--force : Force run}';

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
        $products = \App\Models\Shop\Product::all();

        if ($this->option('force')) {
            $asc = true;
        } else {
            $asc = $this->ask('Calculate rating for ' . $products->count() . ' products ?');
        }

        if ($asc) {
            $bar = $this->output->createProgressBar(count($products));
            $bar->start();

            foreach ($products as $product) {
                $product->setAttribute('rating', $product->calculateRating());
                $product->save();
                $bar->advance();
            }

            $bar->finish();
            $this->output->newLine();
        }
    }
}
