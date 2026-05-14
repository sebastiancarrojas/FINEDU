<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanAhorro extends Model
{
    protected $table = 'planes_ahorro';

    protected $fillable = [
        'user_id',
        'meta_nombre',
        'valor_meta',
        'ahorro_actual',
        'plazo_meses',
        'ahorro_mensual',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}