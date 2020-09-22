<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Account;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@localhost.tld',
            'password' => Hash::make('password'),
        ]);

        Account::factory()->create([
            'user_id' => $user->id,
        ]);
    }
}
