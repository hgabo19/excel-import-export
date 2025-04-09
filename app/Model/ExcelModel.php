<?php

namespace App\Model;

use PDO;
use PDOException;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelModel {
    protected PDO $pdo;

    public function __construct(PDO $pdo) {;
        $this->pdo = $pdo;
    }

    /**
     * Adatkiszedés az excel / csv fájlból, majd feltöltés adatbázisba
     *
     * @param $excelFile
     * @return void
     */
    public function import($excelFile) {
        $spreadSheet = IOFactory::load($excelFile);
        $workSheet = $spreadSheet->getActiveSheet();

        $rows = $workSheet->toArray();

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