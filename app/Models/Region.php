<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'regions';
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        "name",
    ]; 
}
