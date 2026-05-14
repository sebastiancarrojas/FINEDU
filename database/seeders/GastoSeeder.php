<?php

namespace Database\Seeders;

use App\Models\Gasto;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class GastoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@finedu.com')->first();

        $categorias = Categoria::pluck('id', 'slug');

        $gastos = [
            ['fecha' => '2026-05-01', 'categoria' => 'transporte',      'valor' => 12000],
            ['fecha' => '2026-05-01', 'categoria' => 'alimentacion',    'valor' => 35000],
            ['fecha' => '2026-05-02', 'categoria' => 'transporte',      'valor' => 12000],
            ['fecha' => '2026-05-02', 'categoria' => 'alimentacion',    'valor' => 28000],
            ['fecha' => '2026-05-03', 'categoria' => 'vivienda',        'valor' => 800000],
            ['fecha' => '2026-05-03', 'categoria' => 'transporte',      'valor' => 15000],
            ['fecha' => '2026-05-04', 'categoria' => 'entretenimiento', 'valor' => 55000],
            ['fecha' => '2026-05-04', 'categoria' => 'alimentacion',    'valor' => 42000],
            ['fecha' => '2026-05-05', 'categoria' => 'otros',           'valor' => 140000],
            ['fecha' => '2026-05-05', 'categoria' => 'entretenimiento', 'valor' => 120000],
            ['fecha' => '2026-05-10', 'categoria' => 'alimentacion',    'valor' => 65000],
            ['fecha' => '2026-05-12', 'categoria' => 'transporte',      'valor' => 18000],
            ['fecha' => '2026-05-15', 'categoria' => 'entretenimiento', 'valor' => 90000],
            ['fecha' => '2026-05-20', 'categoria' => 'alimentacion',    'valor' => 47000],
            ['fecha' => '2026-05-25', 'categoria' => 'otros',           'valor' => 75000],
        ];

        foreach ($gastos as $g) {
            Gasto::create([
                'user_id'      => $user->id,
                'fecha'        => $g['fecha'],
                'categoria_id' => $categorias[$g['categoria']],
                'valor'        => $g['valor'],
            ]);
        }
    }
}