<?php
error_log("URI: " . $uri);

require_once '../app/controllers/UsuarioController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Ajustar o caminho base para corresponder à rota esperada
$basePath = '/appGestaoFinanceira/public';
$uri = str_replace($basePath, '', $uri);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/usuarios') {
    $controller = new UsuarioController();
    $controller->cadastrarUsuario();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && ($uri === '/' || $uri === '/')) {
    echo json_encode(["message" => "Bem-vindo à API de Gestão Financeira!"]);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Rota não encontrada."]);
}
?>
