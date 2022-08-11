<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    public function candidate()
    {
        return $this->belongsToMany(Candidate::class, "skill_sets");
    }
}
