<?php

namespace App\Models\HomeWork;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studentdz extends Model
{
    use HasFactory;
    
     protected $table = 'student_dzs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'subject_id',
        'description',
        'file_id',
        'overflou',
    ];
    


}
