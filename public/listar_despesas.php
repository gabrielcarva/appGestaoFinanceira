<?php include 'header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Lista de Despesas</h1>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Valor</th>
                <th>Data</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="despesasTable">
            <!-- As despesas serão carregadas aqui -->
        </tbody>
    </table>
</div>

<!-- Modal para Editar Despesa -->
<div class="modal fade" id="editarDespesaModal" tabindex="-1" aria-labelledby="editarDespesaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarDespesaModalLabel">Editar Despesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editarDespesaForm">
                    <input type="hidden" id="editarDespesaId">
                    <div class="mb-3">
                        <label for="editarNome" class="form-label">Nome</label>
                        <input type="text" id="editarNome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editarCategoria" class="form-label">Categoria</label>
                        <select id="editarCategoria" class="form-control" required>
                            <!-- Categorias serão carregadas dinamicamente -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editarValor" class="form-label">Valor</label>
                        <input type="number" step="0.01" id="editarValor" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editarData" class="form-label">Data</label>
                        <input type="date" id="editarData" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editarDescricao" class="form-label">Descrição</label>
                        <textarea id="editarDescricao" class="form-control"></textarea>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="salvarEdicao()">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    async function carregarDespesas() {
        try {
            const response = await fetch('/appGestaoFinanceira/public/despesas');
            if (!response.ok) {
                throw new Error(`Erro ao buscar despesas: ${response.statusText}`);
            }

            const despesas = await response.json();
            const despesasTable = document.getElementById('despesasTable');
            despesasTable.innerHTML = '';

            despesas.forEach(despesa => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${despesa.id}</td>
                    <td>${despesa.despesa_nome}</td>
                    <td>${despesa.categoria_nome || 'Sem categoria'}</td>
                    <td>R$ ${parseFloat(despesa.valor).toFixed(2)}</td>
                    <td>${despesa.data}</td>
                    <td>${despesa.descricao || 'Sem descrição'}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="abrirModalEdicao(${despesa.id})">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="deletarDespesa(${despesa.id})">Excluir</button>
                    </td>
                `;

                despesasTable.appendChild(row);
            });
        } catch (error) {
            console.error('Erro ao carregar despesas:', error);
            alert('Erro ao carregar despesas. Tente novamente mais tarde.');
        }
    }

    async function carregarCategoriasParaEdicao() {
        try {
            const response = await fetch('/appGestaoFinanceira/public/categorias');
            const categorias = await response.json();

            const categoriaSelect = document.getElementById('editarCategoria');
            categoriaSelect.innerHTML = '';

            categorias.forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria.id;
                option.textContent = categoria.nome;
                categoriaSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Erro ao carregar categorias:', error);
        }
    }

    function abrirModalEdicao(id) {
        carregarCategoriasParaEdicao();

        fetch(`/appGestaoFinanceira/public/despesas/${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar despesa.');
                }
                return response.json();
            })
            .then(despesa => {
                document.getElementById('editarDespesaId').value = despesa.id;
                document.getElementById('editarNome').value = despesa.despesa_nome;
                document.getElementById('editarCategoria').value = despesa.categoria_id;
                document.getElementById('editarValor').value = parseFloat(despesa.valor).toFixed(2);
                document.getElementById('editarData').value = despesa.data;
                document.getElementById('editarDescricao').value = despesa.descricao || '';
                new bootstrap.Modal(document.getElementById('editarDespesaModal')).show();
            })
            .catch(error => {
                console.error('Erro ao carregar despesa:', error);
                alert('Erro ao carregar dados da despesa. Tente novamente.');
            });
    }

    async function salvarEdicao() {
        const id = document.getElementById('editarDespesaId').value;
        const nome = document.getElementById('editarNome').value;
        const categoria_id = document.getElementById('editarCategoria').value;
        const valor = document.getElementById('editarValor').value;
        const data = document.getElementById('editarData').value;
        const descricao = document.getElementById('editarDescricao').value;

        try {
            const response = await fetch(`/appGestaoFinanceira/public/despesas/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nome, categoria_id, valor, data, descricao })
            });

            if (response.ok) {
                alert('Despesa atualizada com sucesso!');
                carregarDespesas();
                const modal = bootstrap.Modal.getInstance(document.getElementById('editarDespesaModal'));
                modal.hide();
            } else {
                alert('Erro ao atualizar despesa.');
            }
        } catch (error) {
            console.error('Erro ao salvar edição:', error);
        }
    }

    async function deletarDespesa(id) {
        if (!confirm('Tem certeza que deseja excluir esta despesa?')) return;

        try {
            const response = await fetch(`/appGestaoFinanceira/public/despesas/${id}`, {
                method: 'DELETE'
            });

            if (response.ok) {
                alert('Despesa excluída com sucesso!');
                carregarDespesas();
            } else {
                alert('Erro ao excluir despesa.');
            }
        } catch (error) {
            console.error('Erro ao excluir despesa:', error);
        }
    }

    carregarDespesas();
</script>

<?php include 'footer.php'; ?>
