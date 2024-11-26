<?php
require_once '../app/controllers/UsuarioController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Log para verificar a URI original
error_log("REQUEST_URI: " . $_SERVER['REQUEST_URI']);

// Ajustar o caminho base para corresponder à rota esperada
$basePath = '/appGestaoFinanceira/public';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

// Log para verificar a URI ajustada
error_log("URI Ajustado: " . $uri);

// Criar uma instância do controlador
$controller = new UsuarioController();

// Rotas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/usuarios') {
    $controller->cadastrarUsuario();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/usuarios/login') {
    $controller->autenticarUsuario();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && ($uri === '/' || $uri === '/')) {
    echo json_encode(["message" => "Bem-vindo à API de Gestão Financeira!"]);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Rota não encontrada."]);
}
?>
