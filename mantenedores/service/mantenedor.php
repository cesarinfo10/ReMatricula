<?php
include('../../function/conexion.php');
//include('../../function/conexion_desa.php');
/*=============================================
LLAMAR BECAS
=============================================*/
if (isset($_GET['getAllBeca'])){
    $dbconn = db_connect();
  
    $query = "SELECT * FROM public.becas_matricula_online order by id desc";
    $result = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());
     
    echo '<br>
    <table class="table table-hover">
    <thead>
    <tr>
        <th>Descripción</th>
        <th>Pregrado Mat.</th>
        <th>Pregrado Ara.</th>
        <th>Lic. Mat.</th>
        <th>Lic. Ara.</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>';
  
    while ($row = pg_fetch_row($result)) {
      echo '
      <tr>
            <td>'.$row[1].'</td>
            <td>'.$row[2].'</td>
            <td>'.$row[3].'</td>
            <td>'.$row[4].'</td>
            <td>'.$row[5].'</td>
            <td><button type="button" onclick="llamarOneBecas('.$row[0].')" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                <button type="button" onclick="deleteBeca('.$row[0].')" class="btn btn-danger"><i class="fas fa-trash"></i></button>
            </td>
      </tr>';
    }
    echo '
        </tbody>
    </table>';
     }
/*=============================================
INCERTAR BECAS
=============================================*/
if (isset($_GET['incertBeca'])){

    $dbconn = db_connect();
     
        $descripcion = $_POST['descripcion']; //
        $dscto_pregrado_mat = $_POST['dscto_pregrado_mat']; //
        $dscto_pregrado_ara = $_POST['dscto_pregrado_ara'];//
        $dscto_licenciatura_mat=$_POST['dscto_licenciatura_mat']; //
        $dscto_licenciatura_ara = $_POST['dscto_licenciatura_ara']; //
      
  
        $sql = "INSERT INTO public.becas_matricula_online (descripcion, dscto_pregrado_mat, dscto_pregrado_ara,
        dscto_licenciatura_mat, dscto_licenciatura_ara) VALUES ('".$descripcion."', '".$dscto_pregrado_mat."',
         '".$dscto_pregrado_ara."', '".$dscto_licenciatura_mat."', '".$dscto_licenciatura_ara."') RETURNING id";    
        
          // Ejecutamos la sentencia preparada
          $result = pg_query($dbconn, $sql);
  /*
          $idMat = pg_fetch_array($result);
          $idMatricula = $idMat[0];
  */
          if($result){ 
        
            echo 1;
         } else {
              echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
              echo 2;
          }
        //echo $result ;
         pg_close($dbconn);
} 
  
  
/*=============================================
LLAMAR UNA BECA
=============================================*/
if (isset($_GET['getOneBeca'])){
    $dbconn = db_connect();
  
    header('Content-type:application/json');
  
    $id = $_GET['id'];
  
    $query = "SELECT * FROM public.becas_matricula_online where id = '".$id."'";
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    $row = pg_fetch_row($result);
    
   
    echo json_encode($row);
     }

/*=============================================
UPDATE BECAS
=============================================*/
if (isset($_GET['updateBeca'])){

    $dbconn = db_connect();
   

        $id = $_POST['id'];
        $descripcion = $_POST['descripcion']; //
        $dscto_pregrado_mat = $_POST['dscto_pregrado_mat']; //
        $dscto_pregrado_ara = $_POST['dscto_pregrado_ara'];//
        $dscto_licenciatura_mat=$_POST['dscto_licenciatura_mat']; //
        $dscto_licenciatura_ara = $_POST['dscto_licenciatura_ara']; //
      
  
        $sql = "UPDATE public.becas_matricula_online
        SET  descripcion='".$descripcion."', dscto_pregrado_mat=".$dscto_pregrado_mat.", 
        dscto_pregrado_ara=".$dscto_pregrado_ara.", dscto_licenciatura_mat=".$dscto_licenciatura_mat.",
        dscto_licenciatura_ara=".$dscto_licenciatura_ara." WHERE id=".$id."";    
        
          // Ejecutamos la sentencia preparada
          $result = pg_query($dbconn, $sql);
  /*
          $idMat = pg_fetch_array($result);
          $idMatricula = $idMat[0];
  */
          if($result){ 
        
            echo 1;
         } else {
              echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
              echo 2;
          }
        //echo $result ;
         pg_close($dbconn);
}

/*=============================================
DELETE BECA
=============================================*/
if (isset($_GET['deleteBeca'])){
    $dbconn = db_connect();
  
    $id = $_GET['id'];
  
    $query = "DELETE FROM public.becas_matricula_online WHERE  id = '".$id."'";
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    $row = pg_fetch_row($result);
    
    if($result){ 
        
        echo 1;
     } else {
          echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
          echo 2;
      }
     }



/*=============================================
                  OFERTAS
=============================================*/
/*=============================================
LLAMAR CARRERAS/PROGRAMAS
=============================================*/
if (isset($_GET['getAllCarrProg'])){
    $dbconn = db_connect();

    $queryDes = "SELECT ano FROM public.descuento_matricula_online WHERE vigencia = 'S'";
    $resultDes = pg_query($dbconn, $queryDes) or die('La consulta fallo: ' . pg_last_error());
    $rowDes = pg_fetch_row($resultDes);
  
    $fecha = $rowDes[0];
  
    $id_jornada = $_GET['jornada'];
  
    $query = "SELECT id_carrera, carrera AS nombre,  id_arancel AS id,
    matricula_anual, arancel_contado_anual, matricula_semestral,
    arancel_credito_semestral, modalidad, regimen, id
    FROM vista_aranceles_carreras 
    WHERE ano = '".$fecha."' AND id_jornada = '".$id_jornada."' ORDER BY nombre";
   
    $result = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());
     
    echo '<select class="select2 form-control custom-select" name="ddl_carrera" id="ddl_carrera">
    <option value="0">Seleccione</option>';
  
    while ($row = pg_fetch_row($result)) {
      echo '<option value="'.$row[0].'" id="'.$row[2].'" matricula_anual="'.$row[3].'"arancel_contado_anual="'.$row[4].'" 
            matricula_semestral="'.$row[5].'" arancel_credito_semestral="'.$row[6].'"
            modalidad="'.$row[7].'" regimen="'.$row[8].'" regimenID="'.$row[9].'">'.$row[1].'</option>';
    }
    echo '</select>';
     }




/*=============================================
LLAMAR OFERTAS
=============================================*/
if (isset($_GET['getAllOfertas'])){
    $dbconn = db_connect();
  
    $queryDes = "SELECT ano FROM public.descuento_matricula_online WHERE vigencia = 'S'";
    $resultDes = pg_query($dbconn, $queryDes) or die('La consulta fallo: ' . pg_last_error());
    $rowDes = pg_fetch_row($resultDes);
  
    $fecha = $rowDes[0];

    $query = "SELECT * FROM public.ofertas_matricula_online order by cod_carrera desc";
    $result = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());
     
    echo '<br>
    <table class="table table-hover">
    <thead>
    <tr>
        <th>Jornada</th>
        <th>Carrera</th>
        <th>Porc. Matricula</th>
        <th>Porc. Arancel</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>';
  
    while ($row = pg_fetch_row($result)) {

        $queryC = "SELECT carrera AS nombre  FROM vista_aranceles_carreras
        WHERE ano = '".$fecha."' AND id_carrera = ".$row[1]."";
        $resultC = pg_query($dbconn, $queryC) or die('La consulta fallo: ' . pg_last_error());
        $rowC = pg_fetch_row($resultC);
      echo '
      <tr>
            <td>'.$row[0].'</td>
            <td>'.$rowC[0].'</td>
            <td>'.$row[2].'</td>
            <td>'.$row[3].'</td>
            <td><button type="button" onclick="llamarOneOferta(\''.$row[0].'\', '.$row[1].')" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                <button type="button" onclick="deleteOfertas(\''.$row[0].'\', '.$row[1].')" class="btn btn-danger"><i class="fas fa-trash"></i></button>
            </td>
      </tr>';
    }
    echo '
        </tbody>
    </table>';
     }

/*=============================================
INCERTAR OFERTAS
=============================================*/
if (isset($_GET['incerOfertas'])){

    $dbconn = db_connect();
     
        $cod_jornada = $_POST['cod_jornada']; //
        $cod_carrera = $_POST['cod_carrera']; //
        $porcentaje_becas_mat = $_POST['porcentaje_becas_mat'];//
        $porcentaje_becas_ara=$_POST['porcentaje_becas_ara']; //
     // echo $cod_jornada;
  
        $sql = "INSERT INTO public.ofertas_matricula_online (cod_jornada, cod_carrera, porcentaje_becas_mat,porcentaje_becas_ara)
               VALUES ('".$cod_jornada."', ".$cod_carrera.",".$porcentaje_becas_mat.", ".$porcentaje_becas_ara.")";    
        
          // Ejecutamos la sentencia preparada
          $result = pg_query($dbconn, $sql);
  /*
          $idMat = pg_fetch_array($result);
          $idMatricula = $idMat[0];
  */
          if($result){ 
        
            echo 1;
         } else {
              echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
              echo 2;
          }
        //echo $result ;
         pg_close($dbconn);
} 
  

/*=============================================
LLAMAR UNA OFERTA
=============================================*/
if (isset($_GET['getOneOferta'])){
    $dbconn = db_connect();
  
    header('Content-type:application/json');
  
    $cod_jornada = $_GET['cod_jornada'];
    $cod_carrera = $_GET['cod_carrera'];
  
    $query = "SELECT * FROM public.ofertas_matricula_online where cod_jornada = '".$cod_jornada."' AND cod_carrera = ".$cod_carrera."";
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    $row = pg_fetch_row($result);
    
   
    echo json_encode($row);
     }

/*=============================================
UPDATE OFERTAS
=============================================*/
if (isset($_GET['updateOfertas'])){

    $dbconn = db_connect();
     
        $cod_jornada = $_POST['cod_jornada']; //
        $cod_carrera = $_POST['cod_carrera']; //
        $porcentaje_becas_mat = $_POST['porcentaje_becas_mat'];//
        $porcentaje_becas_ara=$_POST['porcentaje_becas_ara']; //
     // echo $cod_jornada;
  
        $sql = "UPDATE  public.ofertas_matricula_online SET porcentaje_becas_mat = ".$porcentaje_becas_mat.",
                porcentaje_becas_ara = ".$porcentaje_becas_ara." WHERE cod_jornada= '".$cod_jornada."' AND
                cod_carrera = ".$cod_carrera."";    
        
          // Ejecutamos la sentencia preparada
          $result = pg_query($dbconn, $sql);
  /*
          $idMat = pg_fetch_array($result);
          $idMatricula = $idMat[0];
  */
          if($result){ 
        
            echo 1;
         } else {
              echo "<br>Hubo un problema y no se guardó el registro. " . pg_last_error($dbconn) . "<br/>";
              echo 2;
          }
        //echo $result ;
         pg_close($dbconn);
} 

/*=============================================
DELETE OFERTAS
=============================================*/
if (isset($_GET['deleteOfertas'])){
    $dbconn = db_connect();
  
    $cod_jornada = $_GET['cod_jornada'];
    $cod_carrera = $_GET['cod_carrera'];
  
    $query = "DELETE FROM public.ofertas_matricula_online  WHERE cod_jornada= '".$cod_jornada."' AND  cod_carrera = ".$cod_carrera."";

    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    $row = pg_fetch_row($result);
    
    if($result){ 
        
        echo 1;
     } else {
          echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
          echo 2;
      }
     }