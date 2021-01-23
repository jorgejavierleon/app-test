<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscribers')->truncate();
        for ($i=0; $i < 500; $i++) {
            $subscribers = Subscriber::factory(600)->make()->toArray();
            DB::table('subscribers')->insert($subscribers);
        }
    }
}
