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
                <button class="btn btn-secondary">Mudar Senha</button>
                <button class="btn btn-secondary">Mudar Nome</button>
                <button class="btn btn-secondary">Excluir Usuário</button>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
