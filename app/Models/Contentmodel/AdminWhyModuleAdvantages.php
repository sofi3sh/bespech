<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminWhyModuleAdvantages extends Model
{
    use HasFactory;
    protected $table = 'admin_why_module_advantages';

    protected $fillable = [
        'id',
        'id_advantages',
        'id_admin_why_module'
    ];
}
