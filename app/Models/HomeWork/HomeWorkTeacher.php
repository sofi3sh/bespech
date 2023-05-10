<?php

namespace App\Models\HomeWork;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeWorkTeacher extends Model
{
    use HasFactory;
    
    protected $table = 'home_work_teachers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'subject_id',
        'title',
        'theme',
        'description',
    ];

}
