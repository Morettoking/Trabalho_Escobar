<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: ../login.php'); exit; }
include '../../includes/config.php';

$categorias = $conn->query("SELECT * FROM categorias ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Categorias</title>
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link rel="stylesheet" href="../../assets/css/categorias.css">
</head>
<body>

<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>🛡️ Admin</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="../dashboard.php">🏠 Dashboard</a>
            <a href="index.php">📂 Categorias</a>
            <a href="../produtos/index.php">🛍️ Produtos</a>
            <a href="../vendas/index.php">💰 Vendas</a>
            <a href="../logout.php">🚪 Sair</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="dashboard-header">
            <h1>Gerenciar Categorias</h1>
            <a href="adicionar.php" class="btn add">+ Adicionar Categoria</a>
        </header>

        <section class="last-sales">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= $c['nome'] ?></td>
                        <td>
                            <a href="editar.php?id=<?= $c['id'] ?>" class="action-btn edit">✏️ Editar</a>
                            <a href="excluir.php?id=<?= $c['id'] ?>" class="action-btn delete" onclick="return confirm('Tem certeza que deseja excluir?')">🗑️ Excluir</a>
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
