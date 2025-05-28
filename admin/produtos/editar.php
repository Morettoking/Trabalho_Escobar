<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header('Location: ../login.php'); exit; }
include '../../includes/config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];

    $stmt = $conn->prepare("UPDATE produtos SET nome = ?, preco = ?, categoria_id = ? WHERE id = ?");
    $stmt->execute([$nome, $preco, $categoria_id, $id]);

    if ($_FILES['imagem']['tmp_name']) {
        move_uploaded_file($_FILES['imagem']['tmp_name'], "../../assets/img/produtos/$id.jpg");
    }

    header('Location: index.php');
    exit;
}

$categorias = $conn->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
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
        <h1>Editar Produto</h1>
        <form method="post" enctype="multipart/form-data" class="product-form">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?= $produto['nome'] ?>" required>

            <label>Preço:</label>
            <input type="number" name="preco" step="0.01" value="<?= $produto['preco'] ?>" required>

            <label>Categoria:</label>
            <select name="categoria_id" required>
                <option value="">Selecione</option>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $c['id'] == $produto['categoria_id'] ? 'selected' : '' ?>>
                        <?= $c['nome'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Imagem:</label>
            <input type="file" name="imagem" accept="image/*">

            <button type="submit" class="btn save">Salvar</button>
            <a href="index.php" class="btn cancel">Cancelar</a>
        </form>
    </main>
</div>

</body>
</html>
