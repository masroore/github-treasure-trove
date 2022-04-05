<?php

namespace Modules\ExternalShop\Console;

use Illuminate\Console\Command;

class GetOrders extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'external-shop:get-orders
        {--source= : Allowed: prom | rozetka}
        {--now : Will be run immediately}
        {--last : Get last orders (24H)}
        {--force : Update if isset or create new}
        {--event : Fire event OrderCreated (if force=false)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        $source = $this->option('source');
        $force = $this->option('force') ? true : false;
        $last = $this->option('last') ? true : false;
        $event = $this->option('event') ? true : false;

        if ($this->option('now')) {
            \Modules\ExternalShop\Jobs\GetOrders::dispatchNow($source, $force, $last, $event);
        } else {
            \Modules\ExternalShop\Jobs\GetOrders::dispatch($source, $force, $last, $event);
        }
    }
}
