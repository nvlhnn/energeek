<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table("skills")->insert([
            [
                "name" => "PHP",
            ],
            [
                "name" => "PostgreSQL",
            ],
            [
                "name" => "API (JSON, REST)",
            ],
            [
                "name" => "Version Control System (Gitlab, Github)",
            ],
        ]);
    }
}
