<?php

namespace App\Model;

use PDO;
use PDOException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelModel {
    protected PDO $pdo;

    public function __construct(PDO $pdo) {;
        $this->pdo = $pdo;
    }

    /**
     * Adatkiszedés az excel / csv fájlból, majd feltöltés adatbázisba
     *
     * @param $excelFile
     * @param boolean $deleteProducts
     * @return void
     */
    public function import($excelFile, $deleteProducts): void {
        $spreadSheet = IOFactory::load($excelFile);
        $workSheet = $spreadSheet->getActiveSheet();

        $rows = $workSheet->toArray();

        if ($deleteProducts) {
            $deleteSql = "DELETE FROM products WHERE 1";

            $preparedStatement = $this->pdo->prepare($deleteSql);
            $preparedStatement->execute();
        }

        $sql = "INSERT INTO products (name, sku) VALUES (?, ?)";
        foreach ($rows as $index => $row) {
            if ($index === 0) continue;

            $name = $row[0];
            $sku = $row[1];

            try {
                $preparedStatement = $this->pdo->prepare($sql);
                $preparedStatement->execute([$name, $sku]);
            } catch (PDOException $e) {
                die("Importálás meghiúsult a " . $sku . " cikkszámú terméknél: " . $e->getMessage());
            }
        }
    }

    public function export() {
        $products = $this->getProducts();

        $spreadSheet = new Spreadsheet();
        $activeSheet = $spreadSheet->getActiveSheet();

        $headers = ['Azonosító (ID)', 'Név', 'Cikkszám'];
        $activeSheet->fromArray($headers, null, 'A1');

        $row = 2;
        foreach ($products as $product) {
            $activeSheet->fromArray(array_values($product), null, 'A' . $row);
            $row++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="termek_export.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadSheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Termékek lekérdezése
     *
     * @return array
     */
    public function getProducts(): array {
        $sql = "SELECT * FROM products";

        $preparedStatement = $this->pdo->prepare($sql);
        $preparedStatement->execute();
        return $products = $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
    }
}