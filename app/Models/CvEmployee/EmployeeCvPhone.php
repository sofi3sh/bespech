<?php

namespace App\Models\CvEmployee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCvPhone extends Model
{
    use HasFactory;
    protected $table = 'employees_cv_phones';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cv_id',
        'phone',
    ];
}
