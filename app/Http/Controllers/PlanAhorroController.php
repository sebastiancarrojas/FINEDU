<?php
 
namespace App\Http\Controllers;
 
use App\Models\PlanAhorro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class PlanAhorroController extends Controller
{
    public function index()
    {
        $planes = PlanAhorro::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();
 
        return view('ahorro', compact('planes'));
    }
 
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
 
        PlanAhorro::create([
            'user_id'        => Auth::id(),
            'meta_nombre'    => $request->meta_nombre,
            'valor_meta'     => $request->valor_meta,
            'ahorro_actual'  => $request->ahorro_actual,
            'plazo_meses'    => $request->plazo_meses,
            'ahorro_mensual' => $ahorroMensual,
        ]);
 
        return redirect()->route('ahorro')->with('exito', '¡Plan guardado correctamente!');
    }
 
    public function update(Request $request, $id)
    {
        $plan = PlanAhorro::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();
 
        $request->validate([
            'ahorro_actual' => 'required|numeric|min:0',
        ]);
 
        $falta         = $plan->valor_meta - $request->ahorro_actual;
        $ahorroMensual = $falta > 0 ? $falta / $plan->plazo_meses : 0;
 
        $plan->update([
            'ahorro_actual'  => $request->ahorro_actual,
            'ahorro_mensual' => $ahorroMensual,
        ]);
 
        return redirect()->route('ahorro')->with('exito', '¡Plan actualizado correctamente!');
    }
 
    public function destroy($id)
    {
        $plan = PlanAhorro::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();
        $plan->delete();
 
        return redirect()->route('ahorro')->with('exito', 'Plan eliminado.');
    }
}