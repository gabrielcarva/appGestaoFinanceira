<?php
class Despesa
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function listar()
    {
        $query = "SELECT d.id, d.nome AS despesa_nome, d.valor, d.data, d.descricao, c.nome AS categoria_nome
                  FROM Despesas d
                  LEFT JOIN Categorias_Despesas c ON d.categoria_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criar($dados)
    {
        $query = "INSERT INTO Despesas (nome, valor, data, descricao, categoria_id)
                  VALUES (:nome, :valor, :data, :descricao, :categoria_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':valor', $dados['valor']);
        $stmt->bindParam(':data', $dados['data']);
        $stmt->bindParam(':descricao', $dados['descricao']);
        $stmt->bindParam(':categoria_id', $dados['categoria_id']);

        return $stmt->execute();
    }

    public function atualizar($id, $dados)
    {
        $query = "UPDATE Despesas
                  SET nome = :nome, valor = :valor, data = :data, descricao = :descricao, categoria_id = :categoria_id
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':valor', $dados['valor']);
        $stmt->bindParam(':data', $dados['data']);
        $stmt->bindParam(':descricao', $dados['descricao']);
        $stmt->bindParam(':categoria_id', $dados['categoria_id']);

        return $stmt->execute();
    }

    public function deletar($id)
    {
        $query = "DELETE FROM Despesas WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
