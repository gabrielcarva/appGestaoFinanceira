<?php
$request = $_SERVER['REQUEST_URI'];
$file = __DIR__ . $request;

// Verifica a URL: Se a URL for a raiz (/) ou /appGestaoFinanceira/public/, ele inclui o cadastro.php.

if ($request === '/' || $request === '/appGestaoFinanceira/public/') {
    require 'cadastro.php';
} elseif (file_exists($file)) {
    return false;
} else {
    require_once '../routes/api.php';
}
?>
