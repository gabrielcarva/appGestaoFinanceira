<?php
require_once '../app/controllers/CategoriaDespesaController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/appGestaoFinanceira/public';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

$controller = new CategoriaDespesaController();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $uri === '/categorias') {
    $controller->listarCategorias();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/categorias') {
    $controller->criarCategoria();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('/\/categorias\/(\d+)/', $uri, $matches)) {
    $controller->deletarCategoria($matches[1]);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Rota não encontrada."]);
}
?>
