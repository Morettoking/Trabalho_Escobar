<?php
try {
    $conn = new PDO('mysql:host=localhost;dbname=loja_virtual', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit;
}
?>
