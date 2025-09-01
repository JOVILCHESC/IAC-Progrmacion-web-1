<?php
// session_bootstrap.php
// Arranque de sesión con buenas prácticas para seguridad.

// Forzar cookies (no IDs en URL)
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');

// Si tu sitio usa HTTPS, activa 'secure' (aquí queda opcional por entorno local)
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params([
    'lifetime' => 60 * 30, // 30 minutos
    'path' => '/',
    'domain' => '',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_name('AGENCIASESSID');
session_start();

// Control de inactividad (sliding expiration)
$timeout = 60 * 30; // 30 minutos
if (isset($_SESSION['ultima_actividad']) && (time() - $_SESSION['ultima_actividad'] > $timeout)) {
    // Expiró por inactividad
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['ultima_actividad'] = time();

// Vincular sesión a rasgos del cliente para mitigar secuestro de sesión
$firma = $_SERVER['REMOTE_ADDR'] . '|' . ($_SERVER['HTTP_USER_AGENT'] ?? '');
if (!isset($_SESSION['firma'])) {
    $_SESSION['firma'] = hash('sha256', $firma);
} elseif ($_SESSION['firma'] !== hash('sha256', $firma)) {
    // Si cambia la firma, invalidar sesión
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['firma'] = hash('sha256', $firma);
}

// Regenerar ID periódicamente para evitar fijación de sesión
if (!isset($_SESSION['regen_time'])) {
    $_SESSION['regen_time'] = time();
}
if (time() - $_SESSION['regen_time'] > 60 * 5) { // cada 5 minutos
    session_regenerate_id(true);
    $_SESSION['regen_time'] = time();
}

// Token CSRF
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}
?>
