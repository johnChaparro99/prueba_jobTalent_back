<?php 
include ('../conexion/conectar.php');
include('../model/mdl_clima.php');


$accion = $_POST['accion'];

switch ($accion) {
	case 'insertarDatos':
		insertarDatos();
		break;
	
}

function insertarDatos(){
	$Clima = new Clima;

	$ciudad = $_POST['ciudad'];
	$key = 95482393b6cfb9f5ac37e371e8ebcb5d;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://api.openweathermap.org/geo/1.0/direct?q=".$ciudad."&limit=5&appid=".$key);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$res = curl_exec($ch);

	$latitud = $res[0]->lat;
	$longitud = $res[0]->lon;
	
	curl_close($ch);

	$ch2 = curl_init();
	curl_setopt($ch2, CURLOPT_URL, "https://api.openweathermap.org/data/2.5/weather?lat=".$latitud."&lon=".$longitud."&appid=".$key);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
	$res2 = curl_exec($ch2);

	$temperatura = $res["weather"]["description"];
	$descripcion_clima = $res["main"]["temp"];
	$humedad = $res["main"]["humidity"];
	$velocidad_viento = $res["wind"]["speed"];
	
	curl_close($ch2);

	$datos = json_decode($Clima->insertarDatos($ciudad,$temperatura,$descripcion_clima,$humedad,$velocidad_viento));
	$respuesta = array();

	//var_dump($datos->data);
	if ($datos->success) {
		$respuesta['success'] = true;
		$respuesta['message'] = $datos->message;
	} else {
		$respuesta['success'] = false;
		$respuesta['message'] = $datos->message;
	}

	echo json_encode($respuesta);
}




?>