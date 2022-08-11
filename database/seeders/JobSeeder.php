<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table("jobs")->insert([
            [
                "name" => "Frontend Web Programmer",
            ],
            [
                "name" => "Backend Web Programmer  ",
            ],
            [
                "name" => "Fullstack Web Programmer",
            ],
            [
                "name" => "Quality Control",
            ],
        ]);
    }
}
