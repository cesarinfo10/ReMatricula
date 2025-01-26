<?php

date_default_timezone_set("America/Santiago");
$fcha = date("Y-m-d");
?>

<head>

    <link rel="stylesheet" href="/sgu/ReMatriculaOnline/css/mat.css">
    <link rel="stylesheet" href="/sgu/MatriculaOnline/css/bootstrap.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" crossorigin="anonymous">
    
    <link href="/sgu/ReMatriculaOnline/assets/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="/sgu/ReMatriculaOnline/assets/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/sgu/ReMatriculaOnline/assets/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />
    <link href="/sgu/ReMatriculaOnline/js/switchery/dist/switchery.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--<link href="/sgu/ReMatriculaOnline/css/sgu.css" rel="stylesheet" type="text/css"> -->

   <!-- <link rel="stylesheet" href="/ReMatriculaOnline/css/mat.css">
    <link rel="stylesheet" href="/ReMatriculaOnline/css/bootstrap.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" crossorigin="anonymous">
    
    <link href="/ReMatriculaOnline/assets/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="/ReMatriculaOnline/assets/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/ReMatriculaOnline/assets/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />
    <link href="/ReMatriculaOnline/js/switchery/dist/switchery.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->

    <!--<link href="/ReMatriculaOnline/css/sgu.css" rel="stylesheet" type="text/css"> -->
</head>

<body>
  
<div class="container">
  <div id="idInsertMat">
  <table cellpadding="3" class="table table-bordered" border="0" align="center" cellspacing="2" width="800px">
    <tr>
      <th align="center" colspan="3" class="text-left Titulo1" width="100%"><h4 class="text-center">MATRICULATE ONLINE</h4>
      </th>
    </tr> 
    <tr>
      <th align="center" colspan="3" class="Titulo2" width="100%"><h5 class="text-center">Datos de Identidad</h5>
      </th>
    </tr>
    <tr>
 <br>
    </tr>   
      <tr>
        <td class="labelName" style="width: 50%" >
          <div class="row">
          <div class="col-xs-12">
          Rut:<br>
          <input type="text" name="idTxtNRut" align="right" id="idTxtNRut" maxlength="10" class='form-control boton' value="">
          </div>
          </div>
        </td>
 
      <td class="labelName" colspan="2">
        <div id="div_pasaporte" >
          ID:<br>
          <input type="text" style="width: 50%" name="idTxtid" align="right" maxlength="50" id="idTxtid" class='form-control boton' disabled>
        </div>
      </td>
    </tr>
 </table>
 <table cellpadding="3" class="table table-bordered" border="0" align="center" cellspacing="2" width="800px">
    <tr>
      <td class="labelName">
        Nombres:<br>
        <input type="text" name="texto_nombre" align="right" value="" maxlength="50" id="texto_nombre" class='form-control boton' 
          value="">
      </td>
      <td class="labelName">
        Apellidos:<br>
        <input type="text" name="texto_apellidos" align="right" value="" maxlength="50" id="texto_apellidos" 
          class='form-control boton' value="">
      </td>
    </tr>
    </table>
    
 <table cellpadding="3" class="table table-bordered" border="0" align="center"  cellspacing="2" width="800px">
    <tr>
      <td class="labelName">
        Dirección: <br>
        <input type="text" name="texto_dir" align="right" value="" maxlength="200" id="texto_dir" 
        class='form-control boton'>
</td>
      </tr>
      </table>

      <table cellpadding="3" class="table table-bordered" border="0" align="center" cellspacing="2" width="800px">
      <tr>
      <th align="center" colspan="3" class="Titulo2" width="100%"><h5 class="text-center">Carrera que se Matricula</h5>
      </th>
    </tr>
    <tr>
      <td class="labelName" colspan="3">
        Carreara: <br>
        <input type="text"  name="" align="right" value="" maxlength="200" id="" 
        class='form-control boton'>
