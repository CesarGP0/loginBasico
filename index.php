<?php

require 'includes/config/database.php';
$db = conectarDB();

$alertas = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
	$password = mysqli_real_escape_string($db, $_POST['password']);


	if (!$email) {
		$alertas[] = "El email es obligatorio o no es válido";
	}

	if (!$password) {
		$alertas[] = "El Password es obligatorio";
	}
	// Inicia Sesión
	if (empty($alertas)) {
		// Revisa si existe el usuario
		$query = "SELECT * FROM usuario WHERE email = '${email}' ";
		$resultado = mysqli_query($db, $query);


		if ($resultado->num_rows) {

			$usuario = mysqli_fetch_assoc($resultado);
			$auth = password_verify($password, $usuario['password']);

			if ($auth) {

				session_start();

				$_SESSION['usuario'] = $usuario['nombre'];
				$_SESSION['login'] = true;


				header('Location: dashboard.php');
			} else {
				$alertas[] = 'El password es incorrecto';
			}
		} else {
			$alertas[] = 'El usuario no existe';
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
			<h1 class="centrar-texto no-margin">Iniciar Sesión</h1>


			<form method="POST" class="formulario">

				<fieldset class="formulario__fieldset">
					<legend class="centrar-texto">Acceder</legend>

					<?php foreach ($alertas as $alerta) { ?>
						<p class="formulario__alerta"><?php echo $alerta; ?></p>
					<?php } ?>
			

					<div class="formulario-campo">
						<label for="email" class="campo__label">Email</label>
						<input type="email" class="campo__input" name="email" placeholder="Tu Email">
					</div>

					<div class="formulario-campo">
						<label for="password" class="campo__label">Password</label>
						<input type="password" class="campo__input" name="password" placeholder="Tu Password">
					</div>

					<input type="submit" class="formulario__submit" value="Iniciar Sesión">

					<div class="acciones">
						<a href="registro.php">¿Aún no tienes una cuenta? Crea una</a>
					</div>

				</fieldset>
			</form>

		</div>


	</main>

</body>

</html>