<?php

namespace FluentKit\Console\Commands;

use FluentKit\Role;
use FluentKit\User;
use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs FluentKit';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $user = new User();
        $user->email = $this->ask('Please enter the administrators email.');
        $user->first_name = $this->ask('Please enter the administrators first name.');
        $user->last_name = $this->ask('Please enter the administrators last name.');
        $password = $this->secret('Please enter the administrators password.');
        $confirmed = $this->secret('Please retype the password.');

        while ($confirmed !== $password) {
            $confirmed = $this->secret('Passwords do not match, please retype the password.');
        }

        $user->password = $password;
        $user->email_verified_at = now();

        if (!$this->confirm('Please confirm to install')) return;

        $this->call('migrate');
        //$this->call('optimize');

        $this->info('Creating core roles');
        $this->call('db:seed', ['--class' => \RolesSeeder::class]);

        $this->info('Creating admin user.');

        $superAdmin = Role::where('name', 'superAdmin')->first();
        $user->save();
        $user->roles()->attach($superAdmin);
        $user->push();

        $this->info('Install completed.');
    }
}
