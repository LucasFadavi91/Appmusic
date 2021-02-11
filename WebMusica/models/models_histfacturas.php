<?php

include_once("../db/db.php");

function verFacturas($cliente){
    # Función 'verFacturas'. 
    # Parámetros: 
    # 	- $cliente (CustomerId guardado en cookie )
    # Funcionalidad:
    # Conseguir todos los datos de la factura del cliente que se ha logueado ( previamente guardado en una cookie )
    # Código por Alexandru Cristea
    
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