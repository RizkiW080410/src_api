<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timstamp = \Carbon\Carbon::now()->toDateString();
        DB::table('products')->insert([
            'name' => 'sepatu',
            'qty' => 10,
            'price' => 10000,
            'created_at' => $timstamp,
            'updated_at' => $timstamp,]);
    }
}
