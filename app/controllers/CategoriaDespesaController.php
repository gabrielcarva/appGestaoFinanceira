<?php
require_once '../app/config/Database.php';
require_once '../app/models/CategoriaDespesa.php';

class CategoriaDespesaController
{
    public function listarCategorias()
    {
        header("Content-Type: application/json");
        $database = new Database();
        $db = $database->connect();
        $categoria = new CategoriaDespesa($db);
        echo json_encode($categoria->buscarTodos());
    }

    public function criarCategoria()
    {
        header("Content-Type: application/json");

        $database = new Database();
        $db = $database->connect();

        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->nome) || empty(trim($data->nome))) {
            http_response_code(400);
            echo json_encode(["message" => "O campo 'nome' é obrigatório."]);
            return;
        }

        $categoria = new CategoriaDespesa($db);
        $categoria->nome = trim($data->nome);

        if ($categoria->criar()) {
            echo json_encode(["message" => "Categoria criada com sucesso!"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erro ao criar categoria."]);
        }
    }

    public function deletarCategoria($id)
    {
        header("Content-Type: application/json");
        $database = new Database();
        $db = $database->connect();

        $categoria = new CategoriaDespesa($db);
        $categoria->id = $id;

        if ($categoria->deletar()) {
            echo json_encode(["message" => "Categoria deletada com sucesso!"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erro ao deletar categoria."]);
        }
    }
}
?>
