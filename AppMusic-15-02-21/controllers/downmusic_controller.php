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

.exito{
	color:green;
	position:absolute;
	
	top:29%;
	
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
			//Visualizo la tabla 
			tablaCanciones($listaCarrito);
			echo "<br>";
			//Se saca el precio total a pagar de los productos
			$totalPrecio=precioTitulo($listaCarrito);
			echo "<p class='mover2'>Total a pagar: <strong>$totalPrecio €</strong></p><br><br>";
			
			echo '<input class="btnvaciar" type="submit" name="vaciar" value="Vaciar carrito">
			</from>';
			echo "<br>";
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
	if(isset($_POST["paga"])){
		if(!empty($_COOKIE["carrito"])){
			//Obtengo el id del usuario
			$userId=$_COOKIE["user"];
			$cancionPrice=precioTitulo($listaCarrito);
			comprar($cancionPrice, $userId);
			echo "<p class='exito'><strong>Compra realizada con exito!</strong></p>";
			//Se reinicia el carrito
			setcookie("carrito", serialize($listaCarrito), time() + (-86400 * 10), '/');
		} else{
			echo "<p class='error'>No has agregado ningún artículo al carrito</p>";
		}
	}
	
	//Cerrar sesion
	if(isset($_POST["cerrar"])){
		//echo "Bien!";
		//setcookie("carrito", serialize($listaCarrito), time() + (0), '/');
		setcookie("carrito", serialize($listaCarrito), time() - (86400 * 10), '/');
		
		//unset($_COOKIE["carrito"]);
	}
} else{ //Si no existe la $_COOKIE["usuario"], es decir el usuario no esta logeado, volverá a la pág de login.php para logearse
		header("location:../index.php");
		
	}		
	

//Llamada a la vista, intermediario entre vista y modelo
require_once("../views/downmusic_view.php");
	
	
	
	
	
//---------------------------------FUNCIONES------------------------------------///
# Función 'tablaCanciones'. 
# Parámetros: $listaCarrito, serán los valores que se han agregado a la $_COOKIE["carrito"] para poder acceder a ellos más facilmente y hacer uso de ellos
# 	
# Funcionalidad: Obtener en formato tabla, el Name de la cancion, la cantidad que se haya seleccionado desde el select de algún título y el precio de cada título que se seleccione
# 
# Return: 
#
# Alex Santana
function tablaCanciones($listaCarrito){
		//Llamo a la funcion ObtenerOrden() y Obtengo el nº del pedido
		$numOrden=obtenerOrden();
		
        echo "<div class='mover1'><p class='titu'><strong class='titu'>Detalle de la Orden: $numOrden</strong></p>
            <table> 
                <tr>
                    <th>Título</th>
                    <th>Cantidad</th>
					<th>Precio por unidad</th>
                </tr>";

        foreach($listaCarrito as $value){
            echo "<tr>";
            echo "<td> ".$value["cancion"]. "</td>";
            echo "<td>".$value["cantidad"]."</td>";	
			echo "<td>".$value["precio"]."</td>";			
            echo "</tr>";
        }
        echo "</table></div>";
}

	
# Función 'precioTitulo'. 
# Parámetros: $listaCarrito array de la $_COOKIE["carrito"], la cual se accede para poder recorrerlo y poder sacar el valor de la cantidad y el precio para poder obtener el precio total a pagar de los productos que se hayan almacenado en el carrito de la compra
# 	
# Funcionalidad: Desiarilizar el array $listaCarrito de $_COOKIE["carrito"] para poder recorrer el array 
# 
# Return: Devuelto el precio total a pagar 
#
# Alex Santana
function precioTitulo($listaCarrito){
	$totalPrecio=0;
	foreach ($listaCarrito as $key => $value) {
		$totalPrecio=$totalPrecio+($value["cantidad"]*$value["precio"]);
	}
	return $totalPrecio;
}
?>
