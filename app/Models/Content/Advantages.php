<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Advantages extends Model
{
    use HasFactory;
    protected $table = 'advantages';
    public $timestamps = false;
    protected $fillable = [
        'Id',
        'name'
    ];

    public function adminWhyModules()
    {
        return $this->belongsToMany(AdminWhyModule::class, 'admin_why_module_advantages', 'id_advantages', 'id_admin_why_module');
    }

}
