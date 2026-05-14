<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Alimentación',    'emoji' => '🍽️', 'slug' => 'alimentacion'],
            ['nombre' => 'Transporte',      'emoji' => '🚌', 'slug' => 'transporte'],
            ['nombre' => 'Vivienda',        'emoji' => '🏠', 'slug' => 'vivienda'],
            ['nombre' => 'Entretenimiento', 'emoji' => '🎬', 'slug' => 'entretenimiento'],
            ['nombre' => 'Otros',           'emoji' => '📦', 'slug' => 'otros'],
        ];

        foreach ($categorias as $cat) {
            Categoria::create($cat);
        }
    }
}