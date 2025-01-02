<?php

//require '../../../vendor/autoload.php';
require '../../../../../vendor/autoload.php';
/*
|--------------------------------------------------------------------------
| Inicializamos el objeto Transaction
|--------------------------------------------------------------------------
*/
$transaction = new \Transbank\Webpay\WebpayPlus\Transaction();

// Por simplicidad de este ejemplo, este es nuestro "controlador" que define que vamos a hacer dependiendo del parametro ?action= de la URL.
$action = $_GET['action'] ?? null;
if (!$action) {
    exit('Debe indicar la acción a realizar');
}

/*
|--------------------------------------------------------------------------
| Crear transacción
|--------------------------------------------------------------------------
/ Apenas entramos esta página, con fines demostrativos,
*/
 if ($_GET['action'] === 'create') {
    date_default_timezone_set("America/Santiago");
    $fcha = date("Y-m-d");

    $monto = $_GET['monto'];
// igualar el valor de la variable JavaScript a PHP
    $Order = $_GET['rut'].'_'.$fcha;

    // QA: $createResponse = $transaction->create('buyOrder123', uniqid(), $monto, 'http://10.111.1.88/sgu/MatriculaOnline/transbank/vendor/transbank/transbank-sdk/examples/webpay-plus/index.php?action=result');
    // Desarrollo: $createResponse = $transaction->create('buyOrder123', uniqid(), $monto, 'http://localhost/MatriculaOnline/transbank/vendor/transbank/transbank-sdk/examples/webpay-plus/index.php?action=result');
        $createResponse = $transaction->create($Order, uniqid(), $monto, 'https://matriculate.umc.cl/sgu/MatriculaOnline/transbank/vendor/transbank/transbank-sdk/examples/webpay-plus/index.php?action=result');
    // Acá guardar el token recibido ($createResponse->getToken()) en tu base de datos asociado a la orden o
    // lo que se esté pagando en tu sistema

    //Redirigimos al formulario de Webpay por GET, enviando a la URL recibida con el token recibido.
    $redirectUrl = $createResponse->getUrl().'?token_ws='.$createResponse->getToken();
    header('Location: '.$redirectUrl, true, 302);
    exit;
}
/*
|--------------------------------------------------------------------------
| Confirmar transacción
|--------------------------------------------------------------------------
/ Esto se debería ejecutar cuando el usario finaliza el proceso de pago en el formulario de webpay.
*/
if ($_GET['action'] === 'result') {
    if (userAbortedOnWebpayForm()) {
        cancelOrder();
        exit('Has cancelado la transacción en el formulario de pago. Intenta nuevamente');
    }
    if (anErrorOcurredOnWebpayForm()) {
        cancelOrder();
        exit('Al parecer ocurrió un error en el formulario de pago. Intenta nuevamente');
    }
    if (theUserWasRedirectedBecauseWasIdleFor10MinutesOnWebapayForm()) {
        cancelOrder();
        exit('Superaste el tiempo máximo que puedes estar en el formulario de pago (10 minutos). La transacción fue cancelada por Webpay. ');
    }
    //Por último, verificamos que solo tengamos un token_ws. Si no es así, es porque algo extraño ocurre.
    if (!isANormalPaymentFlow()) { // Notar que dice ! al principio.
        cancelOrder();
        exit('En este punto, si NO es un flujo de pago normal es porque hay algo extraño y es mejor abortar. Quizás alguien intenta llamar a esta URL directamente o algo así...');
    }

    // Acá ya estamos seguros de que tenemos un flujo de pago normal. Si no, habría "muerto" en los checks anteriores.
    $token = $_GET['token_ws'] ?? $_POST['token_ws'] ?? null; // Obtener el token de un flujo normal
    $response = $transaction->commit($token);

    if ($response->isApproved()) {
        //Si el pago está aprobado (responseCode == 0 && status === 'AUTHORIZED') entonces aprobamos nuestra compra
        // Código para aprobar compra acá
        approveOrder($response);
    } else {
        cancelOrder();
    }

    return;
}

