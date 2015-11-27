<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectsList extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserHasProjects()
    {
    	$user = factory(App\User::class)->create();

        return $this->visit('/projects/')
         	        ->see('Renting');
    }
}
