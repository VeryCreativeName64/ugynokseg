<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{

    $this->call([

        AgencySeeder::class,
        EventSeeder::class,
        ParticipateSeeder::class
    ]);
    User::create([
        'name' => 'Teszt Elek',
        'email' => 'elek@example.com',
        'password' => Hash::make('password'),
        'vip' => true,
        'permission' => 'admin'
    ]);

    User::create([
        'name' => 'Kovács János',
        'email' => 'janos@example.com',
        'password' => Hash::make('password'),
        'vip' => false,
        'permission' => 'user'
    ]);

    User::create([
        'name' => 'Nagy Anna',
        'email' => 'anna@example.com',
        'password' => Hash::make('password'),
        'vip' => true,
        'permission' => 'user'
    ]);
}


}
