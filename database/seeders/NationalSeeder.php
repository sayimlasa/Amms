<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NationalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country=[
        [
            'id'              => 1,
            'code'            => '+255',
            'name'            =>'Tanzania'
        ]    
        ];
        Country::insert($country);
    }
}
