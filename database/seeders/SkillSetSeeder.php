<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PhpParser\Node\Stmt\For_;

class SkillSetSeeder extends Seeder
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

            $totalSkill = rand(1, 4);

            while ($totalSkill > 0) {
                array_push($data, [
                    'candidate_id' => $i,
                    'skill_id' => $totalSkill,
                ]);

                $totalSkill--;
            }
        }

        \DB::table("skill_sets")->insert($data);
    }
}