function cancelOrder($response = null)
{
    // Acá has lo que tangas que hacer para marcar la orden como fallida o cancelada
    if ($response) {
        //echo '<pre>'.print_r($response, true).'</pre>';
    }else{

        echo
        '<!DOCTYPE html>
      <html lang="en">
      <head>
        <title>Pago</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
      </head>
      <div style="height:30px !important;background-color: #014289;">
      </div>
      <body>
      <div class="jumbotron text-center" style="height: 200px !important; ">
      <img src="../../../../../../login/assets/img/logo-universidad-miguel-de-cervantes-umc_sesion.png" alt="LOGO">
        <h1>La orden ha sido RECHAZADA</h1>
        <p>El pago fue rechazado sin embargo el contrato generó correctamente, por favor, descargue el contrato antes de salir de la página.</p>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-sm-12">

            <img src="https://matriculate.umc.cl/sgu/MatriculaOnline/assets/img/cabezera.PNG" class="rounded" alt="Cinque Terre" width="100%" height="100%">

          </div>
          </div>
          <div class="row">
          <div class="col-sm-3"></div>
          <div class="col-sm-6 text-center">
          <br>
          <button class="btn btn-info" onclick="imprimirContrato();">Descargar Contrato</button>
          <button class="btn btn-info" id="pagareImp" onclick="imprimirPagare();">Descargar Pagare</button>
          <button class="btn btn-danger" onclick="borrarSalir();">Salir</button>
          <p>
          <strong> Para finalizar el proceso, debes enviarnos el contrato (que descargaste cuando terminaste tu matrícula en línea) firmado por correo electrónico a matriculaonline@corp.umc.cl
        <br/>
        <br/>
          Para insertar tu firma en el contrato y/o pagaré, te recomendamos seguir el siguiente instructivo:<br/>
          https://helpx.adobe.com/cl/reader/using/sign-pdfs.html#:~:text=Pasos%20para%20firmar%20un%20PDF,firmar%20en%20el%20panel%20derecho.<br/>
          Nos comunicaremos contigo a la brevedad para darte la bienvenida y comenzar a remitir la información de acceso a nuestras plataformas.
          <br/>
          <br/>
          ENRIQUE MAC IVER 370, SANTIAGO DE CHILE.<br/>
            UNIVERSIDAD MIGUEL DE CERVANTES. TODOS LOS DERECHOS RESERVADOS.<br/>
            CONTÁCTANOS +56 229273401/ 229273402
          </strong>
          <p>
          </div>
          <div class="col-sm-3"></div>
        </div>
      </div>

      </body>
      </html>';
    }
  //  echo 'La orden ha sido RECHAZADA';
?>
<script>

window.onload=function() {

if (localStorage.getItem('idPagare') == ''||localStorage.getItem('idPagare') == 'null' || localStorage.getItem('idPagare') == undefined){
    let clock = setInterval(() => {
    clearInterval(clock)
    clock = null
    document.getElementById('pagareImp').style.display = 'none'
}, 100)
    }
}
/*=============================================
UPDATE PAGOS
=============================================*/
setTimeout(() => {

let dataString = {
    rut: localStorage.getItem('rut'),
    comentarios: 'La orden ha sido RECHAZADA'
};

// fetch("http://localhost/MatriculaOnline/function/funcionUpdate.php?postUpdatePago",{
fetch("https://matriculate.umc.cl/sgu/MatriculaOnline/function/funcionUpdate.php?postUpdatePago",{
    method:'POST',
    body:JSON.stringify(dataString),
    headers: {
        'Content-Type':'application/json'
    }
})
.then(console.log)
.catch(console.error);

}, "1000");

/*=============================================
                CORREO
=============================================*/

setTimeout(() => {
    let correo =localStorage.getItem('email');
    let nombre =localStorage.getItem('nombre');
    let apellido =localStorage.getItem('apellido');
    let carrera =localStorage.getItem('carrera');

    let amount =  "<?php echo $response->amount; ?>"

    let monto = new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(amount);
    let dataString = {
        correo: correo,
        mensaje:"El pago no ha sido finalizado.<br/><br>"
                +"Gracias "+nombre+" "+apellido+", por matricularte en la UMC en la carrera "+carrera+".<br/>"
                +"Para finalizar el proceso, debes enviarnos el contrato (que descargaste cuando terminaste tu matrícula en línea) firmado por correo electrónico a matriculaonline@corp.umc.cl<br/><br>"
                +"Para insertar tu firma en el contrato y/o pagaré, te recomendamos seguir el siguiente instructivo:<br/>"
                +"https://helpx.adobe.com/cl/reader/using/sign-pdfs.html#:~:text=Pasos%20para%20firmar%20un%20PDF,firmar%20en%20el%20panel%20derecho.<br/>"
                +"Nos comunicaremos contigo a la brevedad para darte la bienvenida y comenzar a remitir la información de acceso a nuestras plataformas."
    };

    fetch("https://matriculate.umc.cl/sgu/MatriculaOnline/correo.php",{
        method:'POST',
        body:JSON.stringify(dataString),
        headers: {
            'Content-Type':'application/json'
        }
    })
    .then(console.log)
    .catch(console.error);

    }, "1000");

    function imprimirContrato(){
    let idContrato= localStorage.getItem('idContrato');
    location.href="https://sgu.umc.cl/sgu/contrato.php?id_contrato="+idContrato+"&tipo=al_nuevo";
}
function imprimirPagare(){
    let idPagare= localStorage.getItem('idPagare');
    location.href="https://sgu.umc.cl/sgu/pagare_colegiatura.php?id_pagare_colegiatura="+idPagare+"&tipo=al_nuevo";
}
function borrarSalir(){
    localStorage.clear();
    location.href="https://matriculate.umc.cl/";
}

</script>
<?php
}
function approveOrder($response)
{
    // Acá has lo que tangas que hacer para marcar la orden como aprobada o finalizada o lo que necesites en tu negocio.,
   // echo '<p style="text-align: center">El pago a la matricula  a sido APROBADA</p>';
  //  echo '<pre>'.print_r($response, true).'</pre>';
   echo
  '<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pago</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<div style="height:30px !important;background-color: #014289;">
</div>
<body>
<div class="jumbotron text-center" style="height: 200px !important; ">
<img src="../../../../../../login/assets/img/logo-universidad-miguel-de-cervantes-umc_sesion.png" alt="LOGO">
  <h1>El pago ha sido APROBADO</h1>
  <p>Por favor, descargue el contrato antes de salir de la pagina</p>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-12">

      <img src="https://matriculate.umc.cl/sgu/MatriculaOnline/assets/img/cabezera.PNG" class="rounded" alt="Cinque Terre" width="100%" height="100%">

    </div>
    </div>
    <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6 text-center">
    <br>
    <button class="btn btn-info" onclick="imprimirContrato();">Descargar Contrato</button>
    <button class="btn btn-info" id="pagareImp" onclick="imprimirPagare();">Descargar Pagare</button>
    <button class="btn btn-danger" onclick="borrarSalir();">Salir</button>
    <br>
      <strong>  Descargar contrato y enviar con firma ante notario a la casilla
        carias@corp.umc.cl </strong>
    </div>
    <div class="col-sm-3"></div>
  </div>
</div>

</body>
</html>';

    $a = ('vci: '.$response->vci.' | status: '.$response->status
          .' | responseCode: '.$response->responseCode.' | amount: '.$response->amount
          .' | authorizationCode: '.$response->authorizationCode.' | paymentTypeCode: '.$response->paymentTypeCode
          .' | accountingDate: '.$response->accountingDate.' | installmentsNumber: '.$response->installmentsNumber
          .' | installmentsAmount: '.$response->installmentsAmount.' | installmentsAmount: '.$response->installmentsAmount
          .' | buyOrder: '.$response->buyOrder.' | cardNumber: '.$response->cardNumber
          .' | cardDetail: '.$response->cardDetail['card_number']);


   ?>
   <script>
    window.onload=function() {

    if (localStorage.getItem('idPagare') == ''||localStorage.getItem('idPagare') == 'null' || localStorage.getItem('idPagare') == undefined){
        let clock = setInterval(() => {
        clearInterval(clock)
        clock = null
        document.getElementById('pagareImp').style.display = 'none'
    }, 100)
        }
	}
/*=============================================
 INSERT PAGOS TBL
=============================================*/

//EN DESARROLLO

/*=============================================
UPDATE PAGOS
=============================================*/
   setTimeout(() => {

        let dataString = {
            rut: localStorage.getItem('rut'),
            comentarios:  "<?php echo $a; ?>"
        };

       // fetch("http://localhost/MatriculaOnline/function/funcionUpdate.php?postUpdatePago",{
        fetch("https://matriculate.umc.cl/sgu/MatriculaOnline/function/funcionUpdate.php?postUpdatePago",{
            method:'POST',
            body:JSON.stringify(dataString),
            headers: {
                'Content-Type':'application/json'
            }
        })
        .then(console.log)
        .catch(console.error);

}, "1000");
/*=============================================
                CORREO
=============================================*/
    setTimeout(() => {
    let correo =localStorage.getItem('email');
    let nombre =localStorage.getItem('nombre');
    let apellido =localStorage.getItem('apellido');
    let carrera =localStorage.getItem('carrera');

    let amount =  "<?php echo $response->amount; ?>"

    let monto = new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(amount);
    let dataString = {
        correo: correo,
        mensaje: "Gracias "+nombre+" "+apellido+", por matricularte en la UMC en la carrera "+carrera+".<br/>"
                +"Para finalizar el proceso, debes enviarnos el contrato (que descargaste cuando terminaste tu matrícula en línea) firmado por correo electrónico a matriculaonline@corp.umc.cl<br/><br>"
                +"Para insertar tu firma en el contrato y/o pagaré, te recomendamos seguir el siguiente instructivo:<br/>"
                +"https://helpx.adobe.com/cl/reader/using/sign-pdfs.html#:~:text=Pasos%20para%20firmar%20un%20PDF,firmar%20en%20el%20panel%20derecho.<br/>"
                +"Nos comunicaremos contigo a la brevedad para darte la bienvenida y comenzar a remitir la información de acceso a nuestras plataformas."
    };

    fetch("https://matriculate.umc.cl/sgu/MatriculaOnline/correo.php",{
        method:'POST',
        body:JSON.stringify(dataString),
        headers: {
            'Content-Type':'application/json'
        }
    })
    .then(console.log)
    .catch(console.error);

    }, "1000");

function imprimirContrato(){
    let idContrato= localStorage.getItem('idContrato');
    location.href="https://sgu.umc.cl/sgu/contrato.php?id_contrato="+idContrato+"&tipo=al_nuevo";
}
function imprimirPagare(){
    let idPagare= localStorage.getItem('idPagare');
    location.href="https://sgu.umc.cl/sgu/pagare_colegiatura.php?id_pagare_colegiatura="+idPagare+"&tipo=al_nuevo";
}
function borrarSalir(){
    localStorage.clear();
    location.href="https://matriculate.umc.cl/";
}
    </script>
<?php
}

function userAbortedOnWebpayForm()
{
    $tokenWs = $_GET['token_ws'] ?? $_POST['token_ws'] ?? null;
    $tbkToken = $_GET['TBK_TOKEN'] ?? $_POST['TBK_TOKEN'] ?? null;
    $ordenCompra = $_GET['TBK_ORDEN_COMPRA'] ?? $_POST['TBK_ORDEN_COMPRA'] ?? null;
    $idSesion = $_GET['TBK_ID_SESION'] ?? $_POST['TBK_ID_SESION'] ?? null;

    // Si viene TBK_TOKEN, TBK_ORDEN_COMPRA y TBK_ID_SESION es porque el usuario abortó el pago
    return $tbkToken && $ordenCompra && $idSesion && !$tokenWs;
}

function anErrorOcurredOnWebpayForm()
{
    $tokenWs = $_GET['token_ws'] ?? $_POST['token_ws'] ?? null;
    $tbkToken = $_GET['TBK_TOKEN'] ?? $_POST['TBK_TOKEN'] ?? null;
    $ordenCompra = $_GET['TBK_ORDEN_COMPRA'] ?? $_POST['TBK_ORDEN_COMPRA'] ?? null;
    $idSesion = $_GET['TBK_ID_SESION'] ?? $_POST['TBK_ID_SESION'] ?? null;

    // Si viene token_ws, TBK_TOKEN, TBK_ORDEN_COMPRA y TBK_ID_SESION es porque ocurrió un error en el formulario de pago
    return $tokenWs && $ordenCompra && $idSesion && $tbkToken;
}

