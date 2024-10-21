<?php
/*
2.- Para reportar el estado de un registro cerrado, por idoportunidad, 
se hace una llamada en el momento del cierre por el script para que sea lo más inmediato posible,
a una URI de PROVEEDOR. Esta Uri es un servicio web al que se le envía por 
System.Net.HttpWebRequest un Json formado por el "idoportunidad" y el código de "final" con el que se cerró el registro.
Ejemplo:

{"id_oportunidad":"abcdef12345678","descripcion":"9991"}

Cada campaña tiene su propia especificación. 
*/


$id_oportunidad = 'abcdef12345678';
$descripcion = '9991';  

$data = json_encode([
    'id_oportunidad' => $id_oportunidad,
    'descripcion' => $descripcion
]);

$url = "https://proveedor.com/api/cierre";  // URL del proveedor

// Inicia cURL
$ch = curl_init($url);

// Configura las opciones de cURL
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data)
]);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    echo 'Respuesta del servicio: ' . $response;
}

curl_close($ch);
?>
