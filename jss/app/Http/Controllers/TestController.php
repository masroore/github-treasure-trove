<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function gitPull(): void
    {
        $output = null;
        $retval = null;
        exec('cd ' . base_path(), $output, $retval);
        exec('git pull', $output, $retval);
        print_r('Status: ' . $retval . '<br>');
        foreach ($output as $key => $item) {
            print_r($item . '<br>');
        }
    }
}
