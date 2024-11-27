<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias de Despesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/appGestaoFinanceira/assets/css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Categorias de Despesas</h1>
        <div class="card shadow">
            <div class="card-body">
                <form id="categoriaForm">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome da Categoria</label>
                        <input type="text" id="nome" class="form-control" placeholder="Digite o nome da categoria" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>A��es</th>
                </tr>
            </thead>
            <tbody id="categoriasTabela">
                <!-- Categorias ser�o carregadas dinamicamente -->
            </tbody>
        </table>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        // Fun��o para carregar as categorias e exibi-las na tabela
        async function carregarCategorias() {
            try {
                const response = await fetch('/appGestaoFinanceira/public/categorias');
                if (!response.ok) throw new Error("Erro ao carregar categorias");

                const categorias = await response.json();
                const tabela = document.getElementById('categoriasTabela');
                tabela.innerHTML = '';

                categorias.forEach(categoria => {
                    const row = `
                        <tr>
                            <td>${categoria.id}</td>
                            <td>${categoria.nome}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="deletarCategoria(${categoria.id})">Deletar</button>
                            </td>
                        </tr>
                    `;
                    tabela.innerHTML += row;
                });
            } catch (error) {
                console.error("Erro:", error);
            }
        }

        // Fun��o para criar uma nova categoria
        async function salvarCategoria(event) {
            event.preventDefault();

            const nome = document.getElementById('nome').value;

            if (!nome) {
                alert("O campo Nome da Categoria � obrigat�rio.");
                return;
            }

            try {
                const response = await fetch('/appGestaoFinanceira/public/categorias', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ nome })
                });

                const result = await response.json();
                if (!response.ok) throw new Error(result.message);

                alert(result.message);
                document.getElementById('categoriaForm').reset();
                carregarCategorias();
            } catch (error) {
                console.error("Erro:", error);
                alert("Erro ao criar a categoria.");
            }
        }

        // Fun��o para deletar uma categoria
        async function deletarCategoria(id) {
            if (!confirm("Tem certeza que deseja excluir esta categoria?")) return;

            try {
                const response = await fetch(`/appGestaoFinanceira/public/categorias/${id}`, {
                    method: 'DELETE'
                });

                const result = await response.json();
                if (!response.ok) throw new Error(result.message);

                alert(result.message);
                carregarCategorias();
            } catch (error) {
                console.error("Erro:", error);
                alert("Erro ao deletar a categoria.");
            }
        }

        // Inicializar a p�gina carregando as categorias
        document.getElementById('categoriaForm').addEventListener('submit', salvarCategoria);
        carregarCategorias();
    </script>
</body>
</html>
