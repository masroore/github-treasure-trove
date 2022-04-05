<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UtilsController extends Controller
{
    private $expiredFileCount;

    private $expiredFileSize;

    private $activeFileCount;

    private $activeFileSize;

    protected function initCache(): void
    {
        $cacheDisk = [
            'driver' => 'local',
            'root' => config('cache.stores.file.path'),
        ];

        config(['filesystems.disks.fcache' => $cacheDisk]);
    }

    public function cacheClear(): void
    {
        $time = 60 * 10;
        ini_set('max_execution_time', $time);

        echo "\n\n";
        echo 'start : ' . Carbon::now()->toDateTimeString() . "\n";

        $this->initCache();

        $this->deleteExpiredFiles();
        $this->deleteEmptyFolders();
        $this->showResults();

        echo 'end : ' . Carbon::now()->toDateTimeString() . "\n";
        echo "\n\n";
    }

    private function deleteExpiredFiles(): void
    {
        $files = Storage::disk('fcache')->allFiles();
        echo 'all files = ' . count($files) . '<br>';

        // $this->output->progressStart(count($files));

        // Loop the files and get rid of any that have expired
        foreach ($files as $key => $cachefile) {
            // Ignore files that named with dot(.) at the begining e.g. .gitignore
            if (substr($cachefile, 0, 1) == '.') {
                continue;
            }

            // Grab the contents of the file
            $contents = Storage::disk('fcache')->get($cachefile);

            // Get the expiration time
            $expire = substr($contents, 0, 10);

            // See if we have expired
            if (time() >= $expire) {
                // Delete the file
                $this->expiredFileSize += Storage::disk('fcache')->size($cachefile);
                Storage::disk('fcache')->delete($cachefile);
                ++$this->expiredFileCount;
            } else {
                ++$this->activeFileCount;
                $this->activeFileSize += Storage::disk('fcache')->size($cachefile);
            }
            // $this->output->progressAdvance();
        }
        echo 'all files counted . <br>';
        // $this->output->progressFinish();
    }

    private function deleteEmptyFolders(): void
    {
        $directories = Storage::disk('fcache')->allDirectories();
        $dirCount = count($directories);
        // looping backward to make sure subdirectories are deleted first
        while (--$dirCount >= 0) {
            if (!Storage::disk('fcache')->allFiles($directories[$dirCount])) {
                Storage::disk('fcache')->deleteDirectory($directories[$dirCount]);
            }
        }
    }

    public function showResults(): void
    {
        $expiredFileSize = $this->formatBytes($this->expiredFileSize);
        $activeFileSize = $this->formatBytes($this->activeFileSize);

        if ($this->expiredFileCount) {
            // $this->info("✔ {$this->expiredFileCount} expired cache files removed");
            // $this->info("✔ {$expiredFileSize} disk cleared");
            echo "✔ {$this->expiredFileCount} expired cache files removed <br>";
            echo "✔ {$expiredFileSize} disk cleared <br>";
        } else {
            // $this->info('✔ No expired cache file found!');
            echo '✔ No expired cache file found! <br>';
        }
        // $this->line("✔ {$this->activeFileCount} non-expired cache files remaining");
        // $this->line("✔ {$activeFileSize} disk space taken by non-expired cache files");

        echo "✔ {$this->activeFileCount} non-expired cache files remaining. <br>";
        echo "✔ {$activeFileSize} disk space taken by non-expired cache files.<br>";
    }

    private function formatBytes($size, $precision = 2)
    {
        $unit = ['Byte', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];

        for ($i = 0; $size >= 1024 && $i < count($unit) - 1; ++$i) {
            $size /= 1024;
        }

        return round($size, $precision) . ' ' . $unit[$i];
    }
}
