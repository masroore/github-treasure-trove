<?php

namespace App\Libraries;

use ZipArchive;

class ExportMap
{
    private $temp_folder;

    private $pgsql2shp;

    public function __construct()
    {
        $this->temp_folder = env('TEMP_FOLDER');
        $this->pgsql2shp = env('PGSQL2SHP');
    }

    public function export($map_name)
    {
        $temp = 'bappeko-sigis2_' . uniqid();
        mkdir($this->temp_folder . $temp . '/');

        $cmd = $this->pgsql2shp;
        $cmd .= ' -f ' . escapeshellarg($this->temp_folder . $temp . '/' . $map_name);
        $cmd .= ' -h ' . escapeshellarg(env('DB_HOST'));
        $cmd .= ' -u ' . escapeshellarg(env('DB_USERNAME'));
        $cmd .= ' -P ' . escapeshellarg(env('DB_PASSWORD'));
        $cmd .= ' ' . escapeshellarg(env('DB_DATABASE')) . ' ' . escapeshellarg('maps.' . $map_name);

        $shp2pgsqlOutput = [];
        $retVal = -1;

        exec($cmd, $shp2pgsqlOutput, $retVal);

        if ($retVal != 0) {
            //FAILED CMD
            return [
                'http_code' => 500,
                'message' => 'Peta ' . $map_name . ' gagal diexport. ' . $cmd,
            ];
        }
        $filename = $this->temp_folder . $temp . '/' . $map_name;
        $files = [$filename . '.shp', $filename . '.dbf', $filename . '.shx', $filename . '.prj'];

        $download = self::create_zip($files, $filename . '.zip');
        if ($download) {
            $url = url('/download?file=' . $temp . '&map=' . $map_name);

            return [
                'http_code' => 200,
                'message' => 'Peta ' . $map_name . ' berhasil diexport. klik <a href=\'' . $url . '\' data-autodownload=\'true\'>di sini.</a> Jika tidak mendownload secara otomatis',
                'url' => $url,
            ];
        }
        //FAILED ZIP
        return [
            'http_code' => 500,
            'message' => 'Peta ' . $map_name . ' gagal diexport.',
        ];
    }

    private function create_zip($files = [], $destination = '', $overwrite = false)
    {
        if (file_exists($destination) && !$overwrite) {
            return false;
        }

        $valid_files = [];
        if (is_array($files)) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }

        if (count($valid_files)) {
            $zip = new ZipArchive();
            if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
                return false;
            }

            foreach ($valid_files as $file) {
                $new_filename = substr($file, strrpos($file, '/') + 1);
                $zip->addFile($file, $new_filename);
            }
            $zip->close();

            return file_exists($destination);
        }

        return false;
    }
}
