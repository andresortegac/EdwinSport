<?php

namespace App\Imports;

use App\Models\Equipo;
use App\Models\Participante;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ParticipantesImport implements ToCollection
{
    private int $importados = 0;
    private int $omitidos = 0;
    private array $observaciones = [];
    private ?array $equiposNormalizados = null;

    public function collection(Collection $rows): void
    {
        $filas = $rows->map(function ($row) {
            return array_values($row->toArray());
        })->values()->all();

        if (empty($filas)) {
            return;
        }

        $equipoGlobal = $this->extraerEquipoGlobal($filas);
        $tabla = $this->detectarTablaJugadores($filas);

        if ($tabla !== null) {
            $this->importarDesdeTabla($filas, $tabla['headerIndex'], $tabla['map'], $equipoGlobal);
            return;
        }

        $this->importarPorFilasGenericas($filas, $equipoGlobal);
    }

    private function importarDesdeTabla(array $filas, int $headerIndex, array $map, ?Equipo $equipoGlobal): void
    {
        $vaciasConsecutivas = 0;

        for ($i = $headerIndex + 1; $i < count($filas); $i++) {
            $fila = $filas[$i];
            $linea = $i + 1;

            if ($this->esFilaCorte($fila)) {
                break;
            }

            $nombre = $this->valorPorColumna($fila, $map['nombre'] ?? null);
            $nombre = trim((string) $nombre);

            if ($nombre === '') {
                if ($this->isFilaVacia($fila)) {
                    $vaciasConsecutivas++;
                    if ($vaciasConsecutivas >= 4) {
                        break;
                    }
                }
                continue;
            }

            $vaciasConsecutivas = 0;

            $equipoValor = $this->valorPorColumna($fila, $map['equipo'] ?? null);
            $equipo = $this->resolverEquipoPorValor($equipoValor, $equipoGlobal);
            if (!$equipo) {
                $this->omitidos++;
                $this->observaciones[] = "Fila {$linea}: equipo no encontrado.";
                continue;
            }

            $email = trim((string) $this->valorPorColumna($fila, $map['email'] ?? null));
            if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->omitidos++;
                $this->observaciones[] = "Fila {$linea}: email invalido.";
                continue;
            }

            Participante::create([
                'equipo_id' => $equipo->id,
                'nombre' => $nombre,
                'numero_camisa' => $this->nullableText($this->valorPorColumna($fila, $map['numero_camisa'] ?? null)),
                'evento' => $this->nullableText($this->valorPorColumna($fila, $map['evento'] ?? null)) ?? $equipo->evento,
                'edad' => $this->nullableInt($this->valorPorColumna($fila, $map['edad'] ?? null)),
                'division' => $this->nullableText($this->valorPorColumna($fila, $map['division'] ?? null)),
                'email' => $email !== '' ? $email : null,
                'telefono' => $this->nullableText($this->valorPorColumna($fila, $map['telefono'] ?? null)),
            ]);

            $this->importados++;
        }
    }

    private function importarPorFilasGenericas(array $filas, ?Equipo $equipoGlobal): void
    {
        foreach ($filas as $i => $fila) {
            $linea = $i + 1;

            if ($this->isFilaVacia($fila)) {
                continue;
            }

            $nombre = trim((string) ($fila[1] ?? ''));
            if ($nombre === '' || $this->esFilaEncabezado($fila)) {
                continue;
            }

            $equipo = $this->resolverEquipoPorValor($fila[0] ?? null, $equipoGlobal);
            if (!$equipo) {
                $this->omitidos++;
                $this->observaciones[] = "Fila {$linea}: equipo no encontrado.";
                continue;
            }

            $email = trim((string) ($fila[6] ?? ''));
            if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->omitidos++;
                $this->observaciones[] = "Fila {$linea}: email invalido.";
                continue;
            }

            Participante::create([
                'equipo_id' => $equipo->id,
                'nombre' => $nombre,
                'numero_camisa' => $this->nullableText($fila[2] ?? null),
                'evento' => $this->nullableText($fila[3] ?? null) ?? $equipo->evento,
                'edad' => $this->nullableInt($fila[4] ?? null),
                'division' => $this->nullableText($fila[5] ?? null),
                'email' => $email !== '' ? $email : null,
                'telefono' => $this->nullableText($fila[7] ?? null),
            ]);

            $this->importados++;
        }

        if ($this->importados === 0) {
            $this->observaciones[] = 'No se detecto tabla de jugadores. Verifica que exista encabezado con "NOMBRE" y filas con jugadores.';
        }
    }

    private function detectarTablaJugadores(array $filas): ?array
    {
        foreach ($filas as $i => $fila) {
            $map = [];

            foreach ($fila as $col => $celda) {
                $texto = $this->normalizarTexto((string) $celda);
                if ($texto === '') {
                    continue;
                }

                if (($texto === 'n' || str_contains($texto, 'item')) && !isset($map['indice'])) {
                    $map['indice'] = $col;
                } elseif ((str_contains($texto, 'nombre') && (str_contains($texto, 'jug') || str_contains($texto, 'apellido') || $texto === 'nombre')) && !isset($map['nombre'])) {
                    $map['nombre'] = $col;
                } elseif ((str_contains($texto, 'camisa') || str_contains($texto, 'dorsal')) && !isset($map['numero_camisa'])) {
                    $map['numero_camisa'] = $col;
                } elseif ((str_contains($texto, 'celular') || str_contains($texto, 'telefono') || str_contains($texto, 'movil')) && !isset($map['telefono'])) {
                    $map['telefono'] = $col;
                } elseif ((str_contains($texto, 'mail') || str_contains($texto, 'correo')) && !isset($map['email'])) {
                    $map['email'] = $col;
                } elseif (str_contains($texto, 'edad') && !isset($map['edad'])) {
                    $map['edad'] = $col;
                } elseif ((str_contains($texto, 'division') || str_contains($texto, 'categoria')) && !isset($map['division'])) {
                    $map['division'] = $col;
                } elseif ((str_contains($texto, 'equipo') || str_contains($texto, 'club')) && !isset($map['equipo'])) {
                    $map['equipo'] = $col;
                } elseif ((str_contains($texto, 'evento') || str_contains($texto, 'torneo')) && !isset($map['evento'])) {
                    $map['evento'] = $col;
                }
            }

            if (isset($map['nombre'])) {
                return ['headerIndex' => $i, 'map' => $map];
            }
        }

        return null;
    }

    private function extraerEquipoGlobal(array $filas): ?Equipo
    {
        foreach ($filas as $fila) {
            $primer = $this->normalizarTexto((string) ($fila[0] ?? ''));
            if ($primer === '') {
                continue;
            }

            $esEtiquetaNombre = $primer === 'nom'
                || $primer === 'nom:'
                || str_starts_with($primer, 'nom ')
                || str_contains($primer, 'nombre equipo')
                || str_contains($primer, 'equipo');

            if (!$esEtiquetaNombre) {
                continue;
            }

            foreach (array_slice($fila, 1) as $valor) {
                $texto = trim((string) $valor);
                if ($texto !== '') {
                    $equipo = $this->resolverEquipoPorNombre($texto);
                    if ($equipo) {
                        return $equipo;
                    }
                }
            }
        }

        return null;
    }

    private function resolverEquipoPorValor(mixed $valor, ?Equipo $equipoGlobal = null): ?Equipo
    {
        if ($valor !== null && $valor !== '') {
            if (is_numeric($valor)) {
                $porId = Equipo::find((int) $valor);
                if ($porId) {
                    return $porId;
                }
            }

            $porNombre = $this->resolverEquipoPorNombre((string) $valor);
            if ($porNombre) {
                return $porNombre;
            }
        }

        return $equipoGlobal;
    }

    private function resolverEquipoPorNombre(string $nombreEquipo): ?Equipo
    {
        $nombreEquipo = trim($nombreEquipo);
        if ($nombreEquipo === '') {
            return null;
        }

        $equipoExacto = Equipo::whereRaw('LOWER(TRIM(nombre_equipo)) = ?', [mb_strtolower(trim($nombreEquipo))])->first();
        if ($equipoExacto) {
            return $equipoExacto;
        }

        $objetivo = $this->normalizarTexto($nombreEquipo);
        if ($objetivo === '') {
            return null;
        }

        if ($this->equiposNormalizados === null) {
            $this->equiposNormalizados = [];

            foreach (Equipo::select('id', 'nombre_equipo')->get() as $equipo) {
                $clave = $this->normalizarTexto((string) $equipo->nombre_equipo);
                if ($clave !== '' && !isset($this->equiposNormalizados[$clave])) {
                    $this->equiposNormalizados[$clave] = $equipo;
                }
            }
        }

        $equipoNormalizado = $this->equiposNormalizados[$objetivo] ?? null;
        if ($equipoNormalizado) {
            return $equipoNormalizado;
        }

        $coincidencias = [];
        foreach ($this->equiposNormalizados as $clave => $equipo) {
            if (str_contains($objetivo, $clave) || str_contains($clave, $objetivo)) {
                $coincidencias[$equipo->id] = $equipo;
            }
        }

        if (count($coincidencias) === 1) {
            return array_values($coincidencias)[0];
        }

        return null;
    }

    private function isFilaVacia(array $row): bool
    {
        foreach ($row as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }

    private function nullableText(mixed $value): ?string
    {
        $text = trim((string) $value);
        return $text === '' ? null : $text;
    }

    private function nullableInt(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        return is_numeric($value) ? (int) $value : null;
    }

    private function valorPorColumna(array $fila, ?int $indice): mixed
    {
        if ($indice === null) {
            return null;
        }

        return $fila[$indice] ?? null;
    }

    private function normalizarTexto(string $value): string
    {
        $normalizado = mb_strtolower(trim($value));
        $normalizado = preg_replace('/\s+/', ' ', $normalizado) ?? '';

        $sinAcentos = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $normalizado);
        if ($sinAcentos !== false) {
            $normalizado = $sinAcentos;
        }

        $normalizado = preg_replace('/[^a-z0-9 ]+/i', ' ', $normalizado) ?? '';
        $normalizado = preg_replace('/\s+/', ' ', $normalizado) ?? '';

        return trim($normalizado);
    }

    private function esFilaCorte(array $fila): bool
    {
        foreach ($fila as $celda) {
            $texto = $this->normalizarTexto((string) $celda);
            if (
                str_contains($texto, 'datos del delegado')
                || str_contains($texto, 'datos del entrenador')
                || str_contains($texto, 'firma organizador')
            ) {
                return true;
            }
        }

        return false;
    }

    private function esFilaEncabezado(array $fila): bool
    {
        $texto = $this->normalizarTexto(implode(' ', array_map(fn($v) => (string) $v, $fila)));
        return str_contains($texto, 'nombre')
            && (str_contains($texto, 'jug') || str_contains($texto, 'apellido'));
    }

    public function getImportados(): int
    {
        return $this->importados;
    }

    public function getOmitidos(): int
    {
        return $this->omitidos;
    }

    public function getObservaciones(): array
    {
        return $this->observaciones;
    }
}
