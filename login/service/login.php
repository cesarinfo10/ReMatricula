<?php
include('../../function/conexion.php');
/*=============================================
LLAMAR A TODOS LOS PAISES
=============================================*/


  $dbconn = db_connect();

  if (isset($_GET['getSesion'])){
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  

  $query = "SELECT rut, estado FROM public.precarga_usuario_matricula where email = '".trim($email)."' and pass = '".trim($pass)."'";
  $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
  $rows = pg_num_rows($result);
  $rowEstado = pg_fetch_row($result);

  if ($rows == 0) {
      echo 2;
    }else{
      if ($rowEstado[1]==1){
        echo 3;
      }else{
        echo 1;
      }
    }
  }


  if (isset($_GET['newPass'])){

    $email = $_POST['email'];
    $rut = $_POST['rut'];

    if ($email != ""){
    $query = "SELECT rut FROM public.precarga_usuario_matricula where email = '".$email."'";
    }else{
      $query = "SELECT email FROM public.precarga_usuario_matricula where rut = '".$rut."'";
    }
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    $rows = pg_num_rows($result);
    $rowRutoEmail = pg_fetch_row($result);

      if ($rows == 0) {
          echo 2;

      }else{

        if ($email != ""){
          $rut = trim($rowRutoEmail[0]);
          $sql = "UPDATE public.precarga_usuario_matricula SET pass = '".$rut."', pass_rep = '".$rut."', estado = 1 WHERE email = '".$email."'";
          $result = pg_query($dbconn, $sql);
          if($result){   
                echo $email;
              } else {
                echo 3;
            }
        }else{
              $email = trim($rowRutoEmail[0]);
              $sql = "UPDATE public.precarga_usuario_matricula SET pass = '".$rut."', pass_rep = '".$rut."', estado = 1 WHERE rut = '".$rut."'";
              $result = pg_query($dbconn, $sql);
              if($result){   
                echo $email;
              } else {
                echo 3;
            }
          }
  
      }
    }


    if (isset($_GET['updatePass'])){

      $pass = $_POST['pass'];
      $pass_rep = $_POST['pass_rep'];
      $email = $_POST['email'];

            $sql = "UPDATE public.precarga_usuario_matricula SET pass = '".$pass."', pass_rep = '".$pass_rep."', estado = 0 WHERE email = '".$email."'";
            $result = pg_query($dbconn, $sql);
    
      if($result){   
           echo 1;
      } else {
          //echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
          echo 2;
      }
      
      }
