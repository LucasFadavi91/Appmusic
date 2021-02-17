<?php

include_once("../models/model_facturas.php");

function imprimirFacturas($id, $fechaini, $fechafin){
    # Función 'ImprimirFacturas'. 
    # Parámetros: 
    # 	- $id 
    #   - $fechaini
    #   - $fechafin
    # Funcionalidad:
    # Muestra las facturas en forma de tabla HTML
    # Código por Alexandru Cristea y Miguel Garcia

  $i = 0;
  $facturas = verFacturas($id, $fechaini, $fechafin);
  
  if($fechaini > $fechafin){
  
    echo "La fecha de inicio no puede ser mayor que la fecha de fin";

    } elseif($facturas!=null){

            echo "<h1>Facturas:</h1><table style='width:100%;' border='1'>";
            foreach ($facturas as $key => $fila) {
                if ($i == 0) {
                    echo "<tr>";
                    foreach ($fila as $columna => $valor) {
                        echo "<th>$columna</th>";
                    }
                    echo "</tr>";
                }
                echo "<tr>";
                foreach ($fila as $columna => $valor) {
                    echo "<td>$valor</td>";
                }
                echo "</tr>";
                $i++;
            }
            echo "</table>";
        }else{
            echo "No existen facturas entre esas fechas";
            }
    }

?>