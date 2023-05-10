<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacanciesSalary extends Model
{
    use HasFactory;

    protected $table = 'vacancies_salaries';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "vac_id",
        "salary",
        "salary_txt",
        'currency_id'
    ];


}
