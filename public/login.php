<?php include 'header.php'; ?>

<main class="container mt-5">
    <h1 class="text-center mb-4">Login</h1>

    <!-- Formulário -->
    <div class="card shadow">
        <div class="card-body">
            <form id="loginForm" onsubmit="autenticarUsuario(event)">
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Digite seu e-mail" required>
                </div>

                <!-- Senha -->
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" id="senha" name="senha" class="form-control" placeholder="Digite sua senha" required>
                </div>

                <!-- Botão de Enviar -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<script>
    async function autenticarUsuario(event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const senha = document.getElementById('senha').value;

        const response = await fetch('/appGestaoFinanceira/public/usuarios/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, senha })
        });

        const result = await response.json();

        if (response.ok) {
            alert(result.message);
            console.log("Usuário logado:", result.usuario);
            // Redirecionar para a página inicial após o login
            window.location.href = "/appGestaoFinanceira/public/home.php";
        } else {
            alert(result.message || "Erro ao realizar login.");
}

    }
</script>
