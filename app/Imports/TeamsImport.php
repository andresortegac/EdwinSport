<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

class TeamsImportService
{
    public function import($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        $teams = [];

        foreach ($sheet->getRowIterator() as $row) {
            $cell = $row->getCellIterator()->current()->getValue();

            if (!empty($cell)) {
                $teams[] = trim($cell);
            }
        }

        return $teams;
    }
}
