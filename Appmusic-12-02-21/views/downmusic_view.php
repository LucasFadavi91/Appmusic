<!--Alex Santana-->
<?php
	require_once("../db/db.php");
    include_once("../controllers/downmusic_controller.php");
?>
<!doctype html>
<html lang="es">
<head> 
<title>Comprar productos</title>
<meta charset="utf-8" />
<style type="text/css">
	table {border-collapse: collapse;}
	th, td {border: 1px solid #dddddd;
			width:40%;
			text-align:center;}
		.error{
	color:red;
	}
	.tit{
		position:relative;
		right: 165px;
	}
	
	.mover{
		//float:right;
		position:relative;
		bottom:39px;
		margin-left:202px;
	}
</style>
</head>

<body>

	<h1>Realizar Pedidos</h1>
	<!--<?php echo "<h2>Usuario: ".$_SESSION["usuario"]."</h2>";?>-->
	
	<form name"prueba" action="<?php echo $_SERVER['PHP_SELF']; ?> " method="post">
		
			Título  <select name="producto">
					<option>--Selecciona una canción--</option>
					<?php
						//Se lista los nombres de las canciones  en un select
						foreach($musica as $lista){
                            echo "<option value='".$lista['Name']."'>".$lista['Name']." - ".$lista['Composer']."</option>";
                        }
					?>
					</select>&nbsp;&nbsp&nbsp<br><br>
					<label>Cantidad</label>
					<input type="number" name="cantidad" placeholder="Cantidad" value="1"><br><br>
					<input type="submit" name="agregar" value="Añadir al carrito">
					<input type="submit" name="ver" value="Finalizar compra">
					<input class="" type="submit" name="vaciar" value="Vaciar carrito">
					<input class="" type="submit" name="pagar" id="pagar" value="Paga!">
					<br><br>
	<div>
	</div>
	</form>
	<a href="../controllers/logout.php"><input type="button" value="Cerrar Sesi&oacute;n"></a>	
</body>

</html>

