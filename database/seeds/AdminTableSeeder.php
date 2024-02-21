<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'email' => 'Komarf28@gmail.com',
            'niveau' => 2,
            'status' => 1,
            'password' => bcrypt('r@dy@t1999')
        ]);
        Admin::create([
            'email' => 'admin@htw.com',
            'niveau' => 2,
            'status' => 1,
            'password' => bcrypt('admin@2020')
        ]);
    }
}
