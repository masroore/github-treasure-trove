<?php

namespace App\Console\Commands;

use Config;
use Illuminate\Console\Command;
use mysqli;

class InitDatabase extends Command
{
    protected $signature = 'init:db';

    protected $description = 'Databas init ';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->init();
    }

    public function init(): void
    {
        $db_type = Config::get('database.default');
        $connection = Config::get('database.connections.' . $db_type);
        $host = $connection['host'];
        $username = $connection['username'];
        $password = $connection['password'];
        $database = $connection['database'];

        try {
            // Create connection
            $conn = new mysqli($host, $username, $password);
            if ($conn->connect_error) {
                exit('Connection failed: ' . $conn->connect_error);
            }
            // Drop database
            $sql = "DROP DATABASE `$database`";
            if ($conn->query($sql) === true) {
                echo "Sucessfully dropped database $database!";
                echo "\n";
            } else {
                echo 'Error dropping database: ' . $conn->error;
                echo "\n";
            }
            $conn->close();
        } catch (Exception $e) {
            $this->info('');
            echo "Error dropping database: $database";
            echo "\n";
            $this->info('');
            echo json_encode($e->getMessage());
            $this->info('');
            $conn->close();
        }

        try {
            // Create connection
            $conn = new mysqli($host, $username, $password);
            if ($conn->connect_error) {
                exit('Connection failed: ' . $conn->connect_error . "\n");
            }
            // Drop database
            $sql = "CREATE DATABASE `$database`";
            if ($conn->query($sql) === true) {
                echo "Sucessfully created database $database!";
                echo "\n";
            } else {
                echo 'Error Creating database: ' . $conn->error;
                echo "\n";
            }
            $conn->close();
        } catch (Exception $e) {
            $this->info('');
            echo "Error Creating database: $database";
            echo "\n";
            $this->info('');
            echo json_encode($e->getMessage());
            echo "\n";
            $this->info('');
            $conn->close();
        }
    }
}
