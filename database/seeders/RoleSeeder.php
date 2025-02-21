<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        Role::create(['name' => 'Faculty']);
        Role::create(['name' => 'Faculty with designation']);
        Role::create(['name' => 'Admin employee']);
        Role::create(['name' => 'Admin with teaching load']);
        Role::create(['name' => 'Chairperson']);
        Role::create(['name' => 'Director/Dean']);
        Role::create(['name' => 'VP/Sector Head']); //7
        Role::create(['name' => 'IPQMSO']);
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Researcher']);
        Role::create(['name' => 'Extensionist']); //11
    }
}
