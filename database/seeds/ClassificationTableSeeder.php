<?php

use Illuminate\Database\Seeder;

class ClassificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classifications')->insert([
            [
                'name' => 'Regular'
            ],
            [
                'name' => 'Probationary'
            ],
            [
                'name' => 'Resigned'
            ]
        ]);
    }
}