</td>
      </tr>
      <tr>
      <td class="labelName" style="width: 33.4%">
        Estado Civil: <br>

     <select class="shadow-lg p-1 bg-white form-control"  name="ddl_estadoCivil" id="ddl_estadoCivil" style="visibility: visible;" onchange ="updatePreMatricula()">
          <option value="0">Seleccione</option>
            <option value="S" class="1">Soltero</option>
            <option value="C" class="1">Casado</option>
            <option value="D" class="1">Divorciado</option>
            <option value="U" class="1">AUC</option>
        </select>
      </td>
      <td class="labelName" style="width: 33.4%">
        Genero: <br>
        <select class="shadow-lg p-1 bg-white form-control" id="ddl_genero" name="ddl_genero" style="visibility: visible;" onchange ="updatePreMatricula()">
          <option value="0">Seleccione</option>
            <option value="m" class="1">Hombre</option>
            <option value="f" class="2">Mujer</option>
            <option value="o" class="3">Otro</option>
        </select>
      </td>
      <td class="labelName">
          Nacionalidad:<br>
          <div id="ddl_paises"></div>
       
      </td>
    </tr>
    </table>
 <table cellpadding="3" class="table table-bordered" border="0" align="center" cellspacing="2" width="800px">
    <tr>
      <td class="labelName" colspan = "2">
        Dirección:<br>
        <input type="text" name="texto_direccion" align="right" value="" maxlength="200" id="texto_direccion" 
          class='form-control boton' onblur="updatePreMatricula()">
      </td>
    </tr>
    
    <tr>
      <td class="labelName" style="width: 50%">
      Region:<br>
          <div id="ddl_region"></div>
      </td style="width: 50%">
      <td class="labelName">
      Comuna:<br>
          <div id="ddl_comuna"></div>
       
      </td>
    </tr>
  <tr>
      <td class="labelName" style="width: 50%">
          Vía de Admisión:<br>
          <div id="ddl_admisiones"></div>

      </td style="width: 50%">
      <td class="labelName" id="instConv">
          Institución Origen:<br>
          <div id="ddl_convalidantes"></div>
       
      </td>
    </tr>



    <tr>
      <td class="labelName" style="width: 50%">
          Jornada:<br>
        <select class="shadow-lg p-1 bg-white form-control" name="jornada" id="jornada" onchange="llamarProgCarrera();" style="visibility: visible;">
          <option value="0">Seleccione</option>
            <option value="D" class="1">Diurno</option>
            <option value="V" class="2">Vespertino</option>
        </select>
       
      </td>
      <td class="labelName" style="width: 50%">
          Carrera/Programa<br>
          <div id="ddl_carreras">
          <select class="shadow-lg p-1 bg-white form-control" style="visibility: visible;">
          <option value="0">Seleccione</option>

        </select>
          </div>
       
      </td>
    </tr>



    <tr>
    <td class="labelName" >
        Modalidad:<br>
        <input type="text" name="texto_modalidad" align="right" value="" maxlength="200" id="texto_modalidad" class='form-control boton' disabled>
      </td>
     <td class="labelName" >
        Régimen:<br>
        <input type="text" name="texto_regimen" align="right" value="" maxlength="200" id="texto_regimen" class='form-control boton' disabled>
     </td>
    </tr>
    <tr>
  
     <td  class="labelName">
     Becas:<br>
          <div id="ddl_becas"></div>

     </td>
     <td  align="center" colspan="">
     <input type="button" class="btn btn-success" name="btnGrabaPaso1" id="btnGrabaPaso1" value="Guardar" onclick="validarIncertar()" />  

     </td>
    </tr>
</table>
</div>
</form>
<br/>

