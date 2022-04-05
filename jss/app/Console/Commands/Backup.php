<?php

namespace App\Console\Commands;

use App\Models\Operations\BackupDB;
use DateTime;
use Illuminate\Console\Command;

class Backup extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup DB';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $ds = DIRECTORY_SEPARATOR;
            $database = env('DB_DATABASE', '');
            $user = env('DB_USERNAME', 'root');
            $password = env('DB_PASSWORD', '');
            $path = database_path() . $ds . 'backups' . $ds . date('Y') . $ds . date('m') . $ds;
            $date = date('Y-m-d-His');
            $file = $date . '.sql';

            $mysqlPath = 'E:\\xampp/mysql/bin/mysqldump';
            if ($password != '') {
                $command = sprintf('%s -h localhost -u %s -p%s %s > %s', $mysqlPath, $user, $password, $database, $path . $file);
            } else {
                $command = sprintf('%s -h localhost -u %s %s > %s', $mysqlPath, $user, $database, $path . $file);
            }

            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            $backupTbl = new BackupDB();
            $params['filepath'] = $path;
            $params['filename'] = $file;
            $params['datetime'] = DateTime::createFromFormat('Y-m-d-His', $date); //->getTimestamp();
            $result = $backupTbl->addTransaction($params);
            $result = exec($command);
            //$this->info('The backup has been proceed successfully.');

            return 1;
        } catch (ProcessFailedException $exception) {
            $this->error('The backup process has been failed.');
        }
    }
}
