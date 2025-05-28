<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
include '../includes/config.php';

$categorias_count = $conn->query("SELECT COUNT(*) FROM categorias")->fetchColumn();
$produtos_count = $conn->query("SELECT COUNT(*) FROM produtos")->fetchColumn();
$vendas_count = $conn->query("SELECT COUNT(*) FROM vendas")->fetchColumn();
$vendas = $conn->query("SELECT * FROM vendas ORDER BY data_venda DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>🛡️ Admin</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="dashboard.php">🏠 Dashboard</a>
            <a href="categorias/index.php">📂 Categorias</a>
            <a href="produtos/index.php">🛍️ Produtos</a>
            <a href="vendas/index.php">💰 Vendas</a>
            <a href="logout.php">🚪 Sair</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="dashboard-header">
            <h1>Painel Administrativo</h1>
        </header>

        <section class="cards">
            <div class="card">
                <h3>Categorias</h3>
                <p><?= $categorias_count ?></p>
                <a href="categorias/index.php">Gerenciar</a>
            </div>
            <div class="card">
                <h3>Produtos</h3>
                <p><?= $produtos_count ?></p>
                <a href="produtos/index.php">Gerenciar</a>
            </div>
            <div class="card">
                <h3>Vendas</h3>
                <p><?= $vendas_count ?></p>
                <a href="vendas/index.php">Ver todas</a>
            </div>
        </section>

        <section class="last-sales">
            <h2>Últimas Vendas</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vendas as $v): ?>
                    <tr>
                        <td><?= $v['id'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($v['data_venda'])) ?></td>
                        <td><a href="vendas/visualizar.php?id=<?= $v['id'] ?>">Visualizar</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>

</body>
</html>
