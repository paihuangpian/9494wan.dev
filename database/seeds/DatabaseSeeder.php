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
    }
}
