<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminWhyModuleAdvantages extends Model
{
    use HasFactory;
    protected $table = 'admin_why_module_advantages';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'id_advantages',
        'id_admin_why_module'
    ];
    public function advantage()
    {
        return $this->belongsTo(Advantages::class, 'advantages_id');
    }

}
