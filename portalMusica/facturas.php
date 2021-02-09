<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5</title>
</head>
<body>
<h1>Consultar facturas entre dos fechas</h1>
<form method="post" action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>">

      <label for="fechainicio">Desde: </label>
      <input type="date" name="fechainicio" required/><br><br>

      <label for="fechafinal">Hasta: </label>
      <input type="date" name="fechafinal" required/> <br><br>

    <input type='submit' value='Ver facturas totales' name='facturaTotal'>

</form>
    
</body>
</html>

<?php

   include_once("funciones.php");

if (isset($_POST) && !empty($_POST)) {

   $fecha_inicio=$_POST["fechainicio"];
   $fecha_final=$_POST["fechafinal"];

  $datos=verFacturas($fecha_inicio,$fecha_final);
 

   if($datos!=null) imprimirFacturas($datos); 
   else echo "<p>No hay registro de facturas entre éstas dos fechas. <p>"; 



} else echo"<p>Seleccione las fechas <p>";

?>