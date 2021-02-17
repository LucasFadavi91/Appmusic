
<?php
//Esto es para chequear si el usuario sigue logeado o existe una cookie
if (isset($_COOKIE) && isset($_COOKIE["user"]) === false) {
  exit("No estas logeado, datos incorrectos.");
  
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Miguel Garcia, Alexandru Cristea">
    <title>Facturas entre dos fechas</title>
</head>
<body>

<h1>Consultar facturas entre dos fechas</h1>
<form method="post"action="facturas.php">

      <label for="fechainicio">Desde: </label>
      <input type="date" name="fechaini" required/><br><br>

      <label for="fechafinal">Hasta: </label>
      <input type="date" name="fechafin" required/> <br><br>

    <input type='submit' value='Enviar' name='facturas'><br><br>

</form>
    <?php
      include_once("../controllers/controller_facturas.php");
      if(isset($_POST['facturas'])){
        imprimirFacturas($_COOKIE['user'],$_POST['fechaini'],$_POST['fechafin']);
      }
    ?>

</body>
<br><br><button><a href="menu.php">Volver</a></button><br>
</html>

