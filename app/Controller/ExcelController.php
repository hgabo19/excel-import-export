<?php

namespace App\Controller;

use App\Model\ExcelModel;

class ExcelController {
    private ExcelModel $ExcelModel;

    public function __construct(ExcelModel $excelModel) {
        $this->ExcelModel = $excelModel;
    }

    public function index() {
        $data['importUrl'] = $basePath = dirname($_SERVER['SCRIPT_NAME']) . '/import';
        $data['products'] = $this->ExcelModel->getProducts();

        $this->render('dashboard', $data);
    }

    public function import() {
        if (isset($_FILES['excel_file'])) {
            $excelFile = $_FILES['excel_file'];

            if($excelFile['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = "Hiba fájlfeltöltés közben";
                $this->render('dashboard');
                exit;
            }

            $fileType = strtolower(pathinfo($excelFile['name'], PATHINFO_EXTENSION));
        
            if (!in_array($fileType, ['csv', 'xlsx', 'xls'])) {
                $_SESSION['error'] = "Hibás fájl kiterjesztés. Megfelelő formátumok: .csv, .xlsx, .xls";
                $this->render('dashboard');
                exit;
            }

            $maxSize = 2 * 1024 * 1024;

            if ($excelFile['size'] > $maxSize) {
                $_SESSION['error'] = "Túl nagy méretű fájlt adott meg. Maximum megengedett méret: 2MB";
                $this->render('dashboard');
                exit;
            }

            $this->ExcelModel->import($excelFile['tmp_name']);

            $data['products'] = $this->ExcelModel->getProducts();

            $_SESSION['success'] = 'Sikeres importálás!';

            header('Location: /excel_import_export_project/public');
            exit;
        }
    }


    /**
     * Betöltjük a kért view-t
     *
     * @param string $viewName
     * @return void
     */
    private function render(string $viewName, $data = [])
    {
        $data['success'] = $_SESSION['success'] ?? null;
        $data['error'] = $_SESSION['error'] ?? null;
        unset($_SESSION['success'], $_SESSION['error']);

        extract($data);
        require_once __DIR__ . '/../View/' . $viewName . '.php';
    }
}