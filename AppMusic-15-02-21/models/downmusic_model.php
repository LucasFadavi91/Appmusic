
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
	$sql="SELECT TrackId, Name, Composer FROM track ";
	$stmt=$conexion->prepare($sql);
	$stmt->execute();
	$listaM=$stmt->fetchAll(PDO::FETCH_ASSOC);
	return $listaM;
}




# Función 'precioCancion'. 
# Parámetros: $tema, será el título o canción que se pase como parámetro para poder obtener el precio de este y poder almacenar el valor del precio en la $_COOKIE["carrito"]
# 	
# Funcionalidad: Obtener el precio de una canción o título en concreto que se haya seleccionado y agregado a la $_COOKIE["carrito"] 
# 
# Return: 
#
# Alex Santana
function precioCancion($trackId){
	global $conexion;
	$sql="SELECT UnitPrice FROM track WHERE TrackId='$trackId'";
	$stmt=$conexion->prepare($sql);
	$stmt->execute();
	$totalPrecio=$stmt->fetchColumn();
	return $totalPrecio;
}





# Función 'ObtenerOrden'. 
# Parámetros: 
# 	
# Funcionalidad: Conectar con la bbdd, obtener el InvoiceId max y crear uno nuevo
# 
# Return: devuelve un nuevo nº de orden
#
# Alex Santana
function obtenerOrden(){
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

# Función 'comprar'. 
# Parámetros: $price, será el precio total que se ha pagado por los productso almacenados en el carrito
# 	
# Funcionalidad: Conectar con la bbdd, obtener el formato de fecha y hora del sistema de la bbdd, generar una consulta sql para insertar una nueva orden en la tabla invoice, cogiendo el nº mayor de InvoiceId y sumar 1. Posteriormente se introducen los datos de la compra en la tabla invoice.
# 
# Return: 
#
# Alex Santana
function comprar($userId, $price){
	global $conexion;
	//Fomato para la fecha del sistema
	$fecha=getdate()['year']."-".getdate()['mon']."-".getdate()['mday']." ".getDate()['hours'].":".getDate()['minutes'].":".getDate()['seconds'];
	//Obtener el invoiceid de la funcion obtenerOrden
	$invoiceid=obtenerOrden();
	
	//Obtener los datos de la tabla customer para posteriormente añadirlos a la tabla invoice
	$sql="SELECT Address FROM Customer WHERE CustomerId='$userId'";
	$stmt=$conexion->prepare($sql);
	$stmt->execute();
	$BillingAddress=$stmt->fetchColumn();
	
	$sql2="SELECT City FROM Customer WHERE CustomerId='$userId'";
	$stmt=$conexion->prepare($sql2);
	$stmt->execute();
	$BillingCity=$stmt->fetchColumn();
	
	$sql3="SELECT State FROM Customer WHERE CustomerId='$userId'";
	$stmt=$conexion->prepare($sql3);
	$stmt->execute();
	$BillingState=$stmt->fetchColumn();
	
	$sql4="SELECT Country FROM Customer WHERE CustomerId='$userId'";
	$stmt=$conexion->prepare($sql4);
	$stmt->execute();
	$BillingCountry=$stmt->fetchColumn();
	
	$sql5="SELECT PostalCode FROM Customer WHERE CustomerId='$userId'";
	$stmt=$conexion->prepare($sql5);
	$stmt->execute();
	$BillingPostalCode=$stmt->fetchColumn();
	
	//Incluir los datos a la tabla invoice
	$sqlOrder="INSERT INTO invoice values('$invoiceid','$userId','$fecha','$BillingAddress', '$BillingCity', '$BillingState', '$BillingCountry', '$BillingPostalCode','$price')";
	$conexion->exec($sqlOrder);

	return $invoiceid;
}

function trackId(){
	global $conexion;
	$sql="SELECT TrackId FROM track";
	$stmt=$conexion->prepare($sql);
	$stmt->execute();
	$listaM=$stmt->fetchColumn();
	return $listaM;
}




function insertarInvoiceLine($idInvoice, $trackId){
	global $conexion;
	//Obtener nuevo InvoiceLineId
	$newNumInvoiceLine="SELECT max(InvoiceLineId) as mayor2 FROM invoiceline";
	$stmt=$conexion->prepare($newNumInvoiceLine);
	$stmt->execute();
	$NewNum=$stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($NewNum as $order2){
		$orderNewLine=$order2["mayor2"]+1;
	}
	 
	$sql="SELECT UnitPrice FROM track WHERE TrackId='$trackId'";
	$stmt=$conexion->prepare($sql);
	$stmt->execute();
	$precio=$stmt->fetchColumn();
	
	$newInvoiceLine="INSERT INTO invoiceline values('$orderNewLine', '$idInvoice', '$trackId', '$precio', '1')";
	$conexion->exec($newInvoiceLine);
}



/*
function factura(){
	global $conexion;
	$newOrder="SELECT max(InvoiceId) as mayor FROM invoiceline";
	$stmt=$conexion->prepare($newOrder);
	$stmt->execute();
	$totalOrder=$stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($totalOrder as $order){
		$orderNew=$order["mayor"]+1;
	}
	return $orderNew;
}*/





?>
