<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'id' => 1,
            'type' => 1,
            'name' => 'Pangasinan',
            'email' => 'pangasinan@gmail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$8JGyJKYh3FjhhuU1qilJY.LTuRofgB1CFgOsSOX5GnDcG1C7vousW',
            'territory' => 1,
            'addr_barangay_id' => 1,
            'addr_municipality_id' => 1,
            'addr_province_id' => 1,
            'addr_region_id' => 1
            
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'type' => 2,
            'name' => 'Mapandan',
            'email' => 'mapandan@gmail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$8JGyJKYh3FjhhuU1qilJY.LTuRofgB1CFgOsSOX5GnDcG1C7vousW',
            'territory' => 1,
            'addr_barangay_id' => 1,
            'addr_municipality_id' => 1,
            'addr_province_id' => 1,
            'addr_region_id' => 1
            
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'type' => 3,
            'name' => 'Nilombot',
            'email' => 'nilombot@gmail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$8JGyJKYh3FjhhuU1qilJY.LTuRofgB1CFgOsSOX5GnDcG1C7vousW',
            'territory' => 1,
            'addr_barangay_id' => 1,
            'addr_municipality_id' => 1,
            'addr_province_id' => 1,
            'addr_region_id' => 1
            
        ]);

        DB::table('users')->insert([
            'id' => 6,
            'type' => 4,
            'name' => 'Gerone Tolentino',
            'email' => 'gerone@gmail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$8JGyJKYh3FjhhuU1qilJY.LTuRofgB1CFgOsSOX5GnDcG1C7vousW',
            'territory' => 1,
            'addr_barangay_id' => 1,
            'addr_municipality_id' => 1,
            'addr_province_id' => 1,
            'addr_region_id' => 1
            
        ]);

        DB::table('users')->insert([
            'id' => 7,
            'type' => 5,
            'name' => 'Mapandan Community Hospital',
            'email' => 'hospital@gmail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$8JGyJKYh3FjhhuU1qilJY.LTuRofgB1CFgOsSOX5GnDcG1C7vousW',
            'territory' => 1,
            'addr_barangay_id' => 1,
            'addr_municipality_id' => 1,
            'addr_province_id' => 1,
            'addr_region_id' => 1
            
        ]);

        DB::table('users')->insert([
            'id' => 8,
            'type' => 6,
            'name' => '7-11 Mapandan',
            'email' => '7eleven@gmail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$8JGyJKYh3FjhhuU1qilJY.LTuRofgB1CFgOsSOX5GnDcG1C7vousW',
            'territory' => 1,
            'addr_barangay_id' => 1,
            'addr_municipality_id' => 1,
            'addr_province_id' => 1,
            'addr_region_id' => 1
            
        ]);
        DB::table('users')->insert([
            'id' => 21,
            'type' => 6,
            'name' => 'TMDC IT Solutions',
            'email' => 'tmdc@gmail.com',
            'email_verified_at' => NULL,
            'password' => '$2y$10$8JGyJKYh3FjhhuU1qilJY.LTuRofgB1CFgOsSOX5GnDcG1C7vousW',
            'territory' => 1,
            'addr_barangay_id' => 1,
            'addr_municipality_id' => 1,
            'addr_province_id' => 1,
            'addr_region_id' => 1
            
        ]);

    }
}
