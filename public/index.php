<?php
session_start();
include '../includes/config.php';

$search = $_GET['search'] ?? '';
$produtos = $conn->prepare("SELECT * FROM produtos WHERE nome LIKE ?");
$produtos->execute(['%' . $search . '%']);
$produtos = $produtos->fetchAll(PDO::FETCH_ASSOC);

$categorias = $conn->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Loja Virtual</title>
    <link rel="stylesheet" href="../assets/css/public_index.css">
</head>
<body>

<header>
    <div class="header-content">
        <h1>Minha Loja Virtual</h1>
        <form method="get" class="search-form">
            <input type="text" name="search" placeholder="Buscar produtos..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">🔍</button>
        </form>
        <nav>
            <a href="index.php">🏠 Início</a>
            <a href="carrinho.php">🛒 Carrinho</a>
        </nav>
    </div>
</header>

<main>
    <aside class="sidebar">
        <h3>Categorias</h3>
        <ul>
            <li><a href="index.php" class="category-btn all">Ver Todos</a></li>
            <?php foreach ($categorias as $c): ?>
                <li><a href="categoria.php?id=<?= $c['id'] ?>" class="category-btn"><?= $c['nome'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <section class="products-section">
        <h2 class="hero-title">Produtos em Destaque</h2>
        <div class="products">
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
        </div>
    </section>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> Minha Loja Virtual — Todos os direitos reservados.</p>
</footer>

</body>
</html>
