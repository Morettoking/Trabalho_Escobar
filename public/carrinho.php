<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_GET['add'])) {
    $id = $_GET['add'];
    if (!isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id] = 1;
    } else {
        $_SESSION['carrinho'][$id]++;
    }
    header('Location: carrinho.php');
    exit;
}

if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id]--;
        if ($_SESSION['carrinho'][$id] <= 0) {
            unset($_SESSION['carrinho'][$id]);
        }
    }
    header('Location: carrinho.php');
    exit;
}

$ids = array_keys($_SESSION['carrinho']);
$produtos = [];

if (count($ids) > 0) {
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras - Minha Loja Virtual</title>
    <link rel="stylesheet" href="../assets/css/public_carrinho.css">
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
    <h2>Seu Carrinho</h2>

    <?php if (empty($produtos)) : ?>
        <p class="empty">Seu carrinho está vazio 😞</p>
        <a href="index.php" class="btn back">← Voltar à loja</a>
    <?php else : ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço Unitário</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($produtos as $produto):
                    $qtd = $_SESSION['carrinho'][$produto['id']];
                    $subtotal = $produto['preco'] * $qtd;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= $produto['nome'] ?></td>
                    <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                    <td><?= $qtd ?></td>
                    <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                    <td>
                        <a href="carrinho.php?add=<?= $produto['id'] ?>" class="action-btn add">+</a>
                        <a href="carrinho.php?remove=<?= $produto['id'] ?>" class="action-btn remove">−</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td colspan="2"><strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="cart-buttons">
            <a href="finalizar.php" class="btn finalize">Finalizar Compra</a>
            <a href="index.php" class="btn back">← Continuar Comprando</a>
        </div>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> Minha Loja Virtual — Todos os direitos reservados.</p>
</footer>

</body>
</html>
