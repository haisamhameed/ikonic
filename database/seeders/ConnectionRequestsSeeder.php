<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConnectionRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConnectionRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConnectionRequest::factory()->count(100)->create();
    }
}
