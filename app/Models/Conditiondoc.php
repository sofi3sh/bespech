<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conditiondoc extends Model
{
    use HasFactory;
    
     protected $table = 'vacancies_condition_types_doc';
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
                    "name",
                ]; 
}
