<?php
include('conexion.php');
/*=============================================
INSERTAR FINANZA CONTRATO
=============================================*/
if (isset($_GET['postInsertarContrato'])){
 
  $dbconn = db_connect();

  $modo = $_POST['tipo'];
  $viaAdmision = $_POST['viaAdmision'];
 // $TipoPago = $_POST['TipoPago'];
  $rut = $_POST['rut'];

  //of 
  $monto_matricula_post = $_POST['monto_matricula'];
  $monto_arancel_post = $_POST['monto_arancel'];

  // DESCUENTO CAMPOS BECA//
  $dscto_pregrado_mat = $_POST['dscto_pregrado_mat'];
  $dscto_pregrado_ara = $_POST['dscto_pregrado_ara'];

  
    $id_beca_arancel = $_POST['id_beca_arancel'];

  $dscto_licenciatura_matv = $_POST['dscto_licenciatura_matv'];
  $dscto_licenciatura_ara = $_POST['dscto_licenciatura_ara'];

  // DESCUENTO OFERTAS MATRICULA//
  $porcentaje_becas_mat = $_POST['porcentaje_becas_mat'];
  $porcentaje_becas_ara = $_POST['porcentaje_becas_ara'];
  //ID INSERTADO EN LA MAMTRICULA
  $id = $_POST['idMatricula'];
 
  //OBTENGO EL ID INSERTADO EN LA MAMTRICULA
    /*$query = "SELECT id FROM public.pap WHERE rut= '".$rut."'";
    $result = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());
    $row = pg_fetch_row($result);*/
   
   
    //OBTENGO EL DESCUENTO
    $queryDes = "SELECT ano, semestre, vigencia, descto_mat_regular, descto_ara_regular, descto_mat_convalidante, descto_ara_convalidante
    FROM public.descuento_matricula_online WHERE vigencia = 'S'";
    $resultDes = pg_query($dbconn, $queryDes) or die('La consulta fallo: ' . pg_last_error());
    $rowDes = pg_fetch_row($resultDes);

/*******************************************VALIDACCION DESCUENTOS***********************************************/
    if( $modo == 1) {
    //descto_mat_regular
    $descto_mat_var = $rowDes[3];
    //descto_ara_regular
    $descto_ara_var = $rowDes[4];

    $descto_mat= max($descto_mat_var, $dscto_pregrado_mat, $dscto_licenciatura_matv, $porcentaje_becas_mat);
    $descto_ara = max($descto_ara_var, $dscto_pregrado_ara, $dscto_licenciatura_ara,$porcentaje_becas_ara);

      //MONTO MATRICULA 
      $monto_matricula_descuento = $monto_matricula_post * $descto_mat/100; //este es el descuento (porc_beca_mat)
      $monto_matricula_final_total= $monto_matricula_post - $monto_matricula_descuento;
      //MONTO ARANCEL
      $monto_arancel_decuento = $monto_arancel_post * $descto_ara/100; //este es el descuento (Porc_Beca_Arancel)
      $monto_arancel_final_total= $monto_arancel_post - $monto_arancel_decuento;

    } else {
    //descto_mat_convalidante
    $descto_mat_var = $rowDes[5];
    //descto_ara_convalidante
    $descto_ara_var = $rowDes[6];

    $descto_mat= max($descto_mat_var, $dscto_pregrado_mat, $dscto_licenciatura_matv, $porcentaje_becas_mat);
    $descto_ara = max($descto_ara_var, $dscto_pregrado_ara, $dscto_licenciatura_ara,$porcentaje_becas_ara);
      //MONTO MATRICULA 
      $monto_matricula_descuento = $monto_matricula_post * $descto_mat/100; //este es el descuento (porc_beca_mat)
      $monto_matricula_final_total= $monto_matricula_post - $monto_matricula_descuento;
      //MONTO ARANCEL
      $monto_arancel_decuento = $monto_arancel_post * $descto_ara/100; //este es el descuento (Porc_Beca_Arancel)
      $monto_arancel_final_total= $monto_arancel_post - $monto_arancel_decuento;
    }


/******************************************************************************************************************/
    date_default_timezone_set("America/Santiago");
    $fcha = date("Y-m-d");
    
    $diap_pagare =30;
    $mes = date("m",strtotime($fcha."+ 1 month"));
    $anos = date("Y");
    

    $id_pap = $id; //viene de tabla PAP, al momento de crear nuevo alumno OK
    $monto_matricula = $monto_matricula_post; //Viene de valor calculo antes de WEBPAY
    $id_carrera = $_POST['id_carrera']; //Esta en formulario de ingreso
    $monto_arancel = $monto_arancel_post; //Viene de valor calculo antes de WEBPAY
    $monto_beca_mat= 0; // es 0
    $porc_beca_mat = $descto_mat; //% descto capturado
    $Porc_Beca_Arancel = $descto_ara;//% descto capturado
   // $financiamiento = 'Contado'; //Contado
    $mat_efectivo= $monto_matricula_final_total; //Valor a pagar en matricula

    if ($modo == 1) {
    $arancel_efectivo = $monto_arancel_final_total; //Monto Arancel solo si es webpay , si no es 0
    $financiamiento = 'CONTADO'; //Contado
    $arancel_cuotas_pagare_coleg= 0;
    $semestre = 0; //1 si es otro  null si es web pay
    $tipo = 'Anual'; // si es web pay =ANUAL si es otro =SEMESTRAL
    $arancel_ano_ini_pagare_coleg=0;
    $arancel_pagare_coleg= 0;
    $arancel_diap_pagare_coleg = 0; // Dia del mes de matricula
    $arancel_mes_ini_pagare_coleg =  0;//Mes de matricula +1
    } else { 
      $arancel_efectivo = 0;
      $financiamiento = 'CREDITO'; //Credito
      $arancel_cuotas_pagare_coleg= 5; // es 5
      $semestre = 1; //1 si es otro  null si es web pay
      $tipo = 'Semestral'; // si es web pay =ANUAL si es otro =SEMESTRAL
      $arancel_ano_ini_pagare_coleg=$anos;
      $arancel_pagare_coleg= $monto_arancel_final_total; //Monto Arancel-%descto arancel
      $arancel_diap_pagare_coleg = $diap_pagare; // Dia del mes de matricula
      $arancel_mes_ini_pagare_coleg =  $mes;//Mes de matricula +1
    }
    
    $fecha = $fcha;//date
    $ano= $anos;//año matricula
    $jornada = $_POST['jornada']; //viene de formulario matricula
    $nivel = 1; // 1
    $comentarios ='Matricula Generada Online'; //"MATRICULA ONLINE"
    $modalidad = $_POST['modalidad']; //"MATRICULA ONLINE"
    
   
    $mto = $monto_matricula_final_total + $monto_arancel_final_total;

    if ($modo == 3) {
      header('Content-type:application/json');
      $arr = array('monto_matricula_final_total' => $monto_matricula_final_total, 'monto_arancel_final_total' => $monto_arancel_final_total, 'mto' => $mto);
      echo json_encode($arr);
    }

    $queryID = "SELECT id FROM usuarios WHERE nombre_usuario='matriculate'";
    $resultID = pg_query($dbconn, $queryID);
    $rowID = pg_fetch_row($resultID);
 
    $id_usuario=$rowID[0];
   // echo $arancel_ano_ini_pagare_coleg;
   if ($modo ==1 || $modo == 2) {
     $sql = "INSERT INTO finanzas.contratos (id_pap, monto_matricula,id_carrera, monto_arancel, cod_beca_mat, id_beca_arancel, monto_beca_mat, 
            porc_beca_mat, porc_beca_arancel, financiamiento, mat_efectivo, arancel_efectivo, arancel_pagare_coleg, arancel_cuotas_pagare_coleg, 
            arancel_diap_pagare_coleg, arancel_mes_ini_pagare_coleg, arancel_ano_ini_pagare_coleg, semestre,  ano, jornada, nivel, comentarios, modalidad, tipo, ci_liquidado, id_emisor)
            VALUES (".$id.", ".ceil($monto_matricula).",'".$id_carrera."', ".ceil($monto_arancel).", 'UMC',".$id_beca_arancel.", ".$monto_beca_mat.",
           ".$porc_beca_mat.", ".$Porc_Beca_Arancel.", '".$financiamiento."', ".ceil($mat_efectivo).", ".ceil($arancel_efectivo).", ".ceil($arancel_pagare_coleg).",
           ".$arancel_cuotas_pagare_coleg.", ".$arancel_diap_pagare_coleg.", ".$arancel_mes_ini_pagare_coleg.", ".$arancel_ano_ini_pagare_coleg.", ".$semestre.",
           ".$ano.", '".$jornada."', ".$nivel.", '".$comentarios."', '".$modalidad."', '".$tipo."', 'f', ".$id_usuario.")  RETURNING id";   
  

      
        // Ejecutamos la sentencia preparada
        $result = pg_query($dbconn, $sql);
       // echo pg_last_error($dbconn); 
        $idC = pg_fetch_array($result);

        $idContrato = $idC[0];

        if($result){ 
       
            if ($modo == 1){
              $mto = $monto_matricula_final_total + $monto_arancel_final_total;

              header('Content-type:application/json');
              $arr = array('idContrato' => $idContrato, 'monto' => ceil($mto), 'tipoPago' => 4);
              echo json_encode($arr);
            }
            else if ($modo == 2){
            /*=============================================
            INSERTAR FINANZA PAGARÉ
            =============================================*/
              date_default_timezone_set("America/Santiago");
              $fcha = date("Y-m-d");
            
              $diap_pagare = date("d");
              $mes = date("m",strtotime($fcha."+ 1 month"));
              $anos = date("Y");
              
                  $cuotas = 5; //5
                  $dia_pago = $diap_pagare; //dia seleccionado en combo anterior
                  $mes_inicio = $mes; //mes matricula +1                 
                  $id_contrato= $idContrato; // luego de hacer la insercion en contrato se debe rescara ese numero
                  $ano_inicio = $anos; //año matricula*/
                  $monto = $mto; //monto pagare si es otro
                  $montoMat = $monto_matricula_final_total; //monto pagare si es otro

                  $sql = "INSERT INTO finanzas.pagares_colegiatura (cuotas, dia_pago, mes_inicio, monto, id_contrato, ano_inicio)
                  VALUES ('".$cuotas."', '".$dia_pago."', '".$mes_inicio."', '".$monto."', '".$id_contrato."',
                  '".$ano_inicio."') RETURNING id";    
              // Ejecutamos la sentencia preparada
              $result = pg_query($dbconn, $sql);

              $idP = pg_fetch_array($result);
              $idPagare = $idP[0];

              if($result){
                
                header('Content-type:application/json');
                $arr = array('idContrato' => $idContrato, 'idPagare' => $idPagare, 'monto' => ceil($montoMat), 'tipoPago' => 5);
                echo json_encode($arr);
              }
           }else {
           // echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>"; 
           echo 2;
        }
       } else {
          echo pg_last_error($dbconn); 
          echo 2;
        }
      }
       // verif_estado_carpeta_doctos($rut);
         pg_close($dbconn);

     }


     function consulta_sql($SQLtxt) {
      $dbconn = db_connect();
      $resultado = array();
      $res = pg_query($dbconn, $SQLtxt);
      if (pg_numrows($res) > 0) {
    
        return pg_fetch_all($res);
      } else {
        return $resultado;
      }
    }
    function consulta_dml($SQLtxt) {
      $dbconn = db_connect();
      $res = pg_query($dbconn, $SQLtxt);
      if (pg_affected_rows($res) > 0) {
        return pg_affected_rows($res);
      } else {
        return 0;
      }
    }

     if (isset($_GET['llenarImgPat'])){
      $rut = $_GET['rut'];
      $postulante = consulta_sql("SELECT id,regimen,notif_creacion FROM pap WHERE rut='$rut'");
      extract($postulante[0]);
      
      $doctos_obligatorios = consulta_sql("SELECT * FROM doctos_obligatorios WHERE regimen='$regimen'");
    
      $SQL_cant_doctos = "SELECT dd.id 
                          FROM doctos_obligatorios AS docob
                          LEFT JOIN doctos_digitalizados AS dd ON (dd.rut='$rut' AND NOT dd.eliminado AND dd.id_tipo IN (docob.id_tipo_docto,coalesce(docob.id_tipo_docto_comp,0))) 
                          WHERE docob.regimen='$regimen' AND dd.id IS NOT NULL";		
      $cant_doctos = count(consulta_sql($SQL_cant_doctos));
    //var_dump($cant_doctos);
      $estado_carpeta_doctos = $notif_creacion = "";
      if ($cant_doctos == 0) { 
        $estado_carpeta_doctos = "Vacía"; 
        $notif_creacion = "notif_creacion"; //no modifica la fecha de notificacion, si la hubiera.
      } else {
        if (count($doctos_obligatorios) <= $cant_doctos) { 
          $estado_carpeta_doctos = "Completa"; 
          $notif_creacion = "null"; //elimina la fecha notificacion, para renotificar.
        }
        if (count($doctos_obligatorios) > $cant_doctos) { 
          $estado_carpeta_doctos = "Incompleta"; 
          $notif_creacion = "notif_creacion";//no modifica la fecha de notificacion, si la hubiera.
        }  
      }
      consulta_dml("UPDATE pap SET estado_carpeta_doctos='$estado_carpeta_doctos',estado_carpeta_doctos_fecha=now(),notif_creacion=$notif_creacion WHERE id=$id");
    
      if (count($doctos_obligatorios) <= $cant_doctos && $notif_creacion == "") { email_memorandum_alumnos_nuevos($rut); }
    
    }
    