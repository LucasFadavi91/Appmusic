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
	table {border-collapse: collapse;
		}
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
	
	.mover1{
		position:absolute;
		margin-left:30%;
		top:45%;
		//display: flex;
  
	}
	.menu{
		//border:1px dashed red;
		position:absolute;
		bottom:70%;
		//text-align: center;
	}
	.cerrar{
		position:absolute;
		//margin-left:30%;
		top:95%;
	}
	.titu{
		color:blue;
		text-align:center;
		
	}
	
	.volver{
		position:absolute;
		top:-29.9px;
		margin-left:3px;
	}
	
</style>
   
</head>

<body>
<div class="menu">
	<h1>Realizar Pedidos</h1>
	<!--<?php echo "<h2>Usuario: ".$_SESSION["usuario"]."</h2>";?>-->
	
	<form  name"prueba" action="<?php echo $_SERVER['PHP_SELF']; ?> " method="post">
		
			Título  <select name="producto">
					<option value="0">--Selecciona una canción--</option>
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
					<a href="menu.php" class="cerrar"><input type="button" value="Volver al menú" class="volver"></a>
					<br><br>
	</form>
</div>
	<form name"cerrar" action="<?php echo $_SERVER['PHP_SELF']; ?> " method="post">
	<input type="submit" class="cerrar" name="cerrar" value="Cerrar Sesi&oacute;n">
	</form>
</body>
</html>

