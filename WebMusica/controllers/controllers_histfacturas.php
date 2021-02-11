<?php
    include_once("../models/models_histfacturas.php");
    function  imprimirFacturas($user_id){
        $i = 0;
        
        $facturas = verFacturas($user_id);
        if(!empty($facturas)){
            echo "<h1>Facturas:</h1><table border='2'>";
            foreach ($facturas as $key => $fila) {
                
                if ($i == 0) {
                    echo "<tr>";
                    foreach ($fila as $columna => $valor) {
                        echo "<td>$columna</td>";
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
            echo "Este cliente no tiene facturas";
        }
    }

?>