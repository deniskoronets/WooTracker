<?php

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement("SET foreign_key_checks = 0");

    	DB::table('users')->truncate();

    	User::create([
    		'name' => 'Admin Admin',
    		'email' => 'admin@admin.com',
    		'password' => bcrypt('12345'),
		]);

		DB::table('tasks')->truncate();

        Task::create([
			'owner_id' => 1,
			'project_id' => 1,
			'name' => 'Add crud operations for tasks',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut placerat magna at pretium hendrerit. Quisque porta odio lacus. Donec feugiat urna vel justo gravida interdum. Phasellus quis vehicula nunc, id consequat magna. Morbi cursus, dolor ac luctus malesuada, mi massa porta nisl, sit amet semper lectus risus sed tortor. Sed dictum dui a sem ultricies, quis vehicula purus suscipit. Duis imperdiet pulvinar nulla non tincidunt.',
			'assigned_id' => 1,
			'status_id' => 1,
			'created_at' => '2015-11-02 04:00:00',
			'updated_at' => '2015-11-02 09:00:00',
		]);

        Task::create([
			'owner_id' => 1,
			'project_id' => 1,
			'name' => 'Add labels, statuses',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut placerat magna at pretium hendrerit. Quisque porta odio lacus. Donec feugiat urna vel justo gravida interdum. Phasellus quis vehicula nunc, id consequat magna. Morbi cursus, dolor ac luctus malesuada, mi massa porta nisl, sit amet semper lectus risus sed tortor. Sed dictum dui a sem ultricies, quis vehicula purus suscipit. Duis imperdiet pulvinar nulla non tincidunt.',
			'assigned_id' => 1,
			'status_id' => 1,
			'created_at' => '2015-11-02 04:00:00',
			'updated_at' => '2015-11-02 09:00:00',
		]);

		DB::table('projects')->truncate();

		Project::create([
			'owner_id' => 1,
			'name' => 'Sample project',
			'created_date' => \Carbon\Carbon::now(),
		]);
    }
}
