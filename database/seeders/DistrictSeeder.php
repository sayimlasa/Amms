<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
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
                'region_state_id'   => 1,
                'name'            =>'Arusha Mjini'
            ]    
            ];
            District::insert($country);
    }
}
