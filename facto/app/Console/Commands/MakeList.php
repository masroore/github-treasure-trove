<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeList extends Command
{
    protected $signature = 'make:list';

    protected $description = '리스트 페이지 우측의 리스트들 만들기';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        dd('aaa');
    }
}
