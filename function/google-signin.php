<?php
require_once '../vendor/autoload.php';

$client = new Google_Client(['client_id' => '702303678845-g6o0hnvkosrrhsapc0qnj944ujgl9cuu.apps.googleusercontent.com']);  // Reemplaza YOUR_CLIENT_ID con tu ID de cliente de Google
$token = json_decode(file_get_contents('php://input'))->token;

try {
    $payload = $client->verifyIdToken($token);
    if ($payload) {
        
        $userid = $payload['sub'];
        $email = $payload['email'];
        $family_name = $payload['family_name'];
        $given_name = $payload['given_name'];

        echo json_encode([
            'success' => true,
            'userid' => $userid,
            'email' => $email,
            'family_name' => $family_name,
            'given_name' => $given_name
        ]);
    } else {
        // Token inválido
        echo json_encode(['success' => false]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>