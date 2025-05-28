<?php
function formataPreco($preco) {
    return 'R$ ' . number_format($preco, 2, ',', '.');
}

function protegeAdmin() {
    if (!isset($_SESSION['admin_id'])) {
        header('Location: ../login.php');
        exit;
    }
}

function redireciona($url) {
    header("Location: $url");
    exit;
}
