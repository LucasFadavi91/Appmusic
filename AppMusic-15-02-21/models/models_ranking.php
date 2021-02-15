<?php

include_once("../db/db.php");

function verDescargas($cliente,$fecha_inicio,$fecha_final){
    # Función 'verDescargas'. 
    # Parámetros: 
    # 	- $cliente (CustomerId guardado en cookie )
    #   - $fecha_inicio
    #   - $fecha_final
    # Funcionalidad:
    # Conseguir todas las canciones descargadas entre 2 fechas
    # Código por Alexandru Cristea
    
   global $conexion;
   try {
    $consulta = $conexion->prepare("SELECT track.name AS Nombre, SUM( invoiceline.Quantity ) AS Descargas
    FROM track
    JOIN invoiceline ON invoiceline.Trackid = track.TrackId
    JOIN invoice ON invoiceline.InvoiceId = invoice.InvoiceId
    where InvoiceDate >=:fechainicio AND InvoiceDate <=:fechafinal
    GROUP BY invoiceline.TrackId
    ORDER BY Descargas DESC , invoiceline.trackid ASC");
    $consulta->bindParam(":fechainicio",$fecha_inicio);
    $consulta->bindParam(":fechafinal",$fecha_final);
    $consulta->execute();
    return $consulta -> fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $ex) {
    echo "Ha ocurrido un error al devolver las descargas ". $ex->getMessage()."</br>";
    return null;
}
}
?>
