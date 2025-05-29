<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disticts')->delete();

        $datas = [
            [
                'name' => 'Dhaka',
            ],
            [
                'name' => 'Faridpur',
            ],
            [
                'name' => 'Gazipur',
            ],
            [
                'name' => 'Gopalganj',
            ],
            [
                'name' => 'Kishoreganj',
            ],
            [
                'name' => 'Madaripur',
            ],
            [
                'name' => 'Manikganj',
            ],
            [
                'name' => 'Munshiganj',
            ],
            [
                'name' => 'Narayanganj',
            ],
            [
                'name' => 'Narsingdi',
            ],
            [
                'name' => 'Rajbari',
            ],
            [
                'name' => 'Shariatpur',
            ],
            [
                'name' => 'Tangail',
            ],
            [
                'name' => 'Bandarban',
            ],
            [
                'name' => 'Brahmanbaria',
            ],
            [
                'name' => 'Chandpur',
            ],
            [
                'name' => 'Chattogram',
            ],
            [
                'name' => 'Coxsbazar',
            ],
            [
                'name' => 'Cumilla',
            ],
            [
                'name' => 'Feni',
            ],
            [
                'name' => 'Khagrachhari',
            ],
            [
                'name' => 'Lakshmipur',
            ],
            [
                'name' => 'Noakhali',
            ],
            [
                'name' => 'Rangamati',
            ],
            [
                'name' => 'Habiganj',
            ],
            [
                'name' => 'Moulvibazar',
            ],
            [
                'name' => 'Sunamganj',
            ],
            [
                'name' => 'Sylhet',
            ],
            [
                'name' => 'Barguna',
            ],
            [
                'name' => 'Barishal',
            ],
            [
                'name' => 'Bhola',
            ],
            [
                'name' => 'Jhalakathi',
            ],
            [
                'name' => 'Patuakhali',
            ],
            [
                'name' => 'Pirojpur',
            ],
            [
                'name' => 'Bogura',
            ],
            [
                'name' => 'Chapainawabganj',
            ],
            [
                'name' => 'Joypurhat',
            ],
            [
                'name' => 'Naogaon',
            ],
            [
                'name' => 'Natore',
            ],
            [
                'name' => 'Pabna',
            ],
            [
                'name' => 'Rajshahi',
            ],
            [
                'name' => 'Sirajganj',
            ],
            [
                'name' => 'Jamalpur',
            ],
            [
                'name' => 'Mymensingh',
            ],
            [
                'name' => 'Netrokona',
            ],
            [
                'name' => 'Sherpur',
            ],
            [
                'name' => 'Bagerhat',
            ],
            [
                'name' => 'Chuadanga',
            ],
            [
                'name' => 'Jashore',
            ],
            [
                'name' => 'Jhenaidah',
            ],
            [
                'name' => 'Khulna',
            ],
            [
                'name' => 'Kushtia',
            ],
            [
                'name' => 'Magura',
            ],
            [
                'name' => 'Meherpur',
            ],
            [
                'name' => 'Narail',
            ],
            [
                'name' => 'Satkhira',
            ],
            [
                'name' => 'Dinajpur',
            ],
            [
                'name' => 'Gaibandha',
            ],
            [
                'name' => 'Kurigram',
            ],
            [
                'name' => 'Lalmonirhat',
            ],
            [
                'name' => 'Nilphamari',
            ],
            [
                'name' => 'Panchagarh',
            ],
            [
                'name' => 'Panchagarh',
            ],
            [
                'name' => 'Thakurgaon',
            ],

        ];
        // dd($datas);
        DB::table('disticts')->insert($datas);
    }
}
