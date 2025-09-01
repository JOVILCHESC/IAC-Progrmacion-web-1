<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Búsqueda de Vuelos</title>
</head>
<body>
  <h2>Buscar Vuelos</h2>
  <form action="resultados.php" method="GET">
    <label for="origen">Origen:</label>
    <input type="text" id="origen" name="origen" required>
    <br><br>
    <label for="destino">Destino:</label>
    <input type="text" id="destino" name="destino" required>
    <br><br>
    <label for="fecha">Fecha:</label>
    <input type="date" id="fecha" name="fecha" required>
    <br><br>
    <button type="submit">Buscar</button>
  </form>
</body>
</html>
