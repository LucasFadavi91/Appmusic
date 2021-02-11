<?php
include_once("../db/conexion.php");

function verFacturas($cliente){

   global $conexion;
   try {
    $consulta = $conexion->prepare("SELECT InvoiceDate,BillingAddress,BillingCity,BillingState,BillingCountry,BillingPostalCode,Total from invoice where Customerid = $cliente") ;

    $consulta->execute();
    return $consulta -> fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $ex) {
    echo "Ha ocurrido un error al devolver las facturas ". $ex->getMessage()."</br>";
    return null;
}
}
?>