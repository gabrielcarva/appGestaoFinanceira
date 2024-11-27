<?php
require_once '../app/models/Despesa.php';
require_once '../app/config/Database.php';

class DespesaController
{
    private $despesa;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->despesa = new Despesa($db);
    }

    public function listarDespesas()
    {
        header("Content-Type: application/json");
        $despesas = $this->despesa->listar();
        echo json_encode($despesas);
    }

    public function criarDespesa()
    {
        header("Content-Type: application/json");

        $dados = json_decode(file_get_contents("php://input"), true);

        if (!empty($dados['nome']) && !empty($dados['valor']) && !empty($dados['data'])) {
            $dados['categoria_id'] = $dados['categoria_id'] ?? null;

            if ($this->despesa->criar($dados)) {
                http_response_code(201);
                echo json_encode(["message" => "Despesa criada com sucesso!"]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao criar despesa."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function obterDespesa($id)
    {
        header("Content-Type: application/json");

        $despesa = $this->despesa->buscarPorId($id);
        if ($despesa) {
            echo json_encode($despesa);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Despesa não encontrada."]);
        }
    }

    public function deletarDespesa($id)
    {
        header("Content-Type: application/json");

        if ($this->despesa->deletar($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Despesa excluída com sucesso!"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erro ao excluir despesa."]);
        }
    }
}
?>
