<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: ../login.php'); exit; }
include '../../includes/config.php';

$vendas = $conn->query("SELECT * FROM vendas ORDER BY data_venda DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Vendas</title>
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link rel="stylesheet" href="../../assets/css/vendas.css">
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
            <a href="../produtos/index.php">🛍️ Produtos</a>
            <a href="index.php">💰 Vendas</a>
            <a href="../logout.php">🚪 Sair</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="dashboard-header">
            <h1>Gerenciar Vendas</h1>
        </header>

        <section class="sales-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vendas as $v): ?>
                    <tr>
                        <td><?= $v['id'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($v['data_venda'])) ?></td>
                        <td class="actions">
                            <a href="visualizar.php?id=<?= $v['id'] ?>" class="action-btn view" title="Visualizar">
                                👁️ Visualizar
                            </a>
                            <a href="excluir.php?id=<?= $v['id'] ?>" class="action-btn delete" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir?')">
                                🗑️ Excluir
                            </a>
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
