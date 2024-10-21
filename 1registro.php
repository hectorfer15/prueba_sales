<?php

/*
1.- PROVEEDOR envía el registro al servicio web de SALESLAND_LEADS (descrito en SERVICIO DE RECEPCION DE CAPTURA DE CLIENTES.pdf)
con el parámetro idoportunidad especificado en el campo "memo". El contenido del campo "memo" es un JSON que contiene que 
depende la campaña como tal y puede contener más parámetros además de "idoportunidad". 
Esto depende de cómo defina Increnta los datos que envían, para cada campaña.

*/

    
$memo = json_encode([
    'idoportunidad' => 'abcdef12345678',
    'parametro_extra' => 'valor',
    'campana' => '1',
    'telefono'=>'600000003'
    
]);

$url = "https://webapp.salesland.net:8095/WS_SALESLAND_LEADS/SALESLAND_LEADSCmb.svc/AltaLead";  // URL del servicio web

// Inicia cURL
$ch = curl_init($url);

// Configura las opciones de cURL
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $memo);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($memo)
]);

// Ejecuta la solicitud y obtiene la respuesta
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    echo 'Respuesta del servicio: ' . $response;
}

// Cierra la sesión cURL
curl_close($ch);
?>
