<?php 
//La lógica vendrá aquí, funciones que se comunican con la bbdd

//------------------------------------------------------------------------------------//

//CANCIONES
# Función 'listaCanciones'. 
# Parámetros: 
# 	
# Funcionalidad: Se prepara una consulta sql del Name y Composer de la tabla track 
# 
# Return: Devuelve todas las filas de la tabla track con el nombre y el composer
#
# Alex Santana
function listaCanciones(){
	global $conexion;
	$sql="SELECT Name, Composer FROM track ";
	$stmt=$conexion->prepare($sql);
	$stmt->execute();
	$listaM=$stmt->fetchAll(PDO::FETCH_ASSOC);
	return $listaM;
}


# Función 'tablaCanciones'. 
# Parámetros: $listaCarrito, serán los valores que se han agregado a la $_COOKIE["carrito"] para poder acceder a ellos más facilmente y hacer uso de ellos
# 	
# Funcionalidad: Obtener en formato tabla, el Name de la cancion, la cantidad que se haya seleccionado desde el select de algún título y el precio de cada título que se seleccione
# 
# Return: 
#
# Alex Santana
function tablaCanciones($listaCarrito){
		global $conexion;
        echo "<div class='mover1'><p class='titu'><strong class='titu'>Detalle de la Orden</strong></p>
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


# Función 'precioCancion'. 
# Parámetros: $tema, será el título o canción que se pase como parámetro para poder obtener el precio de este y poder almacenar el valor del precio en la $_COOKIE["carrito"]
# 	
# Funcionalidad: Obtener el precio de una canción o título en concreto que se haya seleccionado y agregado a la $_COOKIE["carrito"] 
# 
# Return: 
#
# Alex Santana
function precioCancion($tema){
	global $conexion;
	$sql="SELECT UnitPrice FROM track WHERE Name='$tema'";
	$stmt=$conexion->prepare($sql);
	$stmt->execute();
	$totalPrecio=$stmt->fetchColumn();
	return $totalPrecio;
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



# Función 'comprar'. 
# Parámetros: $price, será el precio total que se ha pagado por los productso almacenados en el carrito
# 	
# Funcionalidad: Conectar con la bbdd, obtener el formato de fecha y hora del sistema de la bbdd, generar una consulta sql para insertar una nueva orden en la tabla invoice, cogiendo el nº mayor de InvoiceId y sumar 1. Posteriormente se introducen los datos de la compra en la tabla invoice.
# 
# Return: 
#
# Alex Santana
function comprar($price){
	global $conexion;
	//$idUser=$_COOKIE["usuario"]; //Se utilizará más adelante
	//Fomato para la fecha del sistema
	$fecha=getdate()["year"]."-".getdate()["mon"]."-".getdate()["mday"];
	//Consulta para insertar los datos a la tabla invoice, sacar el mayor invoiceid, para poder crear una nueva orden con el siguiente nº
	$newOrder="SELECT max(InvoiceId) as mayor FROM invoice";
	$stmt=$conexion->prepare($newOrder);
	$stmt->execute();
	$totalOrder=$stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($totalOrder as $order){
		$orderNew=$order["mayor"]+1;
	}
	
	//Incluir datos de la compra
	$sqlOrder="INSERT INTO invoice values('$orderNew',12,'$fecha',null,null,null,null,null,'$price')";
	$conexion->exec($sqlOrder);
}



function factura(){
	global $conexion;
	$newOrder="SELECT max(InvoiceId) as mayor FROM invoice";
	$stmt=$conexion->prepare($newOrder);
	$stmt->execute();
	$totalOrder=$stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($totalOrder as $order){
		$orderNew=$order["mayor"]+1;
	}
	return $orderNew;
}





?>
