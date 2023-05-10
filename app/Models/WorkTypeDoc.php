<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkTypeDoc extends Model
{
    use HasFactory;
    
     protected $table = 'vacancies_work_types_doc';
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
                            'name',	
                            'language_id',
                           ]; 
}
