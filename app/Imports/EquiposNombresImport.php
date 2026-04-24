<?php

namespace App\Imports;

use App\Models\Equipo;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EquiposNombresImport
{
    private string $evento;
    public int $creados = 0;
    public int $omitidos = 0;

    public function __construct(string $evento)
    {
        $this->evento = trim($evento);
    }

    public function import(string $filePath): void
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getRowIterator() as $row) {
            $cellValue = $row->getCellIterator()->current()->getValue();
            $nombre = trim((string) ($cellValue ?? ''));

            if ($nombre === '') {
                continue;
            }

            // Permite archivos con encabezado en la primera fila.
            if (in_array(mb_strtolower($nombre), ['nombre_equipo', 'equipo', 'nombre equipo'], true)) {
                continue;
            }

            $yaExiste = Equipo::query()
                ->where('evento', $this->evento)
                ->whereRaw('LOWER(nombre_equipo) = ?', [mb_strtolower($nombre)])
                ->exists();

            if ($yaExiste) {
                $this->omitidos++;
                continue;
            }

            Equipo::create([
                'evento' => $this->evento,
                'nombre_equipo' => $nombre,
                'nit' => null,
                'direccion' => null,
                'telefono_equipo' => null,
                'email_equipo' => null,
                'valor_inscripcion' => null,
                'nombre_dt' => null,
            ]);

            $this->creados++;
        }
    }
}
