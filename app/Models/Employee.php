<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{
    use HasFactory;
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
                "user_id",
                "lang_id",
                "name",
                "lastName",
                "photo",
                "email",
                "phone",
                "dateOfBirth",
                "city",
                "social",
                "gender",
    ]; 
    
    public function getEmailEmployee() {
         return $this->hasMany(User::class, 'id', 'user_id');
    }
}
