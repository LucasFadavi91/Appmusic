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
    <title>Ejercicio 4</title>
</head>
<body>
<h1>Consultar facturas</h1>
<?php
    include_once("../controllers/controllers_histfacturas.php");
    imprimirFacturas($_COOKIE['user']);
?>
</body>
</html>
