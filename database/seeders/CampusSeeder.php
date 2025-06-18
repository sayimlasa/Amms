<?php

namespace Database\Seeders;

use App\Models\Campus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CampusSeeder extends Seeder
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
                'code'            =>'A10',
                'country_id'      => 1,
                'region_state_id'   => 1,
                'district_id'   => 1,
                'name'            =>'Arusha Main Campus',
            ]    
        ];
            Campus::insert($country);
    }
}
