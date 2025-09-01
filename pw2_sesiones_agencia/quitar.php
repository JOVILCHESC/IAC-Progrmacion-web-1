<?php
require __DIR__ . '/session_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: carrito.php'); exit; }
if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(403); echo "CSRF inválido"; exit; }

$id = intval($_POST['id'] ?? 0);
if (isset($_SESSION['carrito'][$id])) {
    unset($_SESSION['carrito'][$id]);
}
header('Location: carrito.php');
