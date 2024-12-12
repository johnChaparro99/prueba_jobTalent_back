<?php
class Clima {

	function insertarDatos($ciudad,$temperatura,$descripcion_clima,$humedad,$velocidad_viento){
		$conexion = f_conectar();

		$sql = "INSERT INTO pais(nombre_pais) VALUES ('$ciudad')";


		if(mysqli_query($conexion,$sql))
		{
			$respuesta['success'] = true;
			$respuesta['message'] = "registro insertado";
		}
		else
		{
			$respuesta['success'] = false;
			$respuesta['message'] = "error insertando: ".$sql.mysqli_error($conexion);
		}
		mysqli_close($conexion);
		//var_dump($respuesta);
		return json_encode($respuesta);
	}

}


?>