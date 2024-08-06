<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'cid' => 1,
                'product_name' => 'Pizza',
                'qty' => 10,
                'rate' => 299.00,
                'gst' => 5.00,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'cid' => 1,
                'product_name' => 'Burger',
                'qty' => 10,
                'rate' => 149.00,
                'gst' => 5.00,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'cid' => 2,
                'product_name' => 'Laptop',
                'qty' => 5,
                'rate' => 54999.00,
                'gst' => 18.00,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'cid' => 2,
                'product_name' => 'Keyboard',
                'qty' => 20,
                'rate' => 999.00,
                'gst' => 12.00,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'cid' => 3,
                'product_name' => 'T-Shirt',
                'qty' => 100,
                'rate' => 599.00,
                'gst' => 12.00,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'cid' => 3,
                'product_name' => 'Sleeveless T-Shirt',
                'qty' => 100,
                'rate' => 599.00,
                'gst' => 12.00,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}
