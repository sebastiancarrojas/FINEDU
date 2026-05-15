<?php

namespace App\Http\Controllers;

use App\Models\PlanAhorro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

    /*
     * - SESSION: Lee 'total_acciones' para mostrar cuántas acciones ha hecho el usuario en esta sesión
     * - COOKIE:  Lee 'ultimo_plan' para mostrar el último plan con el que interactuó el usuario
     */

class PlanAhorroController extends Controller
{
    /*
     * READ - Listar todos los planes de ahorro del usuario autenticado
     */
    public function index(Request $request)
    {
        $planes = PlanAhorro::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        $totalAcciones = session('total_acciones', 0);

        $ultimoPlan = $request->cookie('ultimo_plan');

        return view('ahorro', compact('planes', 'totalAcciones', 'ultimoPlan'));
    }

    /*
     * CREATE - Guardar un nuevo plan de ahorro en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'meta_nombre'   => 'required|string|max:100',
            'valor_meta'    => 'required|numeric|min:1',
            'ahorro_actual' => 'required|numeric|min:0',
            'plazo_meses'   => 'required|integer|min:1',
        ]);

        $falta         = $request->valor_meta - $request->ahorro_actual;
        $ahorroMensual = $falta > 0 ? $falta / $request->plazo_meses : 0;

        $plan = PlanAhorro::create([
            'user_id'        => Auth::id(),
            'meta_nombre'    => $request->meta_nombre,
            'valor_meta'     => $request->valor_meta,
            'ahorro_actual'  => $request->ahorro_actual,
            'plazo_meses'    => $request->plazo_meses,
            'ahorro_mensual' => $ahorroMensual,
        ]);

        // SESSION: incrementar el contador de acciones
        session(['total_acciones' => session('total_acciones', 0) + 1]);

        // COOKIE: guardar el nombre del último plan creado (dura 7 días)
        $cookie = cookie('ultimo_plan', $plan->meta_nombre, 60 * 24 * 7);

        return redirect()->route('ahorro')
            ->with('exito', '¡Plan guardado correctamente!')
            ->withCookie($cookie);
    }

    /*
     * UPDATE - Actualizar los datos de un plan de ahorro existente
     */
    public function update(Request $request, $id)
    {
        $plan = PlanAhorro::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();

        $request->validate([
            'meta_nombre'   => 'required|string|max:100',
            'valor_meta'    => 'required|numeric|min:1',
            'ahorro_actual' => 'required|numeric|min:0',
            'plazo_meses'   => 'required|integer|min:1',
        ]);

        $falta         = max(0, $request->valor_meta - $request->ahorro_actual);
        $ahorroMensual = $falta > 0 ? $falta / $request->plazo_meses : 0;

        $plan->update([
            'meta_nombre'    => $request->meta_nombre,
            'valor_meta'     => $request->valor_meta,
            'ahorro_actual'  => $request->ahorro_actual,
            'plazo_meses'    => $request->plazo_meses,
            'ahorro_mensual' => $ahorroMensual,
        ]);

        session(['total_acciones' => session('total_acciones', 0) + 1]);

        $cookie = cookie('ultimo_plan', $plan->meta_nombre, 60 * 24 * 7);

        return redirect()->route('ahorro')
            ->with('exito', '¡Plan actualizado correctamente!')
            ->withCookie($cookie);
    }

    /*
     * DELETE - Eliminar un plan de ahorro de la base de datos
     */
    public function destroy($id)
    {
        $plan = PlanAhorro::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();

        // Guardar el nombre ANTES de eliminar para usarlo en la cookie
        $nombrePlan = $plan->meta_nombre;
        $plan->delete();

        session(['total_acciones' => session('total_acciones', 0) + 1]);

        $cookie = cookie('ultimo_plan', $nombrePlan, 60 * 24 * 7);

        return redirect()->route('ahorro')
            ->with('exito', 'Plan eliminado.')
            ->withCookie($cookie);
    }

    /*
     * UPDATE PARCIAL - Registrar un abono (depósito) al ahorro actual del plan
     */
    public function abonar(Request $request, $id)
    {
        $plan = PlanAhorro::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();

        $request->validate([
            'monto' => 'required|numeric|min:1',
        ]);

        $nuevoAhorro   = $plan->ahorro_actual + $request->monto;
        $falta         = max(0, $plan->valor_meta - $nuevoAhorro);
        $ahorroMensual = $falta > 0 ? $falta / $plan->plazo_meses : 0;

        $plan->update([
            'ahorro_actual'  => $nuevoAhorro,
            'ahorro_mensual' => $ahorroMensual,
        ]);

        session(['total_acciones' => session('total_acciones', 0) + 1]);

        $cookie = cookie('ultimo_plan', $plan->meta_nombre, 60 * 24 * 7);

        return redirect()->route('ahorro')
            ->with('exito', '¡Abono registrado correctamente!')
            ->withCookie($cookie);
    }

    /*
     * UPDATE PARCIAL - Registrar un retiro (descuento) del ahorro actual del plan
     */
    public function retirar(Request $request, $id)
    {
        $plan = PlanAhorro::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();

        $request->validate([
            'monto' => 'required|numeric|min:1',
        ]);

        $nuevoAhorro   = max(0, $plan->ahorro_actual - $request->monto);
        $falta         = max(0, $plan->valor_meta - $nuevoAhorro);
        $ahorroMensual = $falta > 0 ? $falta / $plan->plazo_meses : 0;

        $plan->update([
            'ahorro_actual'  => $nuevoAhorro,
            'ahorro_mensual' => $ahorroMensual,
        ]);

        session(['total_acciones' => session('total_acciones', 0) + 1]);

        $cookie = cookie('ultimo_plan', $plan->meta_nombre, 60 * 24 * 7);

        return redirect()->route('ahorro')
            ->with('exito', 'Retiro registrado correctamente.')
            ->withCookie($cookie);
    }
}