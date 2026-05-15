<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use App\Models\Categoria;
use Illuminate\Http\Request;

/*
 * SESSION usada: recuerda el último mes que el usuario consultó, para que al volver a la página no empiece siempre en el mes actual.
 * COOKIE: recuerda la última categoría seleccionada para pre-seleccionarla en el formulario la próxima vez (dura 30 días).
 */
class GastoController extends Controller
{
    /*
     * READ - Listar gastos del usuario autenticado filtrados por mes.
     */
    public function index(Request $request)
    {
        // SESSION: si no viene mes en la URL, usar el último mes consultado
        $mes = $request->get('mes', session('mes_preferido', now()->format('Y-m')));

        // SESSION: guardar el mes que está consultando ahora
        session(['mes_preferido' => $mes]);

        $gastos = Gasto::with('categoria')
            ->where('user_id', auth()->id())
            ->whereYear('fecha', substr($mes, 0, 4))
            ->whereMonth('fecha', substr($mes, 5, 2))
            ->orderBy('fecha')
            ->get();

        $resumen    = $gastos->groupBy('categoria_id')->map(fn($g) => $g->sum('valor'));
        $total      = $gastos->sum('valor');
        $categorias = Categoria::all();

        // COOKIE: leer la última categoría usada para pre-seleccionarla
        $categoriaFavorita = $request->cookie('categoria_favorita');

        return view('gastos', compact(
            'gastos', 'resumen', 'total', 'mes', 'categorias', 'categoriaFavorita'
        ));
    }

    /*
     * CREATE - Registrar un nuevo gasto en la base de datos.
     */
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

        // COOKIE: recordar la categoría usada por 30 días
        $cookie = cookie('categoria_favorita', $request->categoria_id, 60 * 24 * 30);

        return redirect()
            ->route('gastos', ['mes' => substr($request->fecha, 0, 7)])
            ->with('success', 'Gasto agregado correctamente.')
            ->withCookie($cookie);
    }

    /*
     * UPDATE - Modificar un gasto existente del usuario
     */
    public function update(Request $request, Gasto $gasto)
    {
        // Seguridad: solo el dueño del gasto puede editarlo
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

        // COOKIE: actualizar la categoría favorita con la recién usada (30 días)
        $cookie = cookie('categoria_favorita', $request->categoria_id, 60 * 24 * 30);

        return redirect()
            ->route('gastos', ['mes' => substr($request->fecha, 0, 7)])
            ->with('success', 'Gasto actualizado correctamente.')
            ->withCookie($cookie);
    }

    /*
     * DELETE - Eliminar un gasto de la base de datos
     */
    public function destroy(Gasto $gasto)
    {
        // Seguridad: solo el dueño del gasto puede eliminarlo
        abort_if($gasto->user_id !== auth()->id(), 403);

        $gasto->delete();

        return back()->with('success', 'Gasto eliminado.');
    }
}