<?php
include('conexion.php');

/*=============================================
ACTUALIZAR PRE CARGA
=============================================*/
if (isset($_GET['postUpdatePrecarga'])){
  $dbconn = db_connect();
  $rut = $_POST['rut'];


      $pasaporte = $_POST['pasaporte']; //
      $NDocumento = $_POST['NDocumento']; //
      $nombre=$_POST['nombre']; //
      $apellido = $_POST['apellido']; //
      $email = $_POST['email']; //
      $tel_movil = $_POST['tel_movil']; //
      $fec_nac = $_POST['fnacimiento']; //
      $estadoCivil= $_POST['estadoCivil']; //
      $genero = $_POST['genero']; //
      $pais= $_POST['pais']; //
      $direccion= $_POST['direccion']; //
      $comuna = $_POST['comunas']; 
      $region = $_POST['regiones']; 
      $viaAdmision = $_POST['viaAdmision'];
      $convalidante =$_POST['convalidante'];//
      $id_jornada= $_POST['id_jornada'];
      $carrera = $_POST['carrera']; //
      $modalidad1_post = $_POST['modalidad1_post']; //
      $regimen = $_POST['regimen']; //

      $sql = 'UPDATE public.precarga_usuario_matricula SET numDucument = "123" WHERE rut = "1-9"';

      $sql = "UPDATE precarga_usuario_matricula SET num_ducumento = '".$NDocumento."',
                pasaporte = '".$pasaporte."', nombres = '".$nombre."', apellidos = '".$apellido."',
                email = '".$email."', tel_movil = '".$tel_movil."', fec_nac = '".$fec_nac ."', estado_civil = '".$estadoCivil."',
                genero = '".$genero."', nacionalidad = '".$pais."', direccion = '".$direccion ."', region = ".$region.", comuna = ".$comuna.",
                via_admision = ".$viaAdmision.", institucion_origen = ".$convalidante.", jornada = '".$id_jornada ."', carrera = ".$carrera.",
                modalidad = '".$modalidad1_post."', regimen = '".$regimen."' WHERE rut = '".$rut."'";
 
      
        // Ejecutamos la sentencia preparada
        $result = pg_query($dbconn, $sql);
      
        if($result){ 
      
          echo 1;
          while ($row = pg_fetch_row($result)) {
            echo $row[0];
          }

        } else {
            echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
            echo 2;
        }
      //echo $result ;
       pg_close($dbconn);
     }
/*=============================================
INSERTAR MATRICULA
=============================================*/
if (isset($_GET['postUpdatePago'])){
  $dbconn = db_connect();

  header('Content-type: application/json');
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  $datos = ($request);
  $rut = $datos->rut;
  $comentarios = $datos->comentarios;;


    $sql = "UPDATE pap SET comentarios = '".$comentarios."' WHERE rut = '".$rut."'";
 
      
        // Ejecutamos la sentencia preparada
        $result = pg_query($dbconn, $sql);
      
        if($result){ 
      
          echo 1;
          while ($row = pg_fetch_row($result)) {
            echo $row[0];
          }

        } else {
            echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
            echo 2;
        }
      //echo $result ;
       pg_close($dbconn);
     }
