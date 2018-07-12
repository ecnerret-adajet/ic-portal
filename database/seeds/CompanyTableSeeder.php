<?php

use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            [
                'name' => 'Wizard',
                'address' => 'Tondo Manila'
            ],
            [
                'name' => 'MMA',
                'address' => 'Tondo Manila'
                
            ],
            [
                'name' => 'ACG',
                'address' => 'Tondo Manila'
            ]
        ]);
    }
}
