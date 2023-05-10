<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy_dcz extends Model
{
    use HasFactory;
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
                    'id_dcz_vac',
                    'regionName',
                    'cityName',	
                    'cityid',
                    'companyName',
                    'vacName',
                    'description',
                    'workcond',
                    'workcondsm',
                    'contact',
                    'salary',
                    'salarytxt',
                    'currency',
                    'categoryNameId',
                    'categoryName',
                    'workExperience',
                    'education',
                    'vac_id',
                    'vac_url',
                    'source',
                    'language_id'
                ]; 
}
