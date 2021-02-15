<?php
 #Lucas Fadavi Solanilla

//Esto es para chequear si el usuario sigue logeado o existe una cookie
if (isset($_COOKIE) && isset($_COOKIE["user"]) === false) {
  exit("No estas logeado, datos incorrectos.");
  
}
	
?>


<!DOCTYPE html>
<html>
<head>
	<title>Web musical</title>
	<meta charset="utf-8" />
	<meta name="author" value="Lucas Fadavi" />
</head>
<body>
	<h1>Bienvenido <?php echo htmlspecialchars($_COOKIE["user"]) ?></h1>
	<li><a href="./../controllers/logout.php">Cerrar sesión</a></li>
	<li><a href="downmusic_view.php">Descargar musica</a></li>
	<li><a href="histfacturas.php">Consultar historial de facturas</a></li>
	<li><a href="facturas.php">Consultar facturas entre dos fechas</a></li>
	<li><a href="ranking.php">Consultar descargas entre dos fechas</a></li>
</body>
</html>

