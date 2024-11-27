<?php
class CategoriaDespesa
{
    private $conn;
    private $table = "Categorias_Despesas";

    public $id;
    public $nome;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function criar()
    {
        $query = "INSERT INTO " . $this->table . " (nome) VALUES (:nome)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $this->nome);
        return $stmt->execute();
    }

    public function deletar()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function buscarTodos()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
