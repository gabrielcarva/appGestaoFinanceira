<?php include 'header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center">Registrar Despesa</h1>
    <form id="despesaForm" onsubmit="registrarDespesa(event)">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoria</label>
            <select id="categoria" name="categoria_id" class="form-control" required>
                <!-- Categorias serão carregadas dinamicamente -->
            </select>
        </div>
        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input type="number" step="0.01" id="valor" name="valor" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="data" class="form-label">Data</label>
            <input type="date" id="data" name="data" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea id="descricao" name="descricao" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>

<script>
    // Função para carregar categorias no dropdown
    async function carregarCategorias() {
        try {
            // Certifique-se de que o endpoint correto está sendo chamado
            const response = await fetch('/appGestaoFinanceira/public/categorias');
            
            if (!response.ok) {
                throw new Error(`Erro ao buscar categorias: ${response.statusText}`);
            }

            const categorias = await response.json();

            const categoriaSelect = document.getElementById('categoria');
            categoriaSelect.innerHTML = '';

            // Adiciona uma opcao "Selecione uma categoria" como padr�o
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Selecione uma categoria';
            categoriaSelect.appendChild(defaultOption);

            categorias.forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria.id;
                option.textContent = categoria.nome;
                categoriaSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Erro ao carregar categorias:', error);
            alert('Erro ao carregar categorias. Tente novamente mais tarde.');
        }
    }

    // Funçãoo para registrar uma despesa
    async function registrarDespesa(event) {
        event.preventDefault();

        const nome = document.getElementById('nome').value;
        const categoria_id = document.getElementById('categoria').value;
        const valor = document.getElementById('valor').value;
        const data = document.getElementById('data').value;
        const descricao = document.getElementById('descricao').value;

        if (!categoria_id) {
            alert('Por favor, selecione uma categoria.');
            return;
        }

        try {
            const response = await fetch('/appGestaoFinanceira/public/despesas', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nome, categoria_id, valor, data, descricao })
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.message);
                document.getElementById('despesaForm').reset();
                carregarCategorias(); // Recarregar categorias se necessario
            } else {
                alert(result.message || "Erro ao registrar despesa.");
            }
        } catch (error) {
            console.error('Erro ao registrar despesa:', error);
            alert('Erro ao registrar despesa. Tente novamente mais tarde.');
        }
    }

    // Carregar categorias ao carregar a pagina
    document.addEventListener('DOMContentLoaded', carregarCategorias);
</script>

<?php include 'footer.php'; ?>
