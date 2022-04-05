<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class UpdateUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alter:role
                            {user : The ID of the user}
                            {role : The role you wish to assign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a given user\'s role within the application. Usage: alter:role 1 admin';

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
        // adapted from: https://github.com/zaknes/forum
        $user = User::find($this->argument('user'));

        if (!$user) {
            exit($this->error('Invalid user ID'));
        }

        $role = $this->argument('role');

        if (!in_array($role, Config::get('enums.roles'))) {
            exit($this->error('Invalid role'));
        }

        $user->role = $role;
        $user->update();

        $this->info('User ' . $user->id . ' has been updated to ' . $role);
    }
}
