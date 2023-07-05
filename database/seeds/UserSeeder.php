<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user = User::create([
            'name' => "Admin",
            'email' => "admin@admin.com",
            'password' => Hash::make('admin'),
            'level' => '1'
        ]);
        $user = User::create([
            'name' => "Kepala Sekolah",
            'email' => "kepsek@gmail.com",
            'password' => Hash::make('kepsek'),
            'level' => '2'
        ]);
        $user = User::create([
            'name' => "Petugas",
            'email' => "bendahara@gmail.com",
            'password' => Hash::make('bendahara'),
            'level' => '3'
        ]);
    }
}
