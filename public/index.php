<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\ExcelController;
use App\Model\ExcelModel;
use App\Core\Database;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$config = require_once __DIR__ . '/../config/config.php';

$database = new Database($config);
$pdo = $database->getConnection();

$excelModel = new ExcelModel($pdo);

$excelController = new ExcelController($excelModel);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$baseUrl = dirname($_SERVER['SCRIPT_NAME']);
$path = '/' . trim(str_replace($baseUrl, '', $uri), '/');

if ($path === '/import' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $excelController->import();
    exit;
} else if ($path === '/export' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $excelController->export();
    exit;
}

$excelController->index();