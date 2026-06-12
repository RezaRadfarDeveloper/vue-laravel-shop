<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
    $ausStates = [
    'VIC'=>'Victoria',
    'NSW'=>'new south wales',
    'TAS'=>'Tasmania',
    'QLD'=>'Queensland',
    'WA'=>'Western Australia',
    'SA'=>'South australia',
    'NT'=>'Northern territory',
    ];

    $countries = [
        ['code'=> 'aus', 'name'=> 'Australia' , 'states'=> json_encode($ausStates)],
        ['code'=> 'usa', 'name'=> 'United States of America' , 'states'=> null],
        ['code'=> 'ger', 'name'=> 'Germany' , 'states'=> null],
        ];

        Country::insert($countries);
    }
}
