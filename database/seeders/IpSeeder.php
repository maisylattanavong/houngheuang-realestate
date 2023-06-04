<?php

namespace Database\Seeders;

use App\Models\IpCount;
use App\Models\RegionName;
use App\Models\VisitorCount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VisitorCount::create([
            'ip'=>'115.84.94.183',
            'user_agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 Edg/109.0.1518.70',
            'countryName'=>'Laos',
            'regionName'=>'Houaphan',
            'cityName'=>'Xam Nua',
        ]);
        IpCount::create([
            'ip'=>'115.84.94.183',
            'user_agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 Edg/109.0.1518.70',
            'countryName'=>'Laos',
            'countryCode'=>'LA',
            'regionCode'=>'HO',
            'regionName'=>'Houaphan',
            'cityName'=>'Xam Nua',
            'latitude'=>'20.4167',
            'longitude'=>'104.0452',
            'areaCode'=>'HO',
            'timezone'=>'Asia/Vientiane',
            'driver'=>'Stevebauman\Location\Drivers\IpApi'

        ]);
        RegionName::create([
            'countryName'=>'Laos',
            'regionName'=>'Houaphan',
            'totalVisitor'=>1
        ]);
    }
}
