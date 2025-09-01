<?php
require __DIR__ . '/session_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php'); exit;
}

if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
    http_response_code(403);
    echo "CSRF inválido"; exit;
}

$id = intval($_POST['id'] ?? 0);
$cantidad = max(1, intval($_POST['cantidad'] ?? 1));

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$_SESSION['carrito'][$id] = ($_SESSION['carrito'][$id] ?? 0) + $cantidad;
$_SESSION['flash'] = "Se agregó el paquete #$id (x$cantidad) al carrito.";

// Regenerar id al pasar a estado 'con carrito'
session_regenerate_id(true);

header('Location: index.php');
