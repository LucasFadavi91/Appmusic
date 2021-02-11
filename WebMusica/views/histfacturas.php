<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="">
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
