<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        for ($i = 1; $i <= 20; $i++) {
            array_push($data, [
                "name" => "candidate" . $i,
                "email" => "candidate" . $i . "@gmail.com",
                "phone" => "08815475" . $i,
                "year" => "2000",
                "job_id" => rand(1, 4),
            ]);
        }

        \DB::table("candidates")->insert($data);
    }
}
