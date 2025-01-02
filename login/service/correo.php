<?php

// El mensaje
/*$mensaje = "Línea 1\r\nLínea 2\r\nLínea 3";

// Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
$mensaje = wordwrap($mensaje, 70, "\r\n");

// Enviarlo
mail('cesarinfo10@gmail.com', 'Mi título', $mensaje);*/

if (isset($_GET['correoRecupera'])){

    $para      = 'cesarinfo10@gmail.com';
    $titulo    = 'El título2';
    $mensaje   = 'Holasssss';
    $cabeceras = 'From: www-data@matriculate.unc.cl' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    
    mail($para, $titulo, $mensaje, $cabeceras);
}