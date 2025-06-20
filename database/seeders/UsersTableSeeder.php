<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id'              => 1,
                'name'            => 'Admin',
                'campus_id'       =>1,
                'email'           => 'admin@admin.com',
                'password'        => bcrypt('password'),
                'mobile'          =>'785987184',
            ],
            [
                'id'              => 2,
                'name'            => 'fm manager',
                'campus_id'       =>1,
                'email'           => 'fm.manager@gmail.com',
                'password'        => bcrypt('password'),
                'mobile'          =>'785987186',
            ],
        ];

        User::insert($users);
    }
}
