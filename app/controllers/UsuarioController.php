<?php
require_once '../app/models/Usuario.php';
require_once '../app/config/Database.php';

class UsuarioController {
    public function cadastrarUsuario() {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $database = new Database();
        $db = $database->connect();

        $usuario = new Usuario($db);
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->nome) && !empty($data->email) && !empty($data->senha)) {
            $usuario->nome = $data->nome;
            $usuario->email = $data->email;
            $usuario->senha = $data->senha;

            if ($usuario->criar()) {
                http_response_code(201);
                echo json_encode(["message" => "Usuário cadastrado com sucesso!"]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao cadastrar o usuário."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}
?>
