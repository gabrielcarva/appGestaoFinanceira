<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão Financeira</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/appGestaoFinanceira/public/styles.css"> <!-- CSS Personalizado -->
</head>
<body class="d-flex flex-column min-vh-100">
    <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/appGestaoFinanceira/public/home.php">Gestão Financeira</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <!-- Usuário logado -->
                        <li class="nav-item">
                            <a class="nav-link" href="/appGestaoFinanceira/public/despesas.php">Despesas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/appGestaoFinanceira/public/minha_conta.php">Minha Conta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/appGestaoFinanceira/public/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <!-- Usuário não logado -->
                        <li class="nav-item">
                            <a class="nav-link" href="/appGestaoFinanceira/public/cadastro.php">Cadastro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/appGestaoFinanceira/public/login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
