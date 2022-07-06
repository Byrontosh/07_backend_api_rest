<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol_admin = Role::where('name', 'admin')->first();
        //dd($user_admin);

        // 5 usuarios que le pertenecen al rol admin
        // https://laravel.com/docs/9.x/database-testing#belongs-to-relationships
        User::factory()->for($rol_admin)->count(5)->create();


        $rol_director = Role::where('name', 'director')->first();
        // 5 usuarios que le pertenecen al rol director
        // https://laravel.com/docs/9.x/database-testing#belongs-to-relationships
        User::factory()->for($rol_director)->count(5)->create();

        $rol_guard = Role::where('name', 'guard')->first();
        // 5 usuarios que le pertenecen al rol guard
        // https://laravel.com/docs/9.x/database-testing#belongs-to-relationships
        User::factory()->for($rol_guard)->count(5)->create();

        $rol_prisoner = Role::where('name', 'prisoner')->first();
        // 5 usuarios que le pertenecen al rol prisoner
        // https://laravel.com/docs/9.x/database-testing#belongs-to-relationships
        User::factory()->for($rol_prisoner)->count(5)->create();
    }
}