<!-- --------------------------- ARCHIVOS --------------------------- -->
<div id="tblArchivos">
<br/>
<table cellpadding="2" class="table table-bordered" border="0" align="center" cellspacing="2" width="800px">
<tr>
<td align="center" colspan = "2" class="Titulo2" width="50%"><h5 class="text-center">Documentos Obligatorios</h5></td>
<tr>
      <td align="center"  class="Titulo2" width="50%"><h5 class="text-center">Documentos</h5>
      <select class="shadow-lg p-1 bg-white form-control" id="ddl_archivos" onchange="llamarTipoDoc();" name="ddl_archivos" style="visibility: visible;">
                <option value="0">Seleccione</option>
                  <option value="Extraordinaria" class="1">Convalidaciones</option>
                  <option value="Prosecución" class="2">Licenciaturas</option>
                  <option  value="Regular" class="2">Regular</option>
              </select>

    </td>
    <td align="center"  class="Titulo2" width="50%"><h5 class="text-center">Tipos Documentos</h5>
        <div id="subArchivos"></div>
    </td>
      
    </tr>
<tr>
      <td class="labelName text-center" colspan="2">
      <label for="docAlmunReg"><div id="textoAdjunto"></div></label><br>
      <input type="file" id="docUdate" onchange="return fileValidation()" accept=".jpg, .jpeg, .pdf"> 

      </td>

    </tr>
</table>

<div id="ddl_tableArchivo"></div>

<br/>
<table cellpadding="2" class="table table-bordered" border="0" id="tblDeclaro" align="center" cellspacing="2" width="800px">
<tr>
      <td class="Titulo2" width="50%"><h5><input type="checkbox" class="form-check-input" onclick="habilitarTblArchivosPago();" id="contratoAcept" style="width: 20px; height: 20px; margin-left: 0.1%"> &nbsp&nbsp&nbsp Declaro que los datos presentados son fidedignos y quedan sujetos a cambios según la documentación solicitada</h5>
      
 <br/>
      </td>
<tr>
</table>


</div>
<br/>
<!-- --------------------------- PAGOS --------------------------- -->
<div id="tblPagos">
<table cellpadding="2" class="table table-bordered" border="0" align="center" cellspacing="2" width="800px">
<tr>
<tr>
<td align="center"  class="Titulo2" colspan="4" ><h5 class="text-center">Forma de Pago</h5></td>
</tr>
<tr>
  <td align="center"  class="Titulo2" colspan="2" >
  <button class="btn btn-light" style="height :95; width:280" onclick="webPagar(1)" id="btnWebPay"> <img src="assets/img/webpay.png"/></button>
  </td>
      <td align="center"  class="Titulo2" colspan="2" >

      <button class="btn btn-light" style="height :95; width:280" onclick="webPagar(2)" id="btnOtrosPay"> <img src="assets/img/otros.png"/></button>
      <!--<select class="shadow-lg p-1 bg-white form-control" id="ddl_TipoPago" onchange="llamarTipoDocMat(); insertarAnualContrato(3)" name="ddl_TipoPago" style="visibility: visible;">
                <option value="0">Seleccione Forma de Pago</option>
                  <option value="1">Webpay</option>
                  <option value="2">Otros</option>
              </select>-->

    </td>
    <tr>
      <td colspan="4" >
      <div class="alert alert-warning" id="idAvisoCon">
    <strong>Atención!</strong> Usted está seleccionando pago en cuotas con crédito interno de la UMC. Debe descargar el contrato y el pagaré, firmarlo y enviarlos al correo: admisiononline@corp.umc.cl.
    Los contratos son semestrales<a href="#" class="alert-link"> por tanto el contrato que usted aprobará corresponde  al 50% del arancel anual.</a>.
  </div>
      </td>
    </tr>
    </tr>
    <tr id="Mat">
        <td>Valor Matricula: <input type="text" name="" class='form-control boton' value=""  id="matAnual" class='boton' disabled></td>
        <td>Valor Arancel: <input type="text" name="" class='form-control boton' value=""  id="aranAnual" class='boton' disabled></td>
        <td>Total Matricula: <input type="text" name="" class='form-control boton' value=""  id="DesMatAnual" class='boton' disabled></td>
        <td>Total Arancel: <input type="text" name="" class='form-control boton' value=""  id="desAranAnual" class='boton' disabled></td>
    </tr>
    <tr id="MatPay">
    
    <td  colspan="2" class="text-danger"><strong>TOTAL A PAGAR: </strong> <input type="text" name="" class='form-control boton' value=""  id="totalFinalAnual" class='boton' disabled></td>
    <!--<button type="button" class="btn btn-danger" onclick="pagarMatricula();">$ PAGAR</button>-->
    <td align="center" colspan="2" >
    <button type="button" class="btn btn-danger" onclick="insertarAnualContrato(1,1);">$ PAGAR</button>
    </td>

    </tr>
    <tr id="otros">
        <td>Valor Matricula: <input type="text" name="" class='form-control boton' value=""  id="matSemestral" class='boton' disabled></td>
        <td>Valor Arancel: <input type="text" name="" class='form-control boton' value=""  id="aranCreditoSemes" class='boton' disabled></td>
        <td>Total Matricula: <input type="text" name="" class='form-control boton' value=""  id="DesMatSemestral" class='boton' disabled></td>
        <td>Total Arancel: <input type="text" name="" class='form-control boton' value=""  id="desAranCreditoSemes" class='boton' disabled></td>
    </tr>
    <tr id="otrosPay">
    <td  colspan="2" class="text-danger"><strong>TOTAL A PAGAR: </strong> <input type="text" name="" class='form-control boton' value=""  id="totalFinalSemes" class='boton' disabled></td>
    <!--<button type="button" class="btn btn-danger" onclick="pagarMatricula();">$ PAGAR</button>-->
    <td align="center" colspan="2" >
    <button type="button" class="btn btn-danger" onclick="insertarAnualContrato(2,2);">PAGARÉ</button>
   <!-- <button type="button" class="btn btn-danger" onclick="insertarContrato();">$ PAGAR</button>-->
    </td>
    </tr>
