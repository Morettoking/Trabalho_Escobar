<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Obrigado pela Compra! - Minha Loja Virtual</title>
    <link rel="stylesheet" href="../assets/css/public_obrigado.css">
</head>
<body>

<header>
    <div class="header-content">
        <h1>Minha Loja Virtual</h1>
        <nav>
            <a href="index.php">🏠 Início</a>
            <a href="carrinho.php">🛒 Carrinho</a>
        </nav>
    </div>
</header>

<main>
    <div class="thank-you-container">
        <h2>🎉 Obrigado pela sua compra!</h2>
        <p>Seu pedido foi registrado com sucesso. Em breve entraremos em contato com mais detalhes.</p>
        <p>Enquanto isso, continue navegando e aproveite mais ofertas incríveis.</p>
        <a href="index.php" class="btn back">← Voltar à Loja</a>
    </div>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> Minha Loja Virtual — Todos os direitos reservados.</p>
</footer>

</body>
</html>
