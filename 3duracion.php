<?php
/*

3.- Mediante una tarea programada por las noches se hace una llamada a una URI de PROVEEDOR, para reportar cada duración 
de llamada por "idoportunidad". Esta Uri es un wbservice al que se le envía por System.Net.HttpWebRequest 
un JSON, ejemplo:

{"id_oportunidad":"abcdef12345678", "duracion":"348", "id_operador":"logindeloperador", "fecha":"2022-10-10 10:31:24"}

Cada cada campaña tiene su propia especificación.
*/
<?php
requiere "base.php";
// Configuración de conexión a MySQL


try {
    

    
    $sql = "SELECT id_oportunidad, duracion, id_operador, fecha FROM llamadas";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    
    $llamadas = $stmt->fetchAll(PDO::FETCH_ASSOC);

   
    foreach ($llamadas as $llamada) {
        // Convertir el resultado en JSON
        $data = json_encode([
            'id_oportunidad' => $llamada['id_oportunidad'],
            'duracion' => $llamada['duracion'],
            'id_operador' => $llamada['id_operador'],
            'fecha' => $llamada['fecha']
        ]);

       
        $url = "https://proveedor.com/api/duracion";
        $ch = curl_init($url);

        // Configurar la solicitud cURL
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);

        
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error en cURL: ' . curl_error($ch) . "\n";
        } else {
            echo 'Respuesta de la API para id_oportunidad ' . $llamada['id_oportunidad'] . ': ' . $response . "\n";
        }

        // Cerrar la conexión cURL
        curl_close($ch);
    }

} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>
