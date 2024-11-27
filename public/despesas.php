<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Despesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center">Gerenciar Despesas</h1>
        <div class="mt-4">
            <!-- Botões -->
            <div class="d-grid gap-2">
                <!-- Botão para Registrar Despesas -->
                <a href="/appGestaoFinanceira/public/registrar_despesa.php" class="btn btn-primary btn-lg">Registrar Despesas</a>
                <!-- Botão para Categorias de Despesas -->
                <a href="/appGestaoFinanceira/public/categorias_despesas.php" class="btn btn-secondary btn-lg">Categorias de Despesas</a>
                <!-- Botão para Listar Despesas -->
                <a href="/appGestaoFinanceira/public/listar_despesas.php" class="btn btn-info btn-lg">Listar Despesas</a>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
