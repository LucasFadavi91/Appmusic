<?php


include_once("../db/db.php");


function verFacturas($id, $fechaini, $fechafin){
    # Función 'verFacturas'. 
    # Parámetros: 
    # 	- $id 
    #   - $fechaini
    #   - $fechafin
    # Funcionalidad:
    # Muestra los datos de las facturas del cliente entre dos fechas determinadas ordenadas por fecha
    # Código por Alexandru Cristea y Miguel Garcia

    
   global $conexion;

   try {
       $consulta = $conexion->prepare("SELECT InvoiceDate, BillingAddress, BillingCity, BillingState, BillingCountry, BillingPostalCode, Total FROM invoice
       WHERE customerId=$id AND InvoiceDate>=:fechainicio AND InvoiceDate<=:fechafinal ORDER BY InvoiceDate ASC") ;

       $consulta->bindParam(":fechainicio",$fechaini);
       $consulta->bindParam(":fechafinal",$fechafin);
       $consulta->execute();
     
       return $consulta -> fetchAll(PDO::FETCH_ASSOC);
       
       
   } catch (PDOException $ex) {
       echo "<p>Ha ocurrido un error al devolver los datos de las facturas  <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
       return null;
   }

}

?>