</table>
</div>
<br>

  <div id="contratoPagareDes">
<table cellpadding="2" class="table table-bordered" border="0" align="center" cellspacing="2" width="800px">
<tr>
  <td class="Titulo2 text-center" width="50%">
      <button class="btn btn-info"  id="contratoDes" onclick="imprimirContrato();">Descargar Contrato</button> 
      <button class="btn btn-info"  id="pagareImpde" onclick="imprimirPagare();">Descargar Pagare</button> 
      
 <br/>
      </td>
<tr>
</table>
</div>

<br>
<table cellpadding="2" class="table table-bordered" border="0" align="center" cellspacing="2" width="800px">
<tr>
<tr>
      <td align="center"  class="Titulo2" colspan="2" >
      <button type="button" id="btnSubir" onclick="finalizarCarga()" class="btn btn-default boton">Finalizar o Salir</button> 

    </td>
    </tr>
  </table>

  <table cellpadding="2" class="table table-bordered" border="0" id="tblDeclaro" align="center" cellspacing="2" width="800px">
<tr>
      <td class="Titulo2" width="50%" align="center"><h6>Soporte</h6>
      <h6> <i class="fas fa-envelope"></i>: <a href="mailto:cecheverria@corp.umc.cl">cecheverria@corp.umc.cl</a></h6>
                   <h6> <i class="fas fa-phone"></i>: 229273401</h6>
<tr>
</table>

</div>

</body>

<!-- MATRICULA ANUAL web-->


<br/>
<br/>
<!-- MATRICULA SEMESTRAL otros-->
<input type="hidden" name=""  value="" size="20" id="matSemestral" class='boton'>
<input type="hidden" name=""  value="" size="20" id="aranCreditoSemes" class='boton'>

