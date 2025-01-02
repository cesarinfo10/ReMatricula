<?php
include('../../function/conexion.php');
/*=============================================
INSERTAR PRECARGA
=============================================*/

if (isset($_GET['postInsertarPreCargaRegistro'])){
  $dbconn = db_connect();

  $nombres=$_POST['nombres']; 
  $apellidos = $_POST['apellidos']; 
  $rut = trim($_POST['rut']);
  $num_ducumento = $_POST['num_ducumento'];
  $email = $_POST['email'];
  $tel_movil = $_POST['tel_movil'];
  $pass = trim($_POST['pass']);
  $pass_rep = trim($_POST['pass_rep']);

  $query = "SELECT rut FROM public.precarga_usuario_matricula where rut = '".$rut."' OR email= '".$email."'";
  $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
  $rows = pg_num_rows($result);

  $queryPap = "SELECT rut FROM public.pap where rut = '".$rut."' OR email= '".$email."'";
  $resultPap = pg_query($queryPap) or die('La consulta fallo: ' . pg_last_error());
  $rowsPap = pg_num_rows($resultPap);

    if ($rows == 0 && $rowsPap == 0) {

      $sql = "INSERT INTO public.precarga_usuario_matricula (nombres, apellidos, rut, num_ducumento, email, tel_movil, pass, pass_rep) 
              VALUES ('".$nombres."','".$apellidos."','".trim($rut)."','".$num_ducumento."','".trim($email)."','".$tel_movil."','".trim($pass)."','".trim($pass_rep)."')";    
      
        // Ejecutamos la sentencia preparada
        $result = pg_query($dbconn, $sql);
      
        if($result){ 
      
          echo 1;

        } else {
            echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
            echo 2;
        }
      //echo $result ;
       pg_close($dbconn);
      } else {
        echo 3;
      }
     }