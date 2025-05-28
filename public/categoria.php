<?php
session_start();
include '../includes/config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM categorias WHERE id = ?");
$stmt->execute([$id]);
$categoria = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM produtos WHERE categoria_id = ?");
$stmt->execute([$id]);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Categoria: <?= $categoria['nome'] ?></title>
    <link rel="stylesheet" href="../assets/css/public_categoria.css">
</head>
<body>

<header>
    <div class="header-content">
        <h1><?= $categoria['nome'] ?></h1>
        <nav>
            <a href="index.php">🏠 Início</a>
            <a href="carrinho.php">🛒 Carrinho</a>
        </nav>
    </div>
</header>

<main>
    <section class="hero">
        <h2>Explorando a categoria: <?= $categoria['nome'] ?></h2>
        <p>Veja os melhores produtos disponíveis para você</p>
    </section>

    <section class="products">
        <?php foreach ($produtos as $p): ?>
        <div class="product-card">
            <img src="../assets/img/produtos/<?= $p['id'] ?>.jpg" alt="<?= $p['nome'] ?>">
            <h3><?= $p['nome'] ?></h3>
            <p class="price">R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
            <div class="buttons">
                <a href="produto.php?id=<?= $p['id'] ?>" class="btn">Ver Detalhes</a>
                <a href="carrinho.php?add=<?= $p['id'] ?>" class="btn add-cart">Adicionar</a>
            </div>
        </div>
        <?php endforeach; ?>
    </section>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> Minha Loja Virtual — Todos os direitos reservados.</p>
</footer>

</body>
</html>
