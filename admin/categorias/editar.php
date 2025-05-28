<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: ../login.php'); exit; }
include '../../includes/config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM categorias WHERE id = ?");
$stmt->execute([$id]);
$categoria = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $stmt = $conn->prepare("UPDATE categorias SET nome = ? WHERE id = ?");
    $stmt->execute([$nome, $id]);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoria</title>
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
        <h1>Editar Categoria</h1>
        <form method="post" class="category-form">
            <label for="nome">Nome da Categoria:</label>
            <input type="text" name="nome" id="nome" value="<?= $categoria['nome'] ?>" required>
            <button type="submit" class="btn save">Salvar</button>
            <a href="index.php" class="btn cancel">Cancelar</a>
        </form>
    </main>
</div>

</body>
</html>
