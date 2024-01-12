<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Project extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = 'projects';

    protected $fillable = [
        'name',
        'student_id',
        'description',
        'duration',
    ];

    public $timestamps = false;
}