<!-- ESTE ID SE DEBE REPLAZAR, POR AHORA ESTA EN DURO-->
<input type="hidden" name=""  value="1478" size="20" id="idUsuario" class='boton'>
<!-- ESTE ES ID CARRERA-->
<input type="hidden" name="id_carrera"  value="" size="20" id="id_carrera" class='boton'>

<!-- DESCUENTOS  BECA MATRICULAS-->
<input type="hidden" name=""  value="" size="20" id="dscto_pregrado_mat" class='boton'>
<input type="hidden" name=""  value="" size="20" id="dscto_pregrado_ara" class='boton'>
<input type="hidden" name=""  value="" size="20" id="dscto_licenciatura_mat" class='boton'>
<input type="hidden" name=""  value="" size="20" id="dscto_licenciatura_ara" class='boton'>

<!-- DESCUENTOS  OFERTA MATRICULA-->
<input type="hidden" name=""  value="" size="20" id="porcentaje_becas_mat" class='boton'>
<input type="hidden" name=""  value="" size="20" id="porcentaje_becas_ara" class='boton'>
<div class="row">
<input type="hidden" name="idTxtNDocumento" align="right" onkeyup="validarDoc('idTxtNDocumento');" maxlength="9" id="idTxtNDocumento" class='form-control boton' value="" >

<!-- The Modal -->

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalContrato" id="modalOtros">Modal</button>
<div class="modal" id="modalContrato">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
      <img src="login/assets/img/logo-universidad-miguel-de-cervantes-umc_sesion.png" alt="LOGO">
      <br/>
     
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <h5 class="modal-title text-center"> El pago ha sido Aprobado!</h5>
      <!-- Modal body -->
      <div class="modal-body text-center">
      <p>Usted está seleccionando pago en cuotas con crédito interno de la UMC. Debe descargar<br/>
         el contrato y el pagaré, firmarlo y enviarlos al correo: admisiononline@corp.umc.cl. <br/>
         Los contratos son semestrales por tanto el moneto que usted aprobará corresonde al 50% del arancel anual.</p> 
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      <button class="btn btn-info" onclick="imprimirContrato();">Descargar Contrato</button> 
      <button class="btn btn-info" id="pagareImp" onclick="imprimirPagare();">Descargar Pagare</button> 
      <button class="btn btn-danger" onclick="borrarSalir();">Salir</button>
      </div>

    </div>
  </div>
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalContratoDes" id="modalDescarga">Modal</button>
<div class="modal" id="modalContratoDes">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
      <img src="login/assets/img/logo-universidad-miguel-de-cervantes-umc_sesion.png" alt="LOGO">
      <br/>
     
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <h5 class="modal-title text-center"> ¡¡Atención!!</h5>
      <!-- Modal body -->
      <div class="modal-body text-center">
      <p>Usted ya está registrado en nuestra base de datos, por favor revise que no falte algún paso por completar. </p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">

      <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>

    </div>
  </div>
</div>

<script src="/sgu/ReMatriculaOnline/js/jquery-1.10.1.min.js"></script>
<script src="/sgu/ReMatriculaOnline/js/matricula.js"></script>
<script src="/sgu/ReMatriculaOnline/js/test.js"></script>
<script src="/sgu/ReMatriculaOnline/js/switchery/dist/switchery.min.js"></script>
<script src="/sgu/ReMatriculaOnline/assets/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
<script src="/sgu/ReMatriculaOnline/js/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/sgu/ReMatriculaOnline/assets/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!--<script src="/ReMatriculaOnline/js/jquery-1.10.1.min.js"></script>
<script src="/ReMatriculaOnline/js/matricula.js"></script>
<script src="/ReMatriculaOnline/js/test.js"></script>
<script src="/ReMatriculaOnline/js/switchery/dist/switchery.min.js"></script>
<script src="/ReMatriculaOnline/assets/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
<script src="/ReMatriculaOnline/js/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script src="/ReMatriculaOnline/assets/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>-->
