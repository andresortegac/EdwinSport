<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

class TeamsImportService
{
    public function import($file)
    {
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();

        $teams = [];
        foreach ($sheet->getRowIterator() as $row) {
            $cell = $row->getCellIterator();
            $cell->setIterateOnlyExistingCells(true);
            $value = $cell->current()->getValue();

            if ($value !== null && trim($value) !== '') {
                $teams[] = trim($value);
            }
        }

        return $teams;
    }
}
