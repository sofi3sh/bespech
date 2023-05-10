<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacanciesCondition extends Model
{
    use HasFactory;

    protected $table = 'vacancies_condition_types';
    protected $guarded = [];

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vac_id',
        'condition_id',
        'language_id',
    ];
 }
