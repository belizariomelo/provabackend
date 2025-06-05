<?php
// router.php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;

// Se o arquivo físico existir (como imagem, CSS, etc), deixa o PHP lidar
if (file_exists($file)) {
    return false;
}

// Senão, carrega o index.php
require __DIR__ . '/index.php';
