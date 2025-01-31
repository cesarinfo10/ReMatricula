<?php
include('conexion.php');

/*=============================================
LLAMAR PRE CARGA
=============================================*/
if (isset($_GET['getOnePreCarga'])){
  $dbconn = db_connect();

  header('Content-type:application/json');

  $email = $_GET['email'];

  $query_pap = "SELECT
	alumnos.id, 
	alumnos.rut, 
	alumnos.nombres, 
	alumnos.apellidos, 
	alumnos.genero, 
	alumnos.fec_nac, 
	alumnos.pasaporte, 
	alumnos.nacionalidad, 
	alumnos.direccion, 
	alumnos.comuna, 
	alumnos.region, 
	alumnos.nombre_usuario, 
	alumnos.telefono, 
	alumnos.tel_movil, 
	alumnos.admision, 
	alumnos.estado, 
	alumnos.cohorte, 
	alumnos.semestre_cohorte, 
	alumnos.rbd_colegio, 
	alumnos.ano_egreso_col, 
	alumnos.promedio_col, 
	alumnos.ano_psu, 
	alumnos.puntaje_psu, 
	alumnos.carrera_actual, 
  (SELECT nombre FROM public.carreras WHERE id = alumnos.carrera_actual) as carrera_nombre,
	alumnos.malla_actual, 
	alumnos.cert_nacimiento, 
	alumnos.arch_cert_nac, 
	alumnos.copia_ced_iden, 
	alumnos.arch_cp_cedid, 
	alumnos.conc_notas_em, 
	alumnos.arch_conc_n_em, 
	alumnos.licencia_em, 
	alumnos.arch_lic_em, 
	alumnos.boletin_psu, 
	alumnos.id_inst_edsup_proced, 
	alumnos.carr_ies_pro, 
	alumnos.prom_nt_ies_pro, 
	alumnos.conc_nt_ies_pro, 
	alumnos.prog_as_ies_pro, 
	alumnos.nombre_aux, 
	alumnos.id_pap, 
	alumnos.rut_original, 
	alumnos.moroso_financiero, 
	alumnos.moroso_biblioteca, 
	alumnos.anotaciones, 
	alumnos.estado_tramite, 
	alumnos.email, 
	alumnos.jornada, 
	alumnos.id_aval, 
	alumnos.fotografias, 
	alumnos.eliminado_rendacad, 
	alumnos.eliminado_rendacad_obs, 
	alumnos.fecha_egreso, 
	alumnos.fecha_titulacion, 
	alumnos.regimen, 
	alumnos.ano_egreso, 
	alumnos.semestre_egreso, 
	alumnos.mes_cohorte, 
	alumnos.rpnp, 
	alumnos.examen_grado_titulo_fecha, 
	alumnos.examen_grado_titulo_calif, 
	alumnos.fecha_inicio_programa, 
	alumnos.semestre_cohorte_reinc, 
	alumnos.cohorte_reinc, 
	alumnos.mes_cohorte_reinc, 
	alumnos.grado_acad_obt, 
	alumnos.salida_int_obt, 
	alumnos.titulo_prof_obt, 
	alumnos.pond_s1, 
	alumnos.pond_s2, 
	alumnos.pond_nc, 
	alumnos.examen_titulo_calif, 
	alumnos.examen_titulo_fecha, 
	alumnos.nro_registro_libro_tit, 
	alumnos.nota_titulacion, 
	alumnos.examen_grado_titulo_oportunidades, 
	alumnos.examen_titulo_oportunidades, 
	alumnos.estado_fecha, 
	alumnos.estado_id_usuario, 
	alumnos.salida_int_fecha, 
	alumnos.salida_int_nroreg_libro, 
	alumnos.fecha_graduacion, 
	alumnos.salida_int_calif, 
	alumnos.nro_registro_libro_grado, 
	alumnos.nota_graduacion, 
	alumnos.servidor_nombre_usuario, 
	alumnos.retornado, 
	alumnos.tipo_docto_ident, 
	alumnos.dv_docto_ident, 
	alumnos.nro_docto_ident, 
	alumnos.modalidad
FROM
	alumnos WHERE email = '".$email."'";
  $result_pap = pg_query($query_pap) or die('La consulta fallo: ' . pg_last_error());
  $row_pap = pg_fetch_row($result_pap);
  //$rows_pap = pg_num_rows($result_pap);

  echo json_encode($row_pap);
/*if ($rows_pap == 0){
    $query = "SELECT * FROM public.precarga_usuario_matricula where email = '".$email."'";
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    $row = pg_fetch_row($result);
    $rows = pg_num_rows($result);

  echo json_encode($row);
   }else{
    $query_con = "SELECT id FROM finanzas.contratos where id_pap = ".$row_pap[0].";";
    $result_con = pg_query($query_con) or die('La consulta fallo: ' . pg_last_error());
    $row_con = pg_fetch_row($result_con);

    if ($row_con != 0 ||  $row_con != '' ){
    $query_pag = "SELECT id FROM finanzas.pagares_colegiatura where id_contrato = ".$row_con[0]."";
    $result_pag = pg_query($query_pag) or die('La consulta fallo: ' . pg_last_error());
    $row_pag = pg_fetch_row($result_pag);
    $rows_pag = pg_num_rows($result_pag);
   }
 //   echo $row_pag[0];
    array_push($row_pap, "pap");
    array_push($row_pap, $row_con[0]); //IDCONTRATO
    if ($rows_pap != 0 ||  $rows_pap != '' ){
    array_push($row_pap, $row_pag[0]);//IDPAGARE
    }
    echo json_encode($row_pap);
   }*/
}


