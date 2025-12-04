<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Subcancha;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    public function serv(reserva $cancha)
    {
        return view('canchas.serv', compact('cancha'));
    }

    public function preserva(Request $request)
    {
        // Aquí guardas la reserva
    }

   
    public function store(Request $request)
    {
        $data = $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'nombre_cliente' => 'required|string',
            'telefono_cliente' => 'nullable|string',
            'subcancha_id' => 'nullable|exists:subcanchas,id',
        ]);

        /*
        |--------------------------------------------------------------------------
        | OPCIÓN 1 → Reservar una subcancha específica
        |--------------------------------------------------------------------------
        */
        if (!empty($data['subcancha_id'])) {
            try {
                DB::beginTransaction();

                $exists = Reserva::where('subcancha_id', $data['subcancha_id'])
                    ->where('fecha', $data['fecha'])
                    ->where('hora_inicio', $data['hora_inicio'])
                    ->exists();

                if ($exists) {
                    DB::rollBack();
                    return back()->withErrors(['msg' => 'La subcancha ya está ocupada en esa hora'])->withInput();
                }

                Reserva::create($data);
                DB::commit();

                return back()->with('success', 'Reservado en la subcancha seleccionada.');
            } catch (QueryException $e) {
                DB::rollBack();
                return back()->withErrors(['msg' => 'Error al reservar. Intenta de nuevo.'])->withInput();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | OPCIÓN 2 → Asignación automática (buscar la primera subcancha libre)
        |--------------------------------------------------------------------------
        */
        $subcanchas = Subcancha::where('cancha_id', $data['cancha_id'])
            ->where('activo', true)
            ->get();

        foreach ($subcanchas as $sub) {
            try {
                DB::beginTransaction();

                $ocupada = Reserva::where('subcancha_id', $sub->id)
                    ->where('fecha', $data['fecha'])
                    ->where('hora_inicio', $data['hora_inicio'])
                    ->exists();

                if ($ocupada) {
                    DB::rollBack();
                    continue;
                }

                $data['subcancha_id'] = $sub->id;

                Reserva::create($data);
                DB::commit();

                return back()->with('success', "Reservado correctamente en {$sub->nombre}");
            } catch (QueryException $e) {
                DB::rollBack();
                continue; // probar la siguiente subcancha
            }
        }

       


        /*
        |--------------------------------------------------------------------------
        | SIN SUBCANCHAS DISPONIBLES
        |--------------------------------------------------------------------------
        */
        return back()->withErrors(['msg' => 'No hay subcancha disponible en esta hora.']);
    }

     public function destroy(Reserva $reserva)
        {
            $reserva->delete();

            return back()->with('success', 'Reserva cancelada correctamente.');
        }
}