function theUserWasRedirectedBecauseWasIdleFor10MinutesOnWebapayForm()
{
    $tokenWs = $_GET['token_ws'] ?? $_POST['token_ws'] ?? null;
    $tbkToken = $_GET['TBK_TOKEN'] ?? $_POST['TBK_TOKEN'] ?? null;
    $ordenCompra = $_GET['TBK_ORDEN_COMPRA'] ?? $_POST['TBK_ORDEN_COMPRA'] ?? null;
    $idSesion = $_GET['TBK_ID_SESION'] ?? $_POST['TBK_ID_SESION'] ?? null;

    // Si viene solo TBK_ORDEN_COMPRA y TBK_ID_SESION es porque el usuario estuvo 10 minutos sin hacer nada en el
    // formulario de pago y se canceló la transacción automáticamente (por timeout)
    return $ordenCompra && $idSesion && !$tokenWs && !$tbkToken;
}

function isANormalPaymentFlow()
{
    $tokenWs = $_GET['token_ws'] ?? $_POST['token_ws'] ?? null;
    $tbkToken = $_GET['TBK_TOKEN'] ?? $_POST['TBK_TOKEN'] ?? null;
    $ordenCompra = $_GET['TBK_ORDEN_COMPRA'] ?? $_POST['TBK_ORDEN_COMPRA'] ?? null;
    $idSesion = $_GET['TBK_ID_SESION'] ?? $_POST['TBK_ID_SESION'] ?? null;

    // Si viene solo token_ws es porque es un flujo de pago normal
    return $tokenWs && !$ordenCompra && !$idSesion && !$tbkToken;
}
