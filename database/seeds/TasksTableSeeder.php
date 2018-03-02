<?php

use Illuminate\Database\Seeder;
use App\Task;//*1TasksTableSeeder

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Task::class, 35)->create();//*2TasksTableSeeder
    }
}
