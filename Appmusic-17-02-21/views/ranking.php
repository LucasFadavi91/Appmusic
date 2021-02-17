<?php
if (isset($_COOKIE) && isset($_COOKIE["user"]) === false) {
    exit("No estas logeado, datos incorrectos.");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" value="Alexandru Cristea">
    <title>Ejercicio 6</title>
</head>
<body>
<h1>Ver Ranking de Descargas</h1>
  <form method="POST" action="ranking.php">
	  <label for="fechainicio">Desde: </label>
      <input type="date" name="fechainicio" required/><br><br>

      <label for="fechafinal">Hasta: </label>
      <input type="date" name="fechafinal" required/> <br><br>

    <input type='submit' value='Ver Canciones Descargadas' name='Descargas'>
  </form>
<?php
    include_once("../controllers/controllers_ranking.php");
    if(isset($_POST['Descargas'])){
      imprimirDescargas($_COOKIE['user'],$_POST['fechainicio'],$_POST['fechafinal']);
    }
?>
</body>
<li><a href="menu.php">Página Principal</a></li><br>
</html>
