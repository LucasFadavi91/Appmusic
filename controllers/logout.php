<?php 

 #Lucas Fadavi Solanilla

//Establezo el tiempo de la cookie a 0 
setcookie("user" , '' , time()-3600, '/');
 
//Redirecciono al login
header("location: ./../index.php");
exit;
?>
