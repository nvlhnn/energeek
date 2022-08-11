<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, "skill_sets", "candidate_id",  "skill_id");
    }
}
