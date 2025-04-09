<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\ExcelController;

$excelController = new ExcelController();
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$baseUrl = dirname($_SERVER['SCRIPT_NAME']);
$path = '/' . trim(str_replace($baseUrl, '', $uri), '/');

if ($path === '/import' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $excelController->import();
    exit;
}

$excelController->index();