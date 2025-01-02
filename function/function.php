<?php
include('conexion.php');

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
function generar_cobros ($id_contrato,$id_glosa,$cant_cuotas,$monto_cuota,$monto_total,$diap,$mesp,$anop) {
	//echo $diap,$mesp,$anop;
	$SQL_cobros = "";
	for ($x=1;$x<=$cant_cuotas;$x++) {					
		if ($x == $cant_cuotas) {
			$monto_cuota = $monto_total - ($monto_cuota * ($x-1));
		}
		
		if ($mesp > 12) { $mesp=1; $anop++; }
		
		$diap_aux = $diap;
		if ($mesp == 2 && $diap_aux > 28) { $diap_aux = 28; }
		
		$fecha_venc = "$anop-$mesp-$diap_aux";
		
		$SQL_cobros .= "INSERT INTO finanzas.cobros (id_contrato,id_glosa,nro_cuota,monto,fecha_venc)
						 VALUES ($id_contrato,$id_glosa,$x,$monto_cuota,'$fecha_venc');";
		$mesp++;

	}
	return $SQL_cobros;
}

if(isset($_GET['matAnticipada'])){
	$id_glosa    = 1; // Matricula cuando hay un monto de matricula a pagar
	$ano = $_GET['ano'];
	$id_contrato = $_GET['id_contrato'];

	$contrato = (consulta_sql("SELECT * FROM finanzas.contratos WHERE id=$id_contrato"));

	if (intval($ano) > intval(date("Y"))) { $id_glosa = 10001; } // matricula anticipada
	$cant_cuotas = 1;

	$monto_total = $contrato[0]['mat_efectivo'];
	$monto_cuota = intval($monto_total/$cant_cuotas);
	$diap        = strftime("%d");
	$mesp        = strftime("%m");
	$anop        = strftime("%Y");
	$SQL_cobros  = generar_cobros($id_contrato,$id_glosa,$cant_cuotas,$monto_cuota,$monto_total,$diap,$mesp,$anop);
	consulta_sql($SQL_cobros);
}

    
    if (isset($_GET['generar_cobros'])){

    $id_contrato = $_GET['id_contrato'];
	$contrato = (consulta_sql("SELECT * FROM finanzas.contratos WHERE id=$id_contrato"));

	if (count($contrato) == 1) {
		var_dump($contrato);
		if ($contrato[0]['arancel_pagare_coleg'] > 0 && $contrato[0]['arancel_cuotas_pagare_coleg'] > 0) {
			$id_glosa    = 2; // mensualidad de pagare de colegiatura
			$cant_cuotas = $contrato[0]['arancel_cuotas_pagare_coleg'];
			$monto_cuota = intval($contrato[0]['arancel_pagare_coleg']/$contrato[0]['arancel_cuotas_pagare_coleg']);
			$monto_total = $contrato[0]['arancel_pagare_coleg'];
			$diap        = $contrato[0]['arancel_diap_pagare_coleg'];
			$mesp        = $contrato[0]['arancel_mes_ini_pagare_coleg'];
			$anop        = $contrato[0]['arancel_ano_ini_pagare_coleg'];
			$SQL_cobros  = generar_cobros($id_contrato,$id_glosa,$cant_cuotas,$monto_cuota,$monto_total,$diap,$mesp,$anop);
			consulta_sql($SQL_cobros);
		}
	

		if ($contrato[0]['arancel_cheque'] > 0 && $contrato[0]['arancel_cant_cheques'] > 0) {
			$id_glosa    = 21; // mensualidad cheques
			$cant_cuotas = $contrato[0]['arancel_cant_cheques'];
			$monto_total = $contrato[0]['arancel_cheque'];
			$monto_cuota = intval($monto_total/$cant_cuotas);
			$diap        = $contrato[0]['arancel_diap_cheque'];
			$mesp        = $contrato[0]['arancel_mes_ini_cheque'];
			$anop        = $contrato[0]['arancel_ano_ini_cheque'];
			$SQL_cobros  = generar_cobros($id_contrato,$id_glosa,$cant_cuotas,$monto_cuota,$monto_total,$diap,$mesp,$anop);
			consulta_sql($SQL_cobros);
		}
		
		if ($contrato[0]['arancel_efectivo'] > 0) {
			$id_glosa    = 3; // arancel completo
      if ($contrato[0]['ano'] > date("Y")) { $id_glosa = 10003; } // arancel completo anticipado

			$cant_cuotas = 1;
			$monto_total = $contrato[0]['arancel_efectivo'];
			$monto_cuota = intval($monto_total/$cant_cuotas);
			$diap        = strftime("%d",strtotime($contrato[0]['fecha']));
			$mesp        = strftime("%m",strtotime($contrato[0]['fecha']));
			$anop        = strftime("%Y",strtotime($contrato[0]['fecha']));
			$SQL_cobros  = generar_cobros($id_contrato,$id_glosa,$cant_cuotas,$monto_cuota,$monto_total,$diap,$mesp,$anop);
			consulta_sql($SQL_cobros);
		}
		
		if ($contrato[0]['arancel_tarjeta_credito'] > 0) {
			$id_glosa    = 3; // arancel completo
      if ($contrato[0]['ano'] > date("Y")) { $id_glosa = 10003; } // arancel completo anticipado
			$cant_cuotas = 1;
			$monto_total = $contrato[0]['arancel_tarjeta_credito'];
			$monto_cuota = intval($monto_total/$cant_cuotas);
			$diap        = strftime("%d",strtotime($contrato[0]['fecha']));
			$mesp        = strftime("%m",strtotime($contrato[0]['fecha']));
			$anop        = strftime("%Y",strtotime($contrato[0]['fecha']));
			$SQL_cobros  = generar_cobros($id_contrato,$id_glosa,$cant_cuotas,$monto_cuota,$monto_total,$diap,$mesp,$anop);
			consulta_sql($SQL_cobros);
		}
		
		if ($_REQUEST['mat_efectivo'] > 0 || $_REQUEST['mat_cheque'] > 0 || $_REQUEST['mat_tarj_cred'] > 0) {
			$id_glosa    = 1; // Matricula
      if ($contrato[0]['ano'] > date("Y")) { $id_glosa = 10001; } // matricula anticipada
			$cant_cuotas = 1;
			if ($_REQUEST['mat_efectivo'] > 0) {
				$monto_total = $_REQUEST['mat_efectivo'];
			} 
			elseif ($_REQUEST['mat_cheque'] > 0) {
				$monto_total = $_REQUEST['mat_cheque'];
			} 
			elseif ($_REQUEST['mat_tarj_cred'] > 0) {
				$monto_total = $_REQUEST['mat_tarj_cred'];
			}
			$monto_cuota = intval($monto_total/$cant_cuotas);
			$diap        = strftime("%d",strtotime($contrato[0]['fecha']));
			$mesp        = strftime("%m",strtotime($contrato[0]['fecha']));
			$anop        = strftime("%Y",strtotime($contrato[0]['fecha']));
			$SQL_cobros  = generar_cobros($id_contrato,$id_glosa,$cant_cuotas,$monto_cuota,$monto_total,$diap,$mesp,$anop);
			consulta_sql($SQL_cobros);
		}
	}
}

if (isset($_GET['insertPagos'])){
	$dbconn = db_connect();
	header('Content-type: application/json');
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$datos = ($request);

	$monto = $datos->monto;
	$cuotas = $datos->cuotas;
	$CodigoOperacion = $datos->CodigoOperacion;
	$idContrato = $datos->idContrato;


    if ($cuotas == 0) {

		$sql = "INSERT INTO finanzas.pagos(tarj_debito, nro_boleta_e, cod_operacion) VALUES 
			   (".$monto.",nextval('finanzas.pagos_nro_boleta_e_seq'::regclass), ".$CodigoOperacion.") RETURNING id"; 
		$result = pg_query($dbconn, $sql);

		$idPa = pg_fetch_array($result);
        $idPago = $idPa[0];


		if($result){ 
			$query = "SELECT id, monto FROM finanzas.cobros WHERE id_contrato = ".$idContrato."";
			$resultCobro = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());

			while ($row = pg_fetch_row($resultCobro)) {

				$sql = "INSERT INTO finanzas.pagos_detalle(id_pago, id_cobro, monto_pagado) VALUES 
				(".$idPago.",".$row[0].", ".$row[1].")"; 
		 		$result = pg_query($dbconn, $sql);

				$sqlUCobro = "UPDATE finanzas.cobros SET pagado= 'true' WHERE id =".$row[1]."";
				$resultUCobro = pg_query($dbconn, $sqlUCobro);
			}
		
			echo 1;
			}else{
				echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
			}
	}else{
		$sql = "INSERT INTO finanzas.pagos(tarj_credito, cant_cuotas_tarj_credito, nro_boleta_e, cod_operacion) VALUES 
		(".$monto.",".$cuotas.", nextval('finanzas.pagos_nro_boleta_e_seq'::regclass), ".$CodigoOperacion.") RETURNING id";

		$result = pg_query($dbconn, $sql);

		$idPa = pg_fetch_array($result);
        $idPago = $idPa[0];

		if($result){ 
			$query = "SELECT id, monto FROM finanzas.cobros WHERE id_contrato = ".$idContrato."";
			$resultCobro = pg_query($dbconn, $query) or die('La consulta fallo: ' . pg_last_error());

			while ($row = pg_fetch_row($resultCobro)) {

				$sql = "INSERT INTO finanzas.pagos_detalle(id_pago, id_cobro, monto_pagado) VALUES 
				(".$idPago.",".$row[0].", ".$row[1].")"; 
		 		$result = pg_query($dbconn, $sql);

				$sqlUCobro = "UPDATE finanzas.cobros SET pagado= 'true' WHERE id =".$row[1]."";
				$resultUCobro = pg_query($dbconn, $sqlUCobro);
			}
		
			echo 1;
			}else{
				echo "<br>Hubo un problema y no se guardó el archivo. " . pg_last_error($dbconn) . "<br/>";
			}
	}   
			//echo $result ;
		 pg_close($dbconn);
		
	}

//FUNCIÓN api_manager_agregar_alumno($rut) {
	if (isset($_GET['api_manager_agregar_alumno'])){

		$rut = $_GET['rut'];
		$token_api_manager = "gD7G3UkDK1E2woKQazzsG19ks39zdU6K43q9u62g8M1kyCZcq3";
		
		$SQL_alumno = "SELECT trim(a.rut) AS rut,a.apellidos||' '||a.nombres AS nombre,a.direccion,c.nombre AS comuna,r.nombre AS region,a.tel_movil,
							  CASE WHEN car.regimen IN ('POST-GD','POST-TD','DIP-D') THEN 'tescobdpi@corp.umc.cl' ELSE a.email END AS email, 
							  coalesce(pap.fecha_post,p2.fecha_post,now()::date) AS fecha_ingreso
					   FROM alumnos AS a
					   LEFT JOIN carreras AS car ON car.id=a.carrera_actual
					   LEFT JOIN comunas  AS c ON c.id=a.comuna
					   LEFT JOIN regiones AS r ON r.id=a.region
					   LEFT JOIN pap           ON pap.id=a.id_pap
					   LEFT JOIN pap      AS p2 ON p2.rut=a.rut
					   WHERE a.rut='$rut'
					   LIMIT 1";
		$alumno = consulta_sql($SQL_alumno);
	
		if (count($alumno) == 0) {
			$SQL_pap = "SELECT trim(rut) AS rut,apellidos||' '||nombres AS nombre,direccion,c.nombre AS comuna,r.nombre AS region,email,tel_movil,
							   fecha_post AS fecha_ingreso
						FROM pap
						LEFT JOIN comunas AS c ON c.id=pap.comuna
						LEFT JOIN regiones AS r ON r.id=pap.region
						WHERE rut='$rut'";
			$alumno = consulta_sql($SQL_pap);            
		}
	
		if (count($alumno) > 0) {
	
			extract($alumno[0]);
			
			$cliente_alumno = new SoapClient("https://api.manager.cl/sec/prod/clienteproveedor.asmx?WSDL",array('trace' => 1));
			
			$opts = array("ssl" => array("ciphers"=>'RC4-SHA', "verify_peer"=>false, "verify_peer_name"=>false));
	
			$params = array ("encoding"           => 'UTF-8', 
							 "verifypeer"         => false, 
							 "verifyhost"         => false,
							 "soap_version"       => SOAP_1_2, 
							 "trace"              => 1, 
							 "exceptions"         => 1, 
							 "connection_timeout" => 180, 
							 "stream_context"     => stream_context_create($opts));
	
	
			$cabecera = array("rutEmpresa"     => "73124400-6",
							  "token"          => $token_api_manager,
							  "rut"            => $rut,                  
							  "nombre"         => $nombre,
							  "dir"            => $direccion,
							  "comuna"         => $comuna,
							  "ciudad"         => $region,
							  "dirDespacho"    => $direccion,
							  "comunaDespacho" => $comuna,
							  "ciudadDespacho" => $region,
							  "email"          => $email,
							  "fono"           => $tel_movil,
							  "giro"           => "Estudiante",
							  "holding"        => "",
							  "nomFantasia"    => $nombre,
							  "clasif"         => 1,
							  "estado"         => 1,
							  "fax"            => "",
							  "emailSii"       => $email,
							  "clase1"         => "",
							  "clase2"         => "",
							  "clase3"         => "",
							  "clase4"         => "",
							  "fechacre"       => $fecha_ingreso,
							  "fecultcon"      => $fecha_ingreso,
							  "fecultvta"      => $fecha_ingreso,
							  "comentario"     => "",
							  "moneda"         => "$",                  
							  "monto"          => 0,
							  "desde"          => 0,
							  "bloquea"        => 0);
							  
			//var_dump($cabecera);
							  
			$alumno = $cliente_alumno -> InsertaCliente2($cabecera);
			return $alumno;
				
			//echo(msje_js($alumno));
		}
	}