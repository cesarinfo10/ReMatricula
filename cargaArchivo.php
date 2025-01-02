<?php
include('function/conexion.php');
/*=============================================
INSERTAR DOCUMENTOS
=============================================*/
if (isset($_GET['insertArchivo'])){

  $dbconn = db_connect();
  
   $arch_nombre     = $_FILES['file']['name'];
   $arch_tmp_nombre = $_FILES['file']['tmp_name'];
   $arch_tipo_mime  = $_FILES['file']['type'];
   $arch_longitud   = $_FILES['file']['size'];


   $rut   = $_POST['rut'];
   $id_tipo = $_POST['id_tipo'];   

   $queryID = "SELECT id FROM usuarios WHERE nombre_usuario='matriculate'";
   $resultID = pg_query($dbconn, $queryID);
   $rowID = pg_fetch_row($resultID);

   $id_usuario=$rowID[0];
   //var_dump($id_usuario);

   $arch_data  = pg_escape_bytea(file_get_contents($arch_tmp_nombre));
  //  var_dump($rut);

    $query = "SELECT id FROM doctos_digitalizados WHERE rut ='".$rut."' AND id_tipo = '".$id_tipo."'";
 
    $result = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());
    $totalRows = pg_num_rows($result);
    
    //var_dump($totalRows);
if ($totalRows >= 1){
      echo 3;

      }else{

			$sql = "INSERT INTO doctos_digitalizados (rut,id_tipo,nombre_archivo,mime,id_usuario,archivo) 
			                      VALUES ('$rut',$id_tipo,'$arch_nombre','$arch_tipo_mime',$id_usuario,'{$arch_data}');";


          // Ejecutamos la sentencia preparada
          $result = pg_query($dbconn, $sql);

          if($result){ 
          echo 1;
          } else {
          //echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
          echo pg_last_error($dbconn);
          }
          //echo $result ;
          pg_close($dbconn);
        }
}
  /*=============================================
  LLAMAR DOCUMENTOS POR ID
  =============================================*/
if (isset($_GET['getDocForUser'])){

  $dbconn = db_connect();
  $rut = $_GET['idTxtNRut'];

  $query = "SELECT id, (SELECT NOMBRE FROM doctos_digital_tipos WHERE id = id_tipo) as Nom, nombre_archivo FROM doctos_digitalizados WHERE rut ='".$rut."'";
 
  $result = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());

  echo '<table class="table" id="docArchivos">
  <thead>
    <tr>
      <th class="labelName">Tipo Documento</th>
      <th class="labelName">Nombre del archivo</th>
      <th class="labelName">Eliminar</th>
    </tr>
  </thead>
  <tbody>';
 while ($row = pg_fetch_row($result)) {
   echo '
   <tr>
   <td>'.$row[1].'</td>
   <td>'.$row[2].'</td>
   <td td align="center"><button type="button" onclick="deleteArchivo('.$row[0].')" class="btn btn-dark"><i class="fas fa-trash"></i></button></td>
 </tr>';

 }
 echo '   </tbody>
 </table>';
  }
/*=============================================
DELETE DOCUMENTO
=============================================*/
if (isset($_GET['eliminarArchivo'])){

  $dbconn = db_connect();
  $id = $_GET['id'];
          $sql = "DELETE FROM doctos_digitalizados WHERE id = ".$id."";    
  
    // Ejecutamos la sentencia preparada
    $result = pg_query($dbconn, $sql);
    if($result){ 
    echo 1;
    } else {
    //echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
    echo pg_last_error($dbconn);
    }
    //echo $result ;
    pg_close($dbconn);
    
    }
?>



