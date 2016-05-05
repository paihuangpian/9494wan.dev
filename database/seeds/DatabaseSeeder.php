<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
        DB::table('admins')->insert([
            'name' => 'gemuadmin',
            'email' => 'admin@gemu.com',
            'password' => bcrypt('gemuadmin'),
        ]);

        DB::table('levels')->insert([
            ['name' => '士兵', 'sign' => 'level-1.gif', 'experience' => 0, 'attenuation' => 6000, 'wages' => 1800, 'commission' => 0.05, 'status' => 1],
            ['name' => '士官', 'sign' => 'level-2.gif', 'experience' => 6000, 'attenuation' => 6000, 'wages' => 1850, 'commission' => 0.05, 'status' => 1],
            ['name' => '排长', 'sign' => 'level-4.gif', 'experience' => 21000, 'attenuation' => 8000, 'wages' => 1900, 'commission' => 0.07, 'status' => 1],
            ['name' => '连长', 'sign' => 'level-6.gif', 'experience' => 71000, 'attenuation' => 10000, 'wages' => 1950, 'commission' => 0.09, 'status' => 1],
            ['name' => '营长', 'sign' => 'level-8.gif', 'experience' => 130000, 'attenuation' => 12000, 'wages' => 2000, 'commission' => 0.11, 'status' => 1],
            ['name' => '团长', 'sign' => 'level-10.gif', 'experience' => 170000, 'attenuation' => 14000, 'wages' => 2100, 'commission' => 0.13, 'status' => 1],
            ['name' => '旅长', 'sign' => 'level-12.gif', 'experience' => 210000, 'attenuation' => 16000, 'wages' => 2200, 'commission' => 0.14, 'status' => 1],
            ['name' => '师长', 'sign' => 'level-14.gif', 'experience' => 250000, 'attenuation' => 18000, 'wages' => 2300, 'commission' => 0.15, 'status' => 1],
            ['name' => '军长', 'sign' => 'level-15.gif', 'experience' => 300000, 'attenuation' => 19000, 'wages' => 3200, 'commission' => 0.18, 'status' => 1],
            ['name' => '司令', 'sign' => 'level-16.gif', 'experience' => 500000, 'attenuation' => 20000, 'wages' => 3500, 'commission' => 0.19, 'status' => 1]
        ]);
    }
}
