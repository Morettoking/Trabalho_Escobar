<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: ../login.php'); exit; }
include '../../includes/config.php';

$produtos = $conn->query("SELECT p.*, c.nome AS categoria FROM produtos p JOIN categorias c ON p.categoria_id = c.id ORDER BY p.id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Produtos</title>
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link rel="stylesheet" href="../../assets/css/produtos.css">
</head>
<body>

<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>🛡️ Admin</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="../dashboard.php">🏠 Dashboard</a>
            <a href="../categorias/index.php">📂 Categorias</a>
            <a href="index.php">🛍️ Produtos</a>
            <a href="../vendas/index.php">💰 Vendas</a>
            <a href="../logout.php">🚪 Sair</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="dashboard-header">
            <h1>Gerenciar Produtos</h1>
            <a href="adicionar.php" class="btn add">+ Adicionar Produto</a>
        </header>

        <section class="product-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td>
                            <img src="../../assets/img/produtos/<?= $p['id'] ?>.jpg" alt="<?= $p['nome'] ?>" class="product-thumb">
                        </td>
                        <td><?= $p['nome'] ?></td>
                        <td><?= $p['categoria'] ?></td>
                        <td class="price">R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                        <td class="actions">
                            <a href="editar.php?id=<?= $p['id'] ?>" class="action-btn edit">✏️</a>
                            <a href="excluir.php?id=<?= $p['id'] ?>" class="action-btn delete" onclick="return confirm('Tem certeza que deseja excluir?')">🗑️</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>

</body>
</html>
