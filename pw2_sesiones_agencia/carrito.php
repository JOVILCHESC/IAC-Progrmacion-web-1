<?php
require __DIR__ . '/session_bootstrap.php';

$catalogo = [
    1 => ["nombre" => "Caribe 5 noches", "precio" => 599.90],
    2 => ["nombre" => "Patagonia Aventura", "precio" => 799.50],
    3 => ["nombre" => "San Pedro de Atacama", "precio" => 459.00],
];

$carrito = $_SESSION['carrito'] ?? [];
$subtotal = 0.0;

function linea($id, $cantidad, $catalogo) {
    if (!isset($catalogo[$id])) return null;
    $item = $catalogo[$id];
    $precio = $item['precio'];
    $total = $precio * $cantidad;
    return [$item['nombre'], $precio, $cantidad, $total];
}

?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carrito — Agencia de Viajes</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
  <h1>Carrito de compra</h1>
  <nav>
    <a href="index.php">Catálogo</a>
    <a href="carrito.php">Carrito (<?php echo array_sum($carrito); ?>)</a>
  </nav>
</header>

<main>
  <?php if (!$carrito): ?>
    <p>No hay productos en el carrito.</p>
  <?php else: ?>
    <table class="tabla">
      <thead>
        <tr><th>Paquete</th><th>Precio</th><th>Cantidad</th><th>Total</th><th>Acciones</th></tr>
      </thead>
      <tbody>
      <?php foreach ($carrito as $id => $cantidad): 
        $row = linea($id, $cantidad, $catalogo);
        if (!$row) continue;
        [$nombre, $precio, $cant, $total] = $row;
        $subtotal += $total;
      ?>
        <tr>
          <td><?php echo htmlspecialchars($nombre); ?></td>
          <td>$<?php echo number_format($precio, 2, ',', '.'); ?></td>
          <td><?php echo $cant; ?></td>
          <td>$<?php echo number_format($total, 2, ',', '.'); ?></td>
          <td>
            <form action="quitar.php" method="post" style="display:inline;">
              <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">
              <input type="hidden" name="id" value="<?php echo (int)$id; ?>">
              <button type="submit">Quitar</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

    <p class="total">Subtotal: $<?php echo number_format($subtotal, 2, ',', '.'); ?></p>

    <form action="vaciar.php" method="post">
      <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">
      <button type="submit" class="danger">Vaciar carrito</button>
    </form>
  <?php endif; ?>
</main>

<footer>
  <small>Demostración de sesiones en PHP — Programación Web II</small>
</footer>
</body>
</html>
