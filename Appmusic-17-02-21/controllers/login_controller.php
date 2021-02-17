<?php 

 #Lucas Fadavi Solanilla

    if (isset($_POST["username"]) && isset($_POST["passcode"])) {

        require_once("../models/login_model.php");
        $validar=validarDatosFinal($_POST["username"], $_POST["passcode"]); //Comprueba las credenciales 
        header("location: ./../views/menu.php");

    } else {
        header("location: ./../index.php");
    }
?>
