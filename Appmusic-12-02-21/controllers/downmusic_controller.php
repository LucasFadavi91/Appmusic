<meta charset="utf-8" />
<style>
.error{
	color:red;
	position:absolute;
	//margin-left:10%;
	top:29%;
	}
.ok{
	color:green;
	position:absolute;
	//margin-left:10%;
	top:29%;
}
.mover{
	postion:absolute;
	right: 10%;
	top: 74%;
	
}
.mover2{
		position:absolute;
		//margin-left:19%;
		top:28%;
}

.btnvaciar{
	position:absolute;
		margin-left:7%;
		
		top:95%;
}

.paga{
		position:absolute;
		margin-left:11%;
		top:30%;
}
</style>
<?php

//Llamada al modelo, intermediario entre vista y modelo
require_once("../models/downmusic_model.php");
//Si el usuario esta logeado (cookie -> usuario) procede  a listar todas las canciones y proceder con la compra
if (!empty($_COOKIE["user"])) {
   echo '<form name"prueba" action="" method="post">';
	//Llamada a la vista, intermediario entre vista y modelo
	//Se obtiene la lista de las canciones para mostrarlas en la vista downmusic.php
	$musica=listaCanciones();

	//Obtenemos las canciones anteriores
	$listaCarrito=array();// declaro un array vacío para usarlo posteriormente para almacenar las canciones en una sola cookie

	//Si existe la cookie carrito, se desiariliza para obtener los datos posteriomente y hacer uso de ellos  
	if(isset($_COOKIE["carrito"])){
		$listaCarrito=unserialize($_COOKIE['carrito']);
	}
	
	
	//1º Añadir al carrito
	if (isset($_POST["agregar"])){
		if(!empty($_POST["producto"][0])){//Si  se selecciona un producto de la lista se añade al carrito dicho producto
			$ultimaPos=count($listaCarrito);
			$listaCarrito[$ultimaPos]["cancion"]= $_POST["producto"];
			$listaCarrito[$ultimaPos]["cantidad"]= $_POST["cantidad"];
			$precioCan=precioCancion($_POST["producto"]);
			$listaCarrito[$ultimaPos]["precio"]=$precioCan;
			setcookie("carrito", serialize($listaCarrito), time() + (86400 * 10), '/');
		
			echo "<p class='ok'><strong>Título agregado al carrito</strong></p><br><br>";
		} else {
			echo "<p class='error'>Debes seleccionar un producto</p>";
		}
	}
		
		
	//2º si se hace click en el input ver y si la cookie carrito no esta vacía (se muestra la tablaProductos y el precio total de estos)

	if(isset($_POST["ver"])){
		if(!empty($_COOKIE["carrito"])){
			tablaCanciones($listaCarrito);
			echo "<br>";
			//Se saca el precio total a pagar de los productos
			$totalPrecio=precioTitulo($listaCarrito);
			echo "<p class='mover2'>Total a pagar: <strong>$totalPrecio €</strong></p><br><br>";
			
			echo '<input class="btnvaciar" type="submit" name="vaciar" value="Vaciar carrito">
			</from>';
			echo "<br>";
			//echo "<label>Tarjeta de cr&eacute;dito</label> <input type='text' name='card' value=''>&nbsp;&nbsp;";
			echo '<input class="paga" type="submit" name="paga" value="Pago Seguro">';
		}else {
			echo "<p class='error'>No hay productos añadidos al carrito</p><br><br>";
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
	
	header("location:../views/login.php");
	}		
			
//Llamada a la vista, intermediario entre vista y modelo
require_once("../views/downmusic_view.php");
	
?>
