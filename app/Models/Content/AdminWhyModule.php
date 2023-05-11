<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class AdminWhyModule extends Model
{

    use HasFactory;
    public $timestamps = false;

    protected $table = 'admin_why_module';

    protected $fillable = [
        'id',
        'title',
        'text',
        'id_advantages'
    ];

    public function advantages()
    {
        return $this->belongsToMany(Advantages::class, 'admin_why_module_advantages', 'id_admin_why_module', 'id_advantages');
    }
}
