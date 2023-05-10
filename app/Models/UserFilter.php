<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFilter extends Model
{
    use HasFactory;
    
     protected $table = 'user_filters';
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
                    	'user_id',
                    	'id_region',
                    	'id_city',
                    	'selected_condition',
                    	'salary_min',
                    	'salary_max'	
                ]; 
}
