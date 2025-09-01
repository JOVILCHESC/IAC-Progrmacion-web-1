<?php
require __DIR__ . '/session_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: carrito.php'); exit; }
if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(403); echo "CSRF inválido"; exit; }

$_SESSION['carrito'] = [];
header('Location: carrito.php');
