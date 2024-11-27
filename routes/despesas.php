<?php
require_once '../app/controllers/DespesaController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$controller = new DespesaController();

if ($method === 'GET' && $uri === '/appGestaoFinanceira/public/despesas') {
    $controller->listarDespesas();
} elseif ($method === 'POST' && $uri === '/appGestaoFinanceira/public/despesas') {
    $controller->criarDespesa();
} elseif ($method === 'PUT' && preg_match('/\/appGestaoFinanceira\/public\/despesas\/(\d+)/', $uri, $matches)) {
    $controller->atualizarDespesa($matches[1]);
} elseif ($method === 'DELETE' && preg_match('/\/appGestaoFinanceira\/public\/despesas\/(\d+)/', $uri, $matches)) {
    $controller->deletarDespesa($matches[1]);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Rota não encontrada."]);
}
?>
