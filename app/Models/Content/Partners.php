<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    use HasFactory;
    protected $table = 'admin_partners_module';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'images',
        'size'
    ];
}
