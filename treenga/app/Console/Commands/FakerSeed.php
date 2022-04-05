<?php

namespace App\Console\Commands;

use App\Services\FakerService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class FakerSeed extends Command
{
    protected $fakerService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faker:seed {--email=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add fake data';

    /**
     * Create a new command instance.
     */
    public function __construct(FakerService $fakerService)
    {
        parent::__construct();
        $this->fakerService = $fakerService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $options = $this->options();
        $rules = [
            'email' => 'required|array|min:1',
            'email.*' => 'required|email',
        ];

        $validator = Validator::make($options, $rules);
        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            exit();
        }

        $this->fakerService->runSeed($options['email']);
    }
}
