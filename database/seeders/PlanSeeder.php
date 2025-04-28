<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'title' => 'Monthly',
            'slug' => 'monthly',
            'stripe_id' => 'price_1RHieDQNXJBHAHaGNUR8uCH7'
        ]);

        Plan::create([
            'title' => 'Yearly',
            'slug' => 'yearly',
            'stripe_id' => 'price_1RHieDQNXJBHAHaG5LwwCHuM'
        ]);
    }
}
