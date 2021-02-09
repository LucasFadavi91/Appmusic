<?php 

 #Lucas Fadavi Solanilla
    require_once __DIR__ ."/../db/db.php";

        function validarDatos() {
        # Función : validarDatos
        # Parametros:
        # Ninguno
        # Funcionalidad: 
        #  Esta funcion es llamada previamente para para comprobar si existe ya una sesion
        #     establecida con una cookie y en caso afirmativo la recupera
        # Estructuras utilizadas array, bucle, select
        #
        # retorna: null en caso de que el usuario no exista
        #
        # Código realizado por Lucas Fadavi
        #
        # Fecha 08/02/2021    

            try {
                
                global $conexion;

                // Validación de error
                if ($conexion == "ERROR") {
                    header("location: logout.php");
                }

                //Consulta
                $sql = "SELECT customerId FROM customer WHERE email = :username AND LastName = :passcode";

                $resultado = $conexion->prepare($sql);
                $resultado->execute(array(":username"=>$_COOKIE["username"], ":passcode"=>$_COOKIE["passcode"]));
                $resultado_contado = $resultado->rowCount();

                //si es false te deslogea
                if ($resultado_contado == 0) {

                   header("location: ./../controllers/logout.php");

                } 
  
            }catch (PDOException $ex) {
                echo "<p>Ha ocurrido un error al devolver los datos. <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
                header("location: ./../index.php");
                return null;
            }
        
    }
?>
