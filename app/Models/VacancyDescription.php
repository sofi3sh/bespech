<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacancyDescription extends Model
{
    use HasFactory;

    protected $table = 'vacancies_descriptions';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "vac_id",
        "vac_name",
        "description",
        'language_id'
    ];
}

