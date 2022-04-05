<?php

namespace App\Http\Traits;

trait EnvUpdater
{
    public function setEnv($name, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name . '=' . env($name),
                $name . '=' . $value,
                file_get_contents($path)
            ));

            return true;
        }

        return false;
    }
}
