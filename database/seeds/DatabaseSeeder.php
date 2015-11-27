<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

include 'InitialSeeder.php';

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('InitialSeeder');
        $this->command->info('Initial seeder success!');

        Model::reguard();
    }
}
