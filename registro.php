<?php

require 'includes/config/database.php';
$db = conectarDB();

$alertas = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
	$password = mysqli_real_escape_string($db, $_POST['password']);
	$nombre = mysqli_real_escape_string($db,  $_POST['nombre']);


	if (!$nombre) {
		$alertas[] = "El Nombre es obligatorio";
	}

	if (!$email) {
		$alertas[] = "El email es obligatorio o no es válido";
	}

	if (!$password) {
		$alertas[] = "El Password es obligatorio";
	}

	if ($password < 6) {
		$alertas[] = "El Password debe tener 6 caracteres";
	}


	if (empty($alertas)) {

		// validar si ya existe
		$query = "SELECT * FROM usuario WHERE email = '${email}' ";
		$resultado = mysqli_query($db, $query);
		$usuario = mysqli_fetch_assoc($resultado);

		if ($usuario) {
			$alertas[] = "Este usuario ya esta registrado";
		} else {
			$passwordHash = password_hash($password, PASSWORD_BCRYPT);
			$query = " INSERT INTO usuario (nombre, email, password) VALUES ( '${nombre}', '${email}', '${passwordHash}' ); ";
			mysqli_query($db, $query);

			$alertas[] = "Cuenta Creada Correctamente";
			/* header('Location: /'); */
		}
	}
}

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

	<main class="login">
		<div class="contenido-centrado">
			<h1 class="centrar-texto no-margin">Registrarte</h1>


			<form method="POST" class="formulario">

				<fieldset class="formulario__fieldset">
					<legend class="centrar-texto">Datos Personales</legend>

					<?php foreach ($alertas as $alerta) { ?>
						<p class="formulario__alerta"><?php echo $alerta; ?></p>
					<?php } ?>

					<div class="formulario-campo">
						<label for="nombre" class="campo__label">Nombre</label>
						<input type="text" class="campo__input" name="nombre" placeholder="Tu Nombre">
					</div>

					<div class="formulario-campo">
						<label for="email" class="campo__label">Email</label>
						<input type="email" class="campo__input" name="email" placeholder="Tu Email">
					</div>

					<div class="formulario-campo">
						<label for="password" class="campo__label">Password</label>
						<input type="password" class="campo__input" name="password" placeholder="Tu Password">
					</div>

					<input type="submit" class="formulario__submit" value="Registra">

					<div class="acciones">
						<a href="index.php">¿Ya tienes una cuenta? Inicia Sesión</a>
					</div>

				</fieldset>
			</form>

		</div>


	</main>

</body>

</html>