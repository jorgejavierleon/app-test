<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456'),
            'api_token' => 'siExyCGoRW8QD1pljDU5E1FWBNeRhEv5QJPsrmj0Szq3jBtZz95G8uyVDjMI'
        ]);
        $this->call(SubscriberSeeder::class);
    }
}
