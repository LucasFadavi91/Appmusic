<?php

    include_once("../models/models_ranking.php");
    function  imprimirDescargas($user_id,$fechaini,$fechafin){
    # Función 'ImprimirFacturas'. 
    # Parámetros: 
    # 	- $user_id (es el $cliente declarado aqui como otra variable)
    #   - $fecha_inicio
    #   - $fecha_final
    # Funcionalidad:
    # Imprimir las descargas de las canciones ordenadas descendentemente
    # Código por Alexandru Cristea
        
        $i = 0;
        $descargas = verDescargas($user_id,$fechaini,$fechafin);
        if(!empty($descargas)){
            echo "<h1>Descargas:</h1><table style='width:100%;' border='3'>";
            foreach ($descargas as $key => $fila) {
                if ($i == 0) {
                    echo "<tr>";
                    foreach ($fila as $columna => $valor) {
                        echo "<th>$columna</th>";
                    }
                    echo "</tr>";
                }
                echo "<tr>";
                foreach ($fila as $columna => $valor) {
                    echo "<td style='background-color:red;'>$valor</td>";
                }
                echo "</tr>";
                $i++;
            }
            echo "</table>";
        }else{
            echo "No se ha descargado ninguna canción";
        }
    }

?>