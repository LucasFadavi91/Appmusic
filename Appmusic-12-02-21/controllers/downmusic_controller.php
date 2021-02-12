<meta charset="utf-8" />
<style>
.error{
	color:red;
	}
.ok{
	color:green;
}
.mover{
	postion:absolute;
	right: 10%;
	top: 74%;
	
}
</style>
<?php


//Llamada al modelo, intermediario entre vista y modelo
require_once("../models/downmusic_model.php");
//Si el usuario esta logeado (cookie -> usuario) procede  a listar todas las canciones y proceder con la compra
if (!empty($_COOKIE["user"])) {
   
	//Llamada a la vista, intermediario entre vista y modelo
	//Se obtiene la lista de las canciones para mostrarlas en la vista downmusic.php
	$musica=listaCanciones();

	//Obtenemos las canciones anteriores
	$listaCarrito=array();// declaro un array vacío para usarlo posteriormente para almacenar las canciones en una sola cookie

	//Si existe la cookie carrito, se desiariliza para obtener los datos posteriomente y hacer uso de ellos  
	if(isset($_COOKIE["carrito"])){
		$listaCarrito=unserialize($_COOKIE['carrito']);
	} else{ //En caso de no existir la cookie carrito o usuario (se añadirá posteriormente) redirigirá a la página de login
	//header('Location: http://www.example.com/');
	}

	//1º Añadir al carrito
	if (isset($_POST["agregar"])){
		if(isset($_POST["producto"])){
			$ultimaPos=count($listaCarrito);
			$listaCarrito[$ultimaPos]["cancion"]= $_POST["producto"];
			$listaCarrito[$ultimaPos]["cantidad"]= $_POST["cantidad"];
			$precioCan=precioCancion($_POST["producto"]);
			$listaCarrito[$ultimaPos]["precio"]=$precioCan;
			setcookie("carrito", serialize($listaCarrito), time() + (86400 * 10), '/');
		
			echo "<p class='ok'><strong>Título agregado al carrito</strong></p><br><br>";
		}
	}
		
		
	//2º si se hace click en el input ver y si la cookie carrito no esta vacía (se muestra la tablaProductos y el precio total de estos)

	if(isset($_POST["ver"])){
		if(!empty($_COOKIE["carrito"])){
			tablaCanciones($listaCarrito);
			echo "<br>";
			//Se saca el precio total a pagar de los productos
			$totalPrecio=precioTitulo($listaCarrito);
			echo "Total a pagar: <strong>$totalPrecio €</strong><br><br>";
			//echo '<input class="" type="submit" name="vaciar" value="Vaciar carrito">';
			echo "<br>";
			//echo "<label>Tarjeta de cr&eacute;dito</label> <input type='text' name='card' value=''>&nbsp;&nbsp;"; //NO FUNCIONA $_POST[""] de estos input´s (¿SOLUCIÓN?)
			//echo '<input class="" type="submit" name="paga" value="Finalizar compra">';
		}else {
			echo "<p class='error'>No hay títulos añadidos al carrito</p><br><br>";
		}	
	}

	//3º vacíar carrito, para ello se pone el tiempo de expiración de la cookie a una anterior (-)
	if(isset($_POST["vaciar"])){
		setcookie("carrito", serialize($listaCarrito), time() + (-86400 * 10), '/');
	}

	///Comprar
	if(isset($_POST["pagar"])){
		if(!empty($_COOKIE["carrito"])){
			$totalPrecio2=precioTitulo($listaCarrito);
			$cancionPrice=precioTitulo($listaCarrito);
			comprar($cancionPrice);
		} else{
			echo "<p class='error'>No has agregado ningún artículo al carrito</p>";
		}
	}
} else{ //Si no existe la $_COOKIE["usuario"], es decir el usuario no esta logeado, volverá a la pág de login.php para logearse
	//exit("No estas logeado, datos incorrectos."); 
	header("location:../views/login.php");
	}		
			
//Llamada a la vista, intermediario entre vista y modelo
require_once("../views/downmusic_view.php");
	
?>
