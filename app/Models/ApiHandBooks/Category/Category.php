<?php

namespace App\Models\ApiHandBooks\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    public $timestamps = false;
    protected $fillable = [
        'description'
    ];
    public function categoryDescriptions(){
        return $this->hasMany(CategoryDescription::class, 'categoryId');
    }

    public function getCategoriesByLangId($langId){
        return CategoryDescription::where('langId', $langId)->get();
//        return CategoryDescription::all();
    }
}
