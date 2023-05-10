<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacanciesConditionDoc extends Model
{
    use HasFactory;
    
    
    
    protected $table = 'vacancies_condition_types_doc';
    protected $guarded = [];
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "language_id",
    ]; 
    
    public function vacancies(){
      return $this->belongsToMany(VacanciesConditionDoc::class, 'vacancies_condition_types', 'condition_id' ,'vac_id');
    }
}