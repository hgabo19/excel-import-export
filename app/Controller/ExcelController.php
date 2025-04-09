<?php

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController {
    public function index() {
        $importUrl = $basePath = dirname($_SERVER['SCRIPT_NAME']) . '/import';
        require_once __DIR__ . '/../View/dashboard.php';
    }

    public function import() {
        if (isset($_FILES['excel_file'])) {
            require_once __DIR__ . '/../View/dashboard.php';
        }
    }
}