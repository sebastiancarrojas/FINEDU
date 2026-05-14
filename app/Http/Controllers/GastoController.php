<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class GastoController extends Controller
{
    public function index(Request $request)
    {
        $mes = $request->get('mes', now()->format('Y-m'));

        $gastos = Gasto::with('categoria')
            ->where('user_id', auth()->id())
            ->whereYear('fecha', substr($mes, 0, 4))
            ->whereMonth('fecha', substr($mes, 5, 2))
            ->orderBy('fecha')
            ->get();

        $resumen = $gastos->groupBy('categoria_id')->map(fn($g) => $g->sum('valor'));
        $total   = $gastos->sum('valor');
        $categorias = Categoria::all();

        return view('gastos', compact('gastos', 'resumen', 'total', 'mes', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'        => 'required|date',
            'categoria_id' => 'required|exists:categorias,id',
            'valor'        => 'required|numeric|min:0',
        ]);

        Gasto::create([
            'user_id'      => auth()->id(),
            'fecha'        => $request->fecha,
            'categoria_id' => $request->categoria_id,
            'valor'        => $request->valor,
        ]);

        return redirect()->route('gastos', ['mes' => substr($request->fecha, 0, 7)])
                         ->with('success', 'Gasto agregado correctamente.');
    }

    public function destroy(Gasto $gasto)
    {
        abort_if($gasto->user_id !== auth()->id(), 403);
        $gasto->delete();
        return back()->with('success', 'Gasto eliminado.');
    }

    public function update(Request $request, Gasto $gasto)
{
    abort_if($gasto->user_id !== auth()->id(), 403);

    $request->validate([
        'fecha'        => 'required|date',
        'categoria_id' => 'required|exists:categorias,id',
        'valor'        => 'required|numeric|min:0',
    ]);

    $gasto->update([
        'fecha'        => $request->fecha,
        'categoria_id' => $request->categoria_id,
        'valor'        => $request->valor,
    ]);

    return redirect()->route('gastos', ['mes' => substr($request->fecha, 0, 7)])
                     ->with('success', 'Gasto actualizado correctamente.');
}
}