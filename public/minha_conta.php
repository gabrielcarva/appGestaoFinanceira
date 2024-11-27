<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'header.php';
?>

<main class="container mt-5">
    <div class="card shadow">
        <div class="card-body text-center">
            <h2 class="mb-4">Minha Conta</h2>
            <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</p>
            <div class="d-grid gap-2">
                <a href="logout.php" class="btn btn-danger">Logout</a>
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalMudarSenha">Mudar Senha</button>
                <button class="btn btn-secondary">Mudar Nome</button>
                <button class="btn btn-secondary">Excluir Usuário</button>
            </div>
        </div>
    </div>
</main>

<!-- Modal para Mudar Senha -->
<div class="modal fade" id="modalMudarSenha" tabindex="-1" aria-labelledby="modalMudarSenhaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalMudarSenhaLabel">Mudar Senha</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formMudarSenha">
          <div class="mb-3">
            <label for="senhaAtual" class="form-label">Senha Atual</label>
            <input type="password" class="form-control" id="senhaAtual" required>
          </div>
          <div class="mb-3">
            <label for="novaSenha" class="form-label">Nova Senha</label>
            <input type="password" class="form-control" id="novaSenha" required>
          </div>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

<script>
document.getElementById('formMudarSenha').addEventListener('submit', async function (event) {
    event.preventDefault();

    const senhaAtual = document.getElementById('senhaAtual').value.trim();
    const novaSenha = document.getElementById('novaSenha').value.trim();

    if (!senhaAtual || !novaSenha) {
        alert("Preencha todos os campos.");
        return;
    }

    try {
        const response = await fetch('/appGestaoFinanceira/public/usuarios/mudar_senha', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
        credentials: 'include', // Inclui cookies na requisição
        body: JSON.stringify({ senha_atual: senhaAtual, nova_senha: novaSenha })
    });


        const result = await response.json();

        if (response.ok) {
            alert(result.message);
            document.getElementById('formMudarSenha').reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalMudarSenha'));
            modal.hide();
        } else {
            alert(result.message || "Erro ao alterar senha.");
        }
    } catch (error) {
        console.error("Erro:", error);
        alert("Erro ao conectar com o servidor.");
    }
});
</script>