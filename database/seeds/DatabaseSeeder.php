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
            ['name' => '士兵', 'sign' => 'level-1.gif', 'status' => 1],
            ['name' => '士官', 'sign' => 'level-2.gif', 'status' => 1],
            ['name' => '副排长', 'sign' => 'level-3.gif', 'status' => 1],
            ['name' => '排长', 'sign' => 'level-4.gif', 'status' => 1],
            ['name' => '副连长', 'sign' => 'level-5.gif', 'status' => 1],
            ['name' => '连长', 'sign' => 'level-6.gif', 'status' => 1],
            ['name' => '副营长', 'sign' => 'level-7.gif', 'status' => 1],
            ['name' => '营长', 'sign' => 'level-8.gif', 'status' => 1],
            ['name' => '副团长', 'sign' => 'level-9.gif', 'status' => 1],
            ['name' => '团长', 'sign' => 'level-10.gif', 'status' => 1],
            ['name' => '副旅长', 'sign' => 'level-11.gif', 'status' => 1],
            ['name' => '旅长', 'sign' => 'level-12.gif', 'status' => 1],
            ['name' => '副师长', 'sign' => 'level-12.gif', 'status' => 1],
            ['name' => '师长', 'sign' => 'level-14.gif', 'status' => 1],
            ['name' => '军长', 'sign' => 'level-15.gif', 'status' => 1],
            ['name' => '司令', 'sign' => 'level-16.gif', 'status' => 1]
        ]);
    }
}
