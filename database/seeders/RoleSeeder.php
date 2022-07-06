<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rols = ['admin','director','guard','prisoner'];

        for($i=0 ; $i<4 ; $i++)
        {
            Role::create([
                'name' => $rols[$i],
                'slug' => $rols[$i],
            ]);
        }
    }
}
