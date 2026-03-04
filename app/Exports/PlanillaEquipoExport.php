<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class PlanillaEquipoExport implements FromArray, WithEvents, WithTitle
{
    protected $equipo;

    public function __construct($equipo)
    {
        $this->equipo = $equipo;
    }

    public function array(): array
    {
        // La hoja se dibuja en AfterSheet para controlar celdas y estilos.
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $equipo = $this->equipo;
                $jugadores = collect($equipo->participantes ?? [])->values();

                $sheet->getParent()->getDefaultStyle()->getFont()->setName('Calibri')->setSize(10);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(28);
                $sheet->getColumnDimension('C')->setWidth(12);
                $sheet->getColumnDimension('D')->setWidth(15);
                $sheet->getColumnDimension('E')->setWidth(14);
                $sheet->getColumnDimension('F')->setWidth(8);
                $sheet->getColumnDimension('G')->setWidth(20);
                $sheet->getColumnDimension('H')->setWidth(12);

                $sheet->mergeCells('A2:H2');
                $sheet->setCellValue('A2', 'PLANILLA OFICIAL DE INSCRIPCION TORNEO');
                $sheet->mergeCells('A3:H3');
                $sheet->setCellValue('A3', 'FUTBOL SALA MASCULINO');
                $sheet->getStyle('A2:H3')->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle('A2:H3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A2:H3')->getFont()->getColor()->setARGB('FFFFFFFF');
                $sheet->getStyle('A2:H3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F4E78');

                $sheet->setCellValue('A5', 'NOMBRE EQUIPO');
                $sheet->mergeCells('B5:E5');
                $sheet->setCellValue('B5', mb_strtoupper((string) ($equipo->nombre_equipo ?? '')));
                $sheet->setCellValue('F5', 'NIT');
                $sheet->mergeCells('G5:H5');
                $sheet->setCellValue('G5', (string) ($equipo->nit ?? ''));

                $sheet->setCellValue('A6', 'DIRECCION');
                $sheet->mergeCells('B6:E6');
                $sheet->setCellValue('B6', mb_strtoupper((string) ($equipo->direccion ?? '')));
                $sheet->setCellValue('F6', 'TELEFONO');
                $sheet->mergeCells('G6:H6');
                $sheet->setCellValue('G6', (string) ($equipo->telefono_equipo ?? ''));

                $sheet->setCellValue('A7', 'E-MAIL');
                $sheet->mergeCells('B7:E7');
                $sheet->setCellValue('B7', (string) ($equipo->email_equipo ?? ''));
                $sheet->setCellValue('F7', 'VALOR');
                $sheet->mergeCells('G7:H7');
                $sheet->setCellValue('G7', '$ ' . number_format((float) ($equipo->valor_inscripcion ?? 0), 0, ',', '.'));

                $sheet->getStyle('A5:A7')->getFont()->setBold(true);
                $sheet->getStyle('F5:F7')->getFont()->setBold(true);

                $sheet->setCellValue('A9', 'N');
                $sheet->setCellValue('B9', 'NOMBRE Y APELLIDO DEL JUG.');
                $sheet->setCellValue('C9', 'N CAMISA');
                $sheet->setCellValue('D9', 'N CELULAR');
                $sheet->setCellValue('E9', 'N DOCUMENTO');
                $sheet->setCellValue('F9', 'EDAD');
                $sheet->setCellValue('G9', 'E-MAIL');
                $sheet->setCellValue('H9', 'DIVISION');
                $sheet->getStyle('A9:H9')->getFont()->setBold(true);
                $sheet->getStyle('A9:H9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                for ($i = 1; $i <= 20; $i++) {
                    $row = 9 + $i;
                    $jugador = $jugadores->get($i - 1);

                    $sheet->setCellValue("A{$row}", $i);
                    $sheet->setCellValue("B{$row}", $jugador->nombre ?? '');
                    $sheet->setCellValue("C{$row}", $jugador->numero_camisa ?? '');
                    $sheet->setCellValue("D{$row}", $jugador->telefono ?? '');
                    $sheet->setCellValue("E{$row}", '');
                    $sheet->setCellValue("F{$row}", $jugador->edad ?? '');
                    $sheet->setCellValue("G{$row}", $jugador->email ?? '');
                    $sheet->setCellValue("H{$row}", $jugador->division ?? '');

                    $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("C{$row}:H{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                $sheet->mergeCells('A31:H31');
                $sheet->setCellValue('A31', 'DATOS DEL DELEGADO DEL EQUIPO');
                $sheet->getStyle('A31:H31')->getFont()->setBold(true);
                $sheet->getStyle('A31:H31')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('A32', 'NOMBRE');
                $sheet->mergeCells('B32:C32');
                $sheet->setCellValue('B32', (string) ($equipo->nombre_dt ?? ''));
                $sheet->setCellValue('D32', 'E-MAIL');
                $sheet->mergeCells('E32:H32');
                $sheet->setCellValue('E32', (string) ($equipo->email_equipo ?? ''));

                $sheet->setCellValue('A33', 'CELULAR');
                $sheet->mergeCells('B33:C33');
                $sheet->setCellValue('B33', (string) ($equipo->telefono_equipo ?? ''));
                $sheet->mergeCells('D33:H33');

                $sheet->mergeCells('A35:H35');
                $sheet->setCellValue('A35', 'DATOS DEL ENTRENADOR (CUANDO APLIQUE)');
                $sheet->getStyle('A35:H35')->getFont()->setBold(true);
                $sheet->getStyle('A35:H35')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->setCellValue('A36', 'NOMBRE');
                $sheet->mergeCells('B36:C36');
                $sheet->setCellValue('B36', (string) ($equipo->nombre_dt ?? ''));
                $sheet->setCellValue('D36', 'E-MAIL');
                $sheet->mergeCells('E36:H36');
                $sheet->setCellValue('E36', (string) ($equipo->email_equipo ?? ''));

                $sheet->setCellValue('A37', 'CELULAR');
                $sheet->mergeCells('B37:C37');
                $sheet->setCellValue('B37', (string) ($equipo->telefono_equipo ?? ''));
                $sheet->mergeCells('D37:H37');

                $sheet->mergeCells('A39:H40');
                $sheet->setCellValue(
                    'A39',
                    'LOS PARTICIPANTES DE CADA EQUIPO NO DEBEN ESTAR INSCRITOS EN OTROS EQUIPOS. PARTICIPAN BAJO SU PROPIA RESPONSABILIDAD.'
                );
                $sheet->getStyle('A39:H40')->getAlignment()->setWrapText(true);

                $sheet->mergeCells('A43:H43');
                $sheet->setCellValue('A43', 'FIRMA ORGANIZADOR');
                $sheet->getStyle('A43:H43')->getFont()->setBold(true);
                $sheet->getStyle('A43:H43')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $thin = [
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']],
                    ],
                ];

                $mediumOutline = [
                    'borders' => [
                        'outline' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => 'FF000000']],
                    ],
                ];

                $headerFill = [
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFECECEC'],
                    ],
                ];

                $sheet->getStyle('A5:H7')->applyFromArray($thin);
                $sheet->getStyle('A9:H29')->applyFromArray($thin);
                $sheet->getStyle('A31:H33')->applyFromArray($thin);
                $sheet->getStyle('A35:H37')->applyFromArray($thin);
                $sheet->getStyle('A39:H40')->applyFromArray($thin);
                $sheet->getStyle('A43:H43')->applyFromArray($thin);

                $sheet->getStyle('A9:H9')->applyFromArray($headerFill);
                $sheet->getStyle('A31:H31')->applyFromArray($headerFill);
                $sheet->getStyle('A35:H35')->applyFromArray($headerFill);
                $sheet->getStyle('A5:H7')->applyFromArray($mediumOutline);
                $sheet->getStyle('A9:H29')->applyFromArray($mediumOutline);
                $sheet->getStyle('A31:H33')->applyFromArray($mediumOutline);
                $sheet->getStyle('A35:H37')->applyFromArray($mediumOutline);
                $sheet->getStyle('A39:H40')->applyFromArray($mediumOutline);
                $sheet->getStyle('A43:H43')->applyFromArray($mediumOutline);

                $sheet->getStyle('A1:H45')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A39:H40')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->freezePane('A10');
                $sheet->getSheetView()->setZoomScale(90);

                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setFitToPage(true);
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(1);
                $sheet->getPageMargins()->setTop(0.3);
                $sheet->getPageMargins()->setRight(0.25);
                $sheet->getPageMargins()->setLeft(0.25);
                $sheet->getPageMargins()->setBottom(0.3);
                $sheet->getPageMargins()->setHeader(0.2);
                $sheet->getPageMargins()->setFooter(0.2);
                $sheet->getHeaderFooter()->setOddFooter('&CHoja &P de &N');
                $sheet->getPageSetup()->setPrintArea('A1:H43');

                $sheet->getRowDimension(2)->setRowHeight(22);
                $sheet->getRowDimension(3)->setRowHeight(20);
                $sheet->getRowDimension(39)->setRowHeight(28);
                $sheet->getDefaultRowDimension()->setRowHeight(18);
            },
        ];
    }

    public function title(): string
    {
        return 'Planilla';
    }
}
