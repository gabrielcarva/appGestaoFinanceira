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
    <div class="card shadow text-center">
        <div class="card-body">
            <h1 class="mb-4">Você está logado</h1>
            <a href="minha_conta.php" class="btn btn-primary">Minha Conta</a>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
