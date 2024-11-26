<?php
class Database {
    private $host = "localhost";
    private $db_name = "gestao_financas";
    private $username = "root"; // Altere para o seu usuário
    private $password = ""; // Altere para a sua senha
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Erro ao conectar ao banco: " . $e->getMessage()]);
        }
        return $this->conn;
    }
}
?>