/*============================================
LLAMAR OFERTA MATRICULA
=============================================*/
if (isset($_GET['getOneOfetaMat'])){
  $dbconn = db_connect();

  header('Content-type:application/json');

  $cod_jornada = $_GET['cod_jornada'];
  $cod_carrera = $_GET['cod_carrera'];

  $query = "SELECT * FROM public.ofertas_matricula_online where cod_jornada = '".$cod_jornada."' and cod_carrera = '".$cod_carrera."'";
  $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
  $row = pg_fetch_row($result);
  
 
  echo json_encode($row);
   }
/*=============================================
LLAMAR A TODOS LOS PAISES
=============================================*/
if (isset($_GET['getAllPais'])){
  $dbconn = db_connect();

  $query = "SELECT localizacion, nacionalidad FROM public.pais WHERE nacionalidad <> 'Chilena' ORDER BY nacionalidad ASC";
  $result = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());
   
  echo '<select class="shadow-lg p-1 bg-white form-control"  name="ddl_pais" id="ddl_pais" onchange ="updatePreMatricula()">
  <option value="CL">Chilena</option>';

  while ($row = pg_fetch_row($result)) {
    echo '<option value="'.$row[0].'">'.$row[1].'</option>';
  }
  echo '</select>';
   }
/*=============================================
LLAMAR VIA ADMISIÓN
=============================================*/
if (isset($_GET['getAllAdmision'])){
  $dbconn = db_connect();
  $query = "SELECT id, nombre from public.admision_tipo where id in (1, 2, 4) ORDER BY nombre ASC";
  $result = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());
   
  echo '<select class="shadow-lg p-1 bg-white form-control" name="ddl_viaAdmision" id="ddl_viaAdmision"
  onchange="mostrarInstituciones(); cambiarDoc();">
  <option value="0">Seleccione</option>';

  while ($row = pg_fetch_row($result)) {
    if ($row[1] =='Prosecución'){
      $row[1] ='Licenciaturas';
    }
    if ($row[1] =='Extraordinaria'){
      $row[1] ='Convalidaciones';
    }
    echo '<option value="'.$row[0].'">'.$row[1].'</option>';
  }
  echo '</select>';
   }

/*=============================================
LLAMAR INSTUTUCIONES CONVALIDANTES
=============================================*/
if (isset($_GET['getAllInstitucion'])){
  $dbconn = db_connect();

  $query = "SELECT id, nombre_original from public.inst_edsup where pais='CL' order by nombre_original desc";
  $result = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());
   
  echo '<select class="select2 form-control custom-select" style="width: 100%; height:36px;"" 
  name="ddl_convalidante" id="ddl_convalidante">
  <option value="0">Seleccione</option>';

  while ($row = pg_fetch_row($result)) {
    echo '<option value="'.$row[0].'">'.$row[1].'</option>';
  }
  echo '</select>';
   }
/*=============================================
LLAMAR BECAS
=============================================*/
if (isset($_GET['getAllBeca'])){
  $dbconn = db_connect();

  $query = "SELECT * FROM public.becas_matricula_online";
  $result = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());
   
  echo '<select class="shadow-lg p-1 bg-white form-control" style="width: 100%; height:36px;"" 
  onchange ="llenarCamposBecaMatriculas()"name="ddl_beca" id="ddl_beca">
  <option value="0">Seleccione</option>';

  while ($row = pg_fetch_row($result)) {
    echo '<option value="'.$row[0].'" dscto_pregrado_mat="'.$row[2].'" dscto_pregrado_ara="'.$row[3].'" 
          dscto_licenciatura_mat="'.$row[4].'" dscto_licenciatura_ara="'.$row[5].'" id_beca_arancel="'.$row[6].'">'.$row[1].'</option>';
  }
  echo '</select>';
   }
/*=============================================
LLAMAR CARRERAS/PROGRAMAS
=============================================*/
if (isset($_GET['getAllCarrProg'])){
  $dbconn = db_connect();
  /*date_default_timezone_set("America/Santiago");
  $fecha = date("Y");*/
  $queryDes = "SELECT ano FROM public.descuento_matricula_online WHERE vigencia = 'S'";
  $resultDes = pg_query($dbconn, $queryDes) or die('La consulta fallo: ' . pg_last_error());
  $rowDes = pg_fetch_row($resultDes);

  $fecha = $rowDes[0];

  $id_jornada = $_GET['jornada'];

  $query = "SELECT id_carrera, carrera AS nombre,  id_arancel AS id,
  matricula_anual, arancel_contado_anual, matricula_semestral,
  arancel_credito_semestral, modalidad, regimen, id
  FROM vista_aranceles_carreras
  WHERE ano = '".$fecha."' AND id_jornada = '".$id_jornada."' ORDER BY regimen";
 
  $result = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());
   
  echo '<select class="select2 form-control custom-select" name="ddl_carrera" id="ddl_carrera"
  onchange="mostraSaldo();updatePreMatricula();llamarOfertaMatricula()">
  <option value="0">Seleccione</option>';

  while ($row = pg_fetch_row($result)) {
    echo '<option value="'.$row[0].'" id="'.$row[2].'" matricula_anual="'.$row[3].'"arancel_contado_anual="'.$row[4].'" 
          matricula_semestral="'.$row[5].'" arancel_credito_semestral="'.$row[6].'"
          modalidad="'.$row[7].'" regimen="'.$row[8].'" regimenID="'.$row[9].'">'.$row[1].'</option>';
  }
  echo '</select>';
   }
  /*=============================================
  LLAMAR TIPOS DOCUMENTOS
  =============================================*/
if (isset($_GET['getAllTipoDoc'])){
  
  $dbconn = db_connect();
  $tipo_admision = $_GET['tipo_admision'];

  $query = "SELECT * FROM vista_doctos_obligatorios WHERE regimen_nombre='1. Pregrado' AND tipo_admision ='".$tipo_admision."'";
 
  $result = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());

   echo '<select class="shadow-lg p-1 bg-white form-control" name="ddl_Subirarchivo" id="ddl_Subirarchivo" onchange="mostraSubirArchivo()">
  <option value="">Seleccionar</option>';
  while ($row = pg_fetch_row($result)) {
    echo '<option value="'.$row[0].'" regimen="'.$row[1].'" tipo="'.$row[2].'">'.$row[6].'</option>';
  }
  echo '</select>';
   }


/*=============================================
LLAMAR COMUNAS
=============================================*/
if (isset($_GET['getAllComunas'])){
  
  $dbconn = db_connect();
  $query = "SELECT id, nombre from comunas order by nombre ASC";
  $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
   
  echo '<select class="shadow-lg p-1 bg-white form-control" name="ddl_comunas" id="ddl_comunas" onchange ="updatePreMatricula()">
  <option value="0">Seleccione</option>';

  while ($row = pg_fetch_row($result)) {
    echo '<option value="'.$row[0].'">'.$row[1].'</option>';
  }
  echo '</select>';
   }
/*=============================================
LLAMAR REGIONES
=============================================*/
if (isset($_GET['getAllRegion'])){
  
  $dbconn = db_connect();
  $query = "SELECT id, nombre from regiones order by nombre ASC";
  $result = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());
   
  echo '<select class="shadow-lg p-1 bg-white form-control" name="ddl_regiones" id="ddl_regiones" onchange ="updatePreMatricula()">
  <option value="0">Seleccione</option>';

  while ($row = pg_fetch_row($result)) {
    echo '<option value="'.$row[0].'">'.$row[1].'</option>';
  }
  echo '</select>';
   }

 /*============================================
LLAMAR CANTIDAD DE DOC
=============================================*/
if (isset($_GET['getNumDoc'])){
  $dbconn = db_connect();

  $id_tipo = $_GET['id_tipo'];

  $query = "SELECT id FROM vista_doctos_obligatorios WHERE regimen_nombre='1. Pregrado' AND tipo_admision='$id_tipo'";
  $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
  $rows = pg_num_rows($result);
   
  echo ($rows);
   }