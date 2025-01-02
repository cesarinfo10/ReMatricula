<?php
include('conexion.php');
/*=============================================
INSERTAR MATRICULA
=============================================*/
if (isset($_GET['postInsertar'])){

 
  $dbconn = db_connect();
  $rut = trim($_POST['rut']);

  date_default_timezone_set("America/Santiago");
  $fcha = date("Y-m-d");
  
  $diap_pagare = 30;
  $mes = date("m",strtotime($fcha."+ 1 month"));
  $anos = date("Y");

  $query = "SELECT rut FROM public.pap where rut = '".$rut."'";
  $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
  $rows = pg_num_rows($result);

    if ($rows == 0) {
      $tipoDocumento= $_POST['tipoDocumento'];
      $pasaporte = $_POST['pasaporte']; //
      $NDocumento = $_POST['NDocumento']; //
      $nombre=$_POST['nombre']; //
      $apellido = $_POST['apellido']; //
      $email = $_POST['email']; //
      $tel_movil = $_POST['tel_movil']; //
      $fnacimiento = $_POST['fnacimiento']; //
      $estadoCivil= $_POST['estadoCivil']; //
      $genero = $_POST['genero']; //
      $pais= $_POST['pais']; //
      $direccion= $_POST['direccion']; //
      $comuna = $_POST['comunas']; 
      $region = $_POST['regiones']; 
      $viaAdmision = $_POST['viaAdmision'];
      if ($_POST['convalidante'] == 0){
        $convalidante = "null";
       // echo 'error';
      }else{
        $convalidante =$_POST['convalidante'];//
      }
      //$convalidante =$_POST['convalidante'];
      $id_jornada= $_POST['id_jornada'];
      $carrera = $_POST['carrera']; //
      $modalidad1_post = $_POST['modalidad1_post']; //
      $regimen = $_POST['regimen']; //
      if($_POST['id_beca'] !='0'){
        if($_POST['id_beca'] !='0'){
          switch ($_POST['id_beca']) {
              case 1:
              case 2:
              case 3:
              case 5:
              case 7:
              case 8:
              case 9:
                $id_beca = 5;
              break;
            case 4:
                $id_beca = 5;
              break;
            case 6:
              $id_beca = 14;
              break;
            case 10:
              $id_beca = 22;
                break;
            }
          }
      }else{
        $id_beca= "null";
      }
      //echo $id_beca;
    $sql = "INSERT INTO pap (rut,nombres,apellidos,fec_nac,direccion, comuna, region, tipo_docto_ident, email, 
                              tel_movil, nacionalidad, est_civil, genero, carrera1_post, admision, id_inst_edsup_proced, id_beca,
                              pasaporte, modalidad1_post,  cohorte, semestre_cohorte, regimen, jornada1_post)
                              VALUES ('".$rut."', '".$nombre."', '".$apellido."', '".$fnacimiento."', '".$direccion."',
                              ".$comuna.",".$region.",'".$tipoDocumento."','".$email."', '".$tel_movil."','".$pais."', '".$estadoCivil."',
                              '".$genero."', '".$carrera."', ".$viaAdmision.", ".$convalidante.", ".$id_beca.", '".$pasaporte."', '".$modalidad1_post."',
                              ".$anos.", 1, '".$regimen."','".$id_jornada."') RETURNING id";    
      
        // Ejecutamos la sentencia preparada
        $result = pg_query($dbconn, $sql);

        $idMat = pg_fetch_array($result);
        $idMatricula = $idMat[0];

        if($result){ 
      
          echo $idMatricula;
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


     if (isset($_GET['postInsertarAval'])){

 
      $dbconn = db_connect();

          $rut = $_POST['rut'];
          $nombre=$_POST['nombre']; //
          $apellido = $_POST['apellido']; //
          $email = $_POST['email']; //
          $tel_movil = $_POST['tel_movil']; ///
          $estadoCivil= $_POST['estadoCivil']; //
          $pais= $_POST['pais']; //
          $direccion= $_POST['direccion']; //
          $comuna = $_POST['comunas']; 
          $region = $_POST['regiones'];
          $id_contrato =  $_POST['id_contrato'];
    
          $queryAv = "SELECT id FROM public.avales where rf_rut = '".$rut."'";
          $resultAv = pg_query($queryAv) or die('La consulta fallo: ' . pg_last_error());
          $rows = pg_num_rows($resultAv);
          $rowAva = pg_fetch_row($resultAv);
          
          $id_aval = 0;

          if ($rows == 0) {
                $sql = "INSERT INTO public.avales( rf_rut, rf_apellidos, rf_nombres, rf_parentezco, rf_nacionalidad, rf_pasaporte, rf_direccion,
                                                rf_comuna, rf_region, rf_telefono, rf_tel_movil, rf_email, rf_nombre_empresa, rf_cargo_empresa,
                                                rf_antiguedad_empresa, rf_sueldo_liquido, rf_direccion_empresa, rf_comuna_empresa, rf_region_empresa,
                                                rf_telefono_empresa, rf_email_empresa, rf_est_civil, rf_profesion, rf_teletrabajo)
                                          VALUES ('".$rut."', '".$apellido."','".$nombre."', 'Ninguno', '".$pais."', 0, '".$direccion."',
                                                  ".$comuna.",".$region.",'".$tel_movil."', '".$tel_movil."', '".$email."', 'null', 'null',
                                                  0, 0,'".$direccion."', ".$comuna.",".$region.", '".$tel_movil."', '".$email."',
                                                  '".$estadoCivil."','f', 'f') RETURNING id";    
                  
                    // Ejecutamos la sentencia preparada
                    $result = pg_query($dbconn, $sql);
                  
                    $idAval = pg_fetch_array($result);
                    $id_aval = $idAval[0];
          
            }else{
              $id_aval = $rowAva[0];
            }

            if($id_aval != 0){ 
              $sqlPap = "UPDATE public.pap SET id_aval = ".$id_aval." WHERE rut = '".$rut."'";
              $resultPap = pg_query($dbconn, $sqlPap);

              $sqlCon = "UPDATE finanzas.contratos SET id_aval = ".$id_aval." WHERE id = ".$id_contrato."";
              $resultCon = pg_query($dbconn, $sqlCon);

              echo 1;
           } else {
                echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
                echo 2;
            }
          //echo $result ;
           pg_close($dbconn);
          } 
    
/*=============================================
INSERTAR PRECARGA
=============================================*/
if (isset($_GET['postInsertarPreCarga'])){
  $dbconn = db_connect();
  $rut = $_POST['rut'];

  $query = "SELECT rut FROM public.precarga_usuario_matricula where rut = '".$rut."'";
  $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
  $rows = pg_num_rows($result);

    if ($rows == 0) {

      $sql = "INSERT INTO precarga_usuario_matricula (rut) VALUES ('".$rut."')";    
      
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
      } else {
        echo 3;
      }
     }