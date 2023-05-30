<?php

namespace App\Models\ApiHandBooks\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryDescription extends Model
{
    use HasFactory;
    protected $table = 'categories_descriptions';
    public $timestamps = false;

    protected $fillable = [
        'landId',
        'description',
        'categoryId'
    ];
}
