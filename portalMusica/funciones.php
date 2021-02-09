<?php
include_once("conexion.php");


function verFacturas($fecha_inicio, $fecha_final){



   global $conexion;

   global $conexion;
   try {
       $consulta = $conexion->prepare("SELECT InvoiceLine.InvoiceId, Invoice.InvoiceDate FROM 
       Invoice LEFT JOIN InvoiceLine ON Invoice.InvoiceId=InvoiceLine.InvoiceId 
       WHERE InvoceDate>=:fechainicio AND InvoceDate<=:fechafinal") ;

       $consulta->bindParam(":fechainicio",$fecha_inicio);
       $consulta->bindParam(":fechafinal",$fecha_final);
       $consulta->execute();
       $datos = $consulta -> fetchAll(PDO::FETCH_ASSOC);

       if(!empty($datos)){
           return $datos;
       } else {
           return null;
       }
       
       //return !empty($datos)? $datos: null;
   } catch (PDOException $ex) {
       echo "<p>Ha ocurrido un error al devolver los datos de las facturas  <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
       return null;
   }

}

function  imprimirFacturas($datos){


    echo 	"<p>Facturas en las fechas indicadas: <p><table border='1'>
    <tr>
        <th>Código de factura es</th>
        
    </tr>";


}


?>