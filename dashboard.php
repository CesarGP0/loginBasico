<?php
require 'includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
	header('Location: /');
}

if (!isset($_SESSION)) {
	session_start();
}

$auth = $_SESSION['login'] ?? false;
$usuario = $_SESSION['usuario'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Open+Sans&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
	<title>Login</title>
</head>

<body>

	<header class="header">
		<div class="contenedor contenido-header">
			<p class="usuario"><?php echo $usuario; ?></p>
			<nav class="barra">
				<a href="#">seccion</a>
				<a href="#">seccion</a>
				<a href="#">seccion</a>
				<?php if ($auth) { ?>
					<a href="cerrar-sesion.php">Cerrar Sesión</a>
				<?php } ?>
			</nav>
	</header>

</body>
</html>