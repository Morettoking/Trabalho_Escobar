<?php
session_start();
include '../includes/config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    echo "<p>Produto não encontrado.</p>";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM categorias WHERE id = ?");
$stmt->execute([$produto['categoria_id']]);
$categoria = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $produto['nome'] ?> - Minha Loja Virtual</title>
    <link rel="stylesheet" href="../assets/css/public_produto.css">
</head>
<body>

<header>
    <div class="header-content">
        <h1>Minha Loja Virtual</h1>
        <nav>
            <a href="index.php">🏠 Início</a>
            <a href="categoria.php?id=<?= $categoria['id'] ?>">📂 <?= $categoria['nome'] ?></a>
            <a href="carrinho.php">🛒 Carrinho</a>
        </nav>
    </div>
</header>

<main>
    <div class="product-container">
        <div class="product-image">
            <img src="../assets/img/produtos/<?= $produto['id'] ?>.jpg" alt="<?= $produto['nome'] ?>">
        </div>
        <div class="product-details">
            <h2><?= $produto['nome'] ?></h2>
            <p class="price">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
            <p class="description">Este é um produto incrível que vai transformar sua vida. Aproveite essa oportunidade!</p>
            <div class="buttons">
                <a href="carrinho.php?add=<?= $produto['id'] ?>" class="btn add-cart">Adicionar ao Carrinho</a>
                <a href="index.php" class="btn back">← Voltar à Loja</a>
            </div>
        </div>
    </div>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> Minha Loja Virtual — Todos os direitos reservados.</p>
</footer>

</body>
</html>
