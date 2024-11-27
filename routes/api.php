<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Redireciona as rotas para os controladores corretos
if (strpos($uri, '/usuarios') !== false) {
    require_once 'usuarios.php';
} elseif (strpos($uri, '/categorias') !== false) {
    require_once 'categorias.php';
} elseif (strpos($uri, '/despesas') !== false) {
    require_once 'despesas.php';
} else {
    http_response_code(404);
    echo json_encode(["message" => "Rota não encontrada."]);
}

