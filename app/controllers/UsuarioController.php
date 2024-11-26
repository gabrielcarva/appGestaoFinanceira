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

    public function autenticarUsuario() {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
        session_start(); // Inicia a sessão
    
        $database = new Database();
        $db = $database->connect();
    
        $usuario = new Usuario($db);
        $data = json_decode(file_get_contents("php://input"));
    
        if (!empty($data->email) && !empty($data->senha)) {
            $result = $usuario->autenticar($data->email, $data->senha);
    
            if ($result) {
                // Salva os dados do usuário na sessão
                $_SESSION['usuario_id'] = $result['id'];
                $_SESSION['usuario_nome'] = $result['nome'];
    
                echo json_encode([
                    "message" => "Login realizado com sucesso!",
                    "usuario" => $result
                ]);
            } else {
                http_response_code(401);
                echo json_encode(["message" => "E-mail ou senha inválidos."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
    

}
?>
