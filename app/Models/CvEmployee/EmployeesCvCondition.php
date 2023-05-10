<?php

namespace App\Models\CvEmployee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeesCvCondition extends Model
{
    use HasFactory;
    protected $table = 'employees_cv_conditions';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cv_id',
        'condition_id',
    ];
}
