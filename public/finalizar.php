<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    header('Location: carrinho.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO vendas (data_venda) VALUES (NOW())");
    $stmt->execute();
    $venda_id = $conn->lastInsertId();

    foreach ($_SESSION['carrinho'] as $produto_id => $quantidade) {
        $stmt = $conn->prepare("INSERT INTO vendas_itens (venda_id, produto_id, quantidade) VALUES (?, ?, ?)");
        $stmt->execute([$venda_id, $produto_id, $quantidade]);
    }

    unset($_SESSION['carrinho']);
    header('Location: obrigado.php');
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
    <title>Finalizar Compra - Minha Loja Virtual</title>
    <link rel="stylesheet" href="../assets/css/public_finalizar.css">
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
    <h2>Finalizar Compra</h2>

    <div class="summary">
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($produtos as $p):
                    $qtd = $_SESSION['carrinho'][$p['id']];
                    $subtotal = $p['preco'] * $qtd;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= $p['nome'] ?></td>
                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                    <td><?= $qtd ?></td>
                    <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <form method="post" class="finalize-form">
        <button type="submit" class="btn finalize">Confirmar Pedido</button>
        <a href="carrinho.php" class="btn back">← Voltar ao Carrinho</a>
    </form>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> Minha Loja Virtual — Todos os direitos reservados.</p>
</footer>

</body>
</html>
