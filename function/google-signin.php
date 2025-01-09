<?php
require_once '../vendor/autoload.php';
include('conexion.php');

$client = new Google_Client(['client_id' => '702303678845-g6o0hnvkosrrhsapc0qnj944ujgl9cuu.apps.googleusercontent.com']);  // Reemplaza YOUR_CLIENT_ID con tu ID de cliente de Google
$token = json_decode(file_get_contents('php://input'))->token;

try {
    $payload = $client->verifyIdToken($token);
    if ($payload) {
        
        $email = 'isaachuaiquil.tts@gmail.com';//
       // $email= $payload['email'];
;
        $dbconn = db_connect();

        header('Content-type:application/json');
      
        $cod_jornada = $_GET['cod_jornada'];
        $cod_carrera = $_GET['cod_carrera'];
      
        $query = "SELECT email FROM public.alumnos where email = '".$email."'";
        $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
        $row = pg_fetch_row($result);
        
       
        echo json_encode($row);
    } else {
        // Token inválido
        echo json_encode(['success' => false]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>