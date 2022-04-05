<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DoTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dodo:test';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $data = [
            1, 2, 3, 4, 5, 6,
        ];
        $this->permutation($data, 3);
        $this->combination($data, 3);
    }

    public function combination($data, $len = 2)
    {
        $list = [];
        if ($len == 3) {
            foreach ($data as $d1) {
                $t1 = $d1;
                foreach ($data as $d2) {
                    $t2 = $d2;
                    foreach ($data as $d3) {
                        $t3 = $d3;
                        if ($t1 != $t2 && $t2 != $t3 && $t1 != $t3) {
                            if (!in_array([$t3, $t2, $t1], $list) &&
                                !in_array([$t3, $t1, $t2], $list) &&
                                !in_array([$t2, $t1, $t3], $list) &&
                                !in_array([$t2, $t3, $t1], $list) &&
                                !in_array([$t1, $t3, $t2], $list)) {
                                array_push($list, [$t1, $t2, $t3]);
                            }
                        }
                    }
                }
            }
        } elseif ($len == 2) {
            foreach ($data as $d1) {
                $t1 = $d1;
                foreach ($data as $d2) {
                    $t2 = $d2;
                    if ($t1 != $t2) {
                        if (!in_array([$t2, $t1], $list)) {
                            array_push($list, [$t1, $t2]);
                        }
                    }
                }
            }
        }

        echo count($list);
        echo "\n";
        $un = array_unique($list, SORT_REGULAR);

        echo count($un);

        return $list;
    }

    public function permutation($data, $len = 3)
    {
        $list = [];
        if ($len == 3) {
            foreach ($data as $d1) {
                $t1 = $d1;
                foreach ($data as $d2) {
                    $t2 = $d2;
                    foreach ($data as $d3) {
                        $t3 = $d3;
                        if ($t1 != $t2 && $t2 != $t3 && $t1 != $t3) {
                            array_push($list, [$t1, $t2, $t3]);
                        }
                    }
                }
            }
        } elseif ($len == 2) {
            foreach ($data as $d1) {
                $t1 = $d1;
                foreach ($data as $d2) {
                    $t2 = $d2;
                    if ($t1 != $t2) {
                        array_push($list, [$t1, $t2]);
                    }
                }
            }
        }

        echo count($list);
        echo "\n";
        $un = array_unique($list, SORT_REGULAR);

        echo count($un);

        echo "\n";

        return $list;
    }
}
