<?php
require_once '../app/controllers/UsuarioController.php';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Redireciona as rotas para os controladores corretos
if (strpos($uri, '/usuarios/mudar_senha') !== false && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UsuarioController();
    $controller->mudarSenha();
} elseif (strpos($uri, '/usuarios') !== false) {
    require_once 'usuarios.php';
} elseif (strpos($uri, '/categorias') !== false) {
    require_once 'categorias.php';
} elseif (strpos($uri, '/despesas') !== false) {
    require_once 'despesas.php';
} else {
    http_response_code(404);
    echo json_encode(["message" => "Rota não encontrada."]);
}
