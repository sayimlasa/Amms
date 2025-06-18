<?php

namespace Database\Seeders;

use App\Models\RegionState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
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
                'country_id'      => 1,
                'name'            =>'Arusha'
            ]    
            ];
            RegionState::insert($country);
    }
}
