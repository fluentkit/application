<?php

namespace FluentKit\Console\Commands;

use FluentKit\App;
use FluentKit\AppDomain;
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
    protected $signature = 'install
                            {--ci}
                            {--app-name="Master Application"}
                            {--app-domain="http://localhost"}
                            {--email=}
                            {--first-name=}
                            {--last-name=}
                            {--password=}';

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
        $ci = $this->hasOption('ci');
        $app = new App();
        $app->master = true;
        $app->name = $ci ? $this->option('app-name') ? $this->ask('Please enter the master applications name.', 'Master Application');

        $appDomain = new AppDomain();
        $appDomain->domain = $ci ? $this->option('app-domain') ? $this->ask('Enter the master applications domain name.');

        $user = new User();
        $user->app_id = null;
        $user->email = $ci ? $this->option('email') ? $this->ask('Please enter the administrators email.');
        $user->first_name = $ci ? $this->option('first-name') ? $this->ask('Please enter the administrators first name.');
        $user->last_name = $ci ? $this->option('last-name') ? $this->ask('Please enter the administrators last name.');
        $password = $ci ? $this->option('password') ? $this->secret('Please enter the administrators password.');
        $confirmed = $ci ? $this->option('password') ? $this->secret('Please retype the password.');

        while ($confirmed !== $password) {
            $confirmed = $this->secret('Passwords do not match, please retype the password.');
        }

        $user->password = $password;
        $user->email_verified_at = now();

        if (!$ci && !$this->confirm('Please confirm to install')) return;

        $this->call('migrate');
        //$this->call('optimize');

        $this->info('Creating master application.');
        $app->save();
        $app->domains()->save($appDomain);

        $this->info('Creating admin user.');

        $superAdmin = Role::where('name', 'superAdmin')->first();
        $user->save();
        $user->roles()->attach($superAdmin);
        $user->push();

        $this->info('Install completed.');
    }
}
