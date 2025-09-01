<?php
require __DIR__ . '/session_bootstrap.php';

// Catálogo simple de paquetes turísticos (en la vida real vendría de BD)
$catalogo = [
    1 => ["nombre" => "Caribe 5 noches", "precio" => 599.90],
    2 => ["nombre" => "Patagonia Aventura", "precio" => 799.50],
    3 => ["nombre" => "San Pedro de Atacama", "precio" => 459.00],
];

// Inicializar carrito
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = []; // id => cantidad
}

// Feedback
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Agencia de Viajes — Catálogo</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
  <h1>Agencia de Viajes — Paquetes</h1>
  <nav>
    <a href="index.php">Catálogo</a>
    <a href="carrito.php">Carrito (<?php echo array_sum($_SESSION['carrito']); ?>)</a>
  </nav>
</header>

<main>
  <?php if ($flash): ?>
    <div class="flash"><?php echo htmlspecialchars($flash); ?></div>
  <?php endif; ?>

  <section class="grid">
    <?php foreach ($catalogo as $id => $p): ?>
      <article class="card">
        <h3><?php echo htmlspecialchars($p["nombre"]); ?></h3>
        <p class="precio">$<?php echo number_format($p["precio"], 2, ',', '.'); ?></p>
        <form action="agregar.php" method="post">
          <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <label>Cantidad:
            <input type="number" name="cantidad" min="1" value="1">
          </label>
          <button type="submit">Agregar al carrito</button>
        </form>
      </article>
    <?php endforeach; ?>
  </section>
</main>

<footer>
  <small>Demostración de sesiones en PHP — Programación Web II</small>
</footer>
</body>
</html>
