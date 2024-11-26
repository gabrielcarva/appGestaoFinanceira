<?php
class Usuario {
    private $conn;
    private $table = "Usuario";

    public $id;
    public $nome;
    public $email;
    public $senha;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table . " (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->senha = password_hash($this->senha, PASSWORD_DEFAULT);

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $this->senha);

        return $stmt->execute();
    }

    public function autenticar($email, $senha) {
        $query = "SELECT id, nome, senha FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        // Limpar os dados
        $email = htmlspecialchars(strip_tags($email));

        $stmt->bindParam(':email', $email);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar a senha
            if (password_verify($senha, $usuario['senha'])) {
                return [
                    "id" => $usuario['id'],
                    "nome" => $usuario['nome']
                ];
            }
        }

        return false;
    }
    
}
?>
