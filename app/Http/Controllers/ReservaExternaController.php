<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\Reserva;
use App\Models\Subcancha;
use App\Models\UserReserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;
use Throwable;

class ReservaExternaController extends Controller
{
    public function index()
    {
        $reservas = $this->paginateReservasByMode('proximas');

        return view('reservas_externas.index', [
            'reservas' => $reservas,
            'pageTitle' => 'Reservas externas',
            'pageSubtitle' => 'Gestiona las solicitudes vigentes de reserva que llegan desde la pagina web Edwin Sport.',
            'viewMode' => 'proximas',
        ]);
    }

    public function history()
    {
        $reservas = $this->paginateReservasByMode('historial');

        return view('reservas_externas.index', [
            'reservas' => $reservas,
            'pageTitle' => 'Historial de reservas externas',
            'pageSubtitle' => 'Consulta las solicitudes externas cuya fecha y hora ya pasaron.',
            'viewMode' => 'historial',
        ]);
    }

    public function create()
    {
        return view('reservas_externas.create', [
            'canchas' => Cancha::orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateReserva($request);

        try {
            DB::transaction(function () use ($data) {
                $userReserva = UserReserva::create($data);

                $this->upsertAgendaReserva($userReserva, $data);
            });
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->withErrors(['general' => 'No se pudo guardar la reserva externa.']);
        }

        return redirect()
            ->route('reservas_externas.index')
            ->with('success', 'Reserva externa creada correctamente.');
    }

    public function edit(UserReserva $reservas_externa)
    {
        return view('reservas_externas.edit', [
            'reserva' => $reservas_externa,
            'canchas' => Cancha::orderBy('nombre')->get(),
        ]);
    }

    public function update(Request $request, UserReserva $reservas_externa)
    {
        $data = $this->validateReserva($request, $reservas_externa);

        try {
            DB::transaction(function () use ($reservas_externa, $data) {
                $oldData = $reservas_externa->only(['cancha_id', 'fecha', 'hora']);

                $reservas_externa->update($data);

                $this->deleteAgendaReserva($oldData);
                $this->upsertAgendaReserva($reservas_externa->fresh(), $data);
            });
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->withErrors(['general' => 'No se pudo actualizar la reserva externa.']);
        }

        return redirect()
            ->route('reservas_externas.index')
            ->with('success', 'Reserva externa actualizada correctamente.');
    }

    public function destroy(UserReserva $reservas_externa)
    {
        try {
            DB::transaction(function () use ($reservas_externa) {
                $oldData = $reservas_externa->only(['cancha_id', 'fecha', 'hora']);

                $reservas_externa->delete();
                $this->deleteAgendaReserva($oldData);
            });
        } catch (Throwable $e) {
            report($e);

            return back()->withErrors(['general' => 'No se pudo eliminar la reserva externa.']);
        }

        return redirect()
            ->route('reservas_externas.index')
            ->with('success', 'Reserva externa eliminada correctamente.');
    }

    private function validateReserva(Request $request, ?UserReserva $reserva = null): array
    {
        $data = $request->validate([
            'cancha_id' => ['required', 'exists:canchas,id'],
            'numero_subcancha' => ['required', 'integer', 'min:1'],
            'nombre_cliente' => ['required', 'string', 'max:150'],
            'telefono_cliente' => ['nullable', 'string', 'max:30'],
            'fecha' => ['required', 'date'],
            'hora' => ['required', 'date_format:H:i'],
        ]);

        $cancha = Cancha::findOrFail($data['cancha_id']);

        $numeroSubcanchaRules = ['required', 'integer', 'min:1'];

        if (!empty($cancha->num_canchas)) {
            $numeroSubcanchaRules[] = 'max:'.$cancha->num_canchas;
        }

        $request->validate([
            'numero_subcancha' => $numeroSubcanchaRules,
        ]);

        $horaReserva = substr($data['hora'], 0, 5);
        $horaApertura = substr((string) $cancha->hora_apertura, 0, 5);
        $horaCierre = substr((string) $cancha->hora_cierre, 0, 5);

        if ($horaReserva < $horaApertura || $horaReserva >= $horaCierre) {
            throw ValidationException::withMessages([
                'hora' => "La hora debe estar entre {$horaApertura} y {$horaCierre}.",
            ]);
        }

        $conflict = Reserva::query()
            ->where('cancha_id', $data['cancha_id'])
            ->where('fecha', $data['fecha'])
            ->where('hora_inicio', $data['hora']);

        if ($reserva) {
            $conflict->where(function ($query) use ($reserva) {
                $query->where('cancha_id', '!=', $reserva->cancha_id)
                    ->orWhere('fecha', '!=', $reserva->fecha)
                    ->orWhere('hora_inicio', '!=', $reserva->hora);
            });
        }

        if ($conflict->exists()) {
            throw ValidationException::withMessages([
                'hora' => 'Esa fecha y hora ya esta ocupada.',
            ]);
        }

        return $data;
    }

    private function upsertAgendaReserva(UserReserva $userReserva, array $data): void
    {
        $subcancha = Subcancha::where('cancha_id', $data['cancha_id'])
            ->where('nombre', 'Cancha '.$data['numero_subcancha'])
            ->first();

        Reserva::updateOrCreate(
            [
                'cancha_id' => $data['cancha_id'],
                'fecha' => $data['fecha'],
                'hora_inicio' => $data['hora'],
            ],
            [
                'subcancha_id' => $subcancha?->id,
                'nombre_cliente' => $userReserva->nombre_cliente,
                'telefono_cliente' => $userReserva->telefono_cliente,
            ]
        );
    }

    private function deleteAgendaReserva(array $oldData): void
    {
        Reserva::query()
            ->where('cancha_id', $oldData['cancha_id'])
            ->where('fecha', $oldData['fecha'])
            ->where('hora_inicio', $oldData['hora'])
            ->delete();
    }

    private function paginateReservasByMode(string $mode): LengthAwarePaginator
    {
        $now = Carbon::now();

        $reservas = UserReserva::with('cancha')
            ->get()
            ->filter(function (UserReserva $reserva) use ($mode, $now) {
                $fechaHora = Carbon::parse("{$reserva->fecha} {$reserva->hora}");

                return $mode === 'historial'
                    ? $fechaHora->lt($now)
                    : $fechaHora->gte($now);
            })
            ->sortBy([
                [fn (UserReserva $reserva) => $reserva->fecha, $mode === 'historial' ? 'desc' : 'asc'],
                [fn (UserReserva $reserva) => $reserva->hora, $mode === 'historial' ? 'desc' : 'asc'],
            ])
            ->values();

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $items = $reservas->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $items,
            $reservas->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }
}
