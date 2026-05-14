<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nombre', 'emoji', 'slug'];

    public function gastos()
    {
        return $this->hasMany(Gasto::class);
    }
}