<?php

namespace App\Controller;

use App\Model\ExcelModel;

class ExcelController {
    private ExcelModel $ExcelModel;

    public function __construct(ExcelModel $excelModel) {
        $this->ExcelModel = $excelModel;
    }

    public function index() {
        $this->renderDashboard();
    }

    /**
     * Adatok importálása
     * @return void
     */
    public function import(): void {
        if (isset($_FILES['excel_file'])) {
            $excelFile = $_FILES['excel_file'];
            $deleteProducts = false;
            if (isset($_REQUEST['delete']) && (int)$_REQUEST['delete'] === 1) {
                $deleteProducts = true;
            }

            if($excelFile['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = "Hiba fájlfeltöltés közben";
                $this->renderDashboard();
                exit;
            }

            $allowedTypes = ['text/csv', 'text/plain', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            $fileType = mime_content_type($excelFile['tmp_name']);

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['error'] = "Hibás fájl típus. Megfelelő formátumok: .csv, .xlsx, .xls";
                $this->renderDashboard();
                exit;
            }

            $maxSize = 2 * 1024 * 1024;

            if ($excelFile['size'] > $maxSize) {
                $_SESSION['error'] = "Túl nagy méretű fájlt adott meg. Maximum megengedett méret: 2MB";
                $this->renderDashboard();
                exit;
            }

            $this->ExcelModel->import($excelFile['tmp_name'], $deleteProducts);

            $_SESSION['success'] = 'Sikeres importálás!';

            header('Location: /excel_import_export_project/public');
            exit;
        }
    }

    /**
     * Adatok exportálása
     * @return void
     */
    public function export(): void
    {
        $this->ExcelModel->export();
    }

    /**
     * Betöltjük a dashboard view-t
     * @return void
     */
    private function renderDashboard(): void
    {
        $data['products'] = $this->ExcelModel->getProducts();
        $data['importUrl'] = dirname($_SERVER['SCRIPT_NAME']) . '/import';
        $data['exportUrl'] = dirname($_SERVER['SCRIPT_NAME']) . '/export';

        $data['success'] = $_SESSION['success'] ?? null;
        $data['error'] = $_SESSION['error'] ?? null;

        unset($_SESSION['success'], $_SESSION['error']);

        extract($data);
        require_once __DIR__ . '/../View/' . 'dashboard' . '.php';
    }
}