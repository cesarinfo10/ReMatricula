let urlApp = "http://localhost/";


window.addEventListener("beforeunload", function (e) {
  if (localStorage.getItem('idContrato') == ''|| localStorage.getItem('idContrato') == 'null' || localStorage.getItem('idContrato') == undefined){
  var confirmationMessage = "\o/";

  (e || window.event).returnValue = confirmationMessage; //Gecko + IE
  return confirmationMessage;                            //Webkit, Safari, Chrome
  }
});


$(document).ready(function(){
  if (localStorage.getItem('email') == ''||localStorage.getItem('email') == 'null' || localStorage.getItem('email') == undefined){
  //location.href="https://matriculate.umc.cl/sgu/MatriculaOnline/";
  }
  precarga();
  llamarPais();
  llamarAdmision();
  llamarInstitucion();
  llamarcomunas();
  llamarRegiones();
  llamarBecas();
  //validarFCH();
  
  $('#modalOtros').hide();
  $('#modalDescarga').hide();
  $("#docAlmunReg").prop('disabled', true);
  //$("#btnSubir").prop('disabled', true);
  $('#docSubir').hide(2000);

  $('#Mat').hide();
  $('#MatPay').hide();
  $('#otros').hide();
  $('#otrosPay').hide();
  
  $('#tblArchivos').hide();
  $('#tblPagos').hide();
  $('#idAvisoCon').hide();
  $('#contratoPagareDes').hide();
  cambiarDoc();
  
});

function cambiarDoc(){
  setTimeout(() => {    
      if($("#ddl_viaAdmision").val() == 1){
        $("#ddl_archivos").val('Regular');
        llamarTipoDoc();
      }else if($("#ddl_viaAdmision").val() == 2){
        $("#ddl_archivos").val('Extraordinaria');
        llamarTipoDoc();
      }else if($("#ddl_viaAdmision").val() == 4){
        $("#ddl_archivos").val('Prosecución');
        llamarTipoDoc();
      }else{
        $("#ddl_archivos").val('0')
      }
    }, "2000");

}
function precarga(){
  let email= localStorage.getItem('email')
  $.ajax({
    type: "GET",
    url: "function/funcionesSelect.php?getOnePreCarga",
    data:"email="+email,
    success:function(data){

     console.log(data)
     if($("#idTxtNRut").val() != '' || $("#idTxtNRut").val() != null)
     {
      $("#id_tipoDocumento").val('R');
      document.getElementById("div_pasaporte").style.display="none";  
     }
    if(data[77]=="pap" && data[77]!=undefined){
      if(data[78]!='' || data[78] != null ||  data[78] != undefined){
        localStorage.setItem("idContrato", data[78]);
      }
      
      if(data[79]!='' || data[79] != null ||  data[79] != undefined){
        localStorage.setItem("idPagare", data[79]);
      }

      if (localStorage.getItem('idContrato') =='' ||localStorage.getItem('idContrato') == 'null' || localStorage.getItem('idContrato') == undefined){
        $('#contratoDes').hide();
        $('#contratoPagareDes').hide();
        $('#tblDeclaro').show();
      }else{
        $('#contratoDes').show();
        $('#contratoPagareDes').show();
        $('#tblDeclaro').hide();
      }

      if (localStorage.getItem('idPagare') == ''||localStorage.getItem('idPagare') == 'null' || localStorage.getItem('idPagare') == undefined){
        $('#pagareImpde').hide();
      }else{
        $('#pagareImpde').show();
      }
    
      $('#modalDescarga').click();
      if (localStorage.getItem('idMatricula') == ''||localStorage.getItem('idMatricula') == 'null' || localStorage.getItem('idMatricula') == undefined){
      localStorage.setItem("idMatricula", (data[0].trim()));
      }
      $("#idTxtNRut").val(data[1].trim());
      $("#idTxtNDocumento").val(data[0].trim());
      $("#texto_nombre").val(data[2].trim());
      localStorage.setItem("nombre", data[2].trim());
      $("#texto_apellidos").val(data[3].trim());
      localStorage.setItem("apellido", data[3].trim());
      $("#texto_email").val(data[11].trim());
      $("#texto_celular").val(data[13].trim());
      $("#texto_fnacimiento").val(data[5].trim());
    //  localStorage.setItem("fnacimiento", data[5].trim());
      $("#ddl_estadoCivil").val(data[42].trim());
      $("#ddl_genero").val(data[4].trim());
      $("#ddl_pais").val(data[6].trim());
      $("#texto_direccion").val(data[8].trim());
      $("#jornada").val(data[43].trim());
      $("#jornada").val(data[43].trim());
      llamarProgCarrera(data[43]);
     //ddl_beca
      setTimeout(() => {    
      $("#ddl_regiones").val(data[10].trim());
      $("#ddl_comunas").val(data[9].trim());
      $("#ddl_viaAdmision").val(data[22].trim());
      $("#ddl_carrera").val(data[19].trim());
      $("#ddl_beca").val(data[36]);
      mostraSaldo();
      llamarOfertaMatricula();
      
     
      }, "1000");   
      setTimeout(() => {    
        bloqeuoData();
        llamarTableDoc();
        }, "2000");     

        $('#tblArchivos').show();
       // $('#tblPagos').show();
        $('#idAvisoCon').show();

      //  validaRUT();
      
    }else{
    $("#idTxtNRut").val(data[1].trim());
     $("#idTxtNDocumento").val(data[2].trim());
     $("#texto_nombre").val(data[4].trim());
     localStorage.setItem("nombre", data[4].trim());
     $("#texto_apellidos").val(data[5].trim());
     localStorage.setItem("apellido", data[5].trim());
     $("#texto_email").val(data[6].trim());
     $("#texto_celular").val(data[7].trim());
     bloqeuoDataSesion();
    }
 
  }
})
}

function validarFCH(){
  const hoy = new Date();
  const anoActual = hoy.getFullYear();

  var fecha2 = $("#texto_fnacimiento").val();
  var nac= fecha2.substr(-20, 4);

  var diff = parseInt(anoActual) - parseInt(nac);
  console.log(diff);
  if(diff < 18){
    Swal.fire(
      'A ocurrido un error!',
      'La fecha de nacimiento es menor a lo requerido',
      'error'
    )
  }

}
function bloqeuoData(){
  
  $("#id_tipoDocumento").prop('disabled', true);
  $("#ddl_estadoCivil").prop('disabled', true);
  $("#idTxtNRut").prop('disabled', true);
  $("#idTxtNDocumento").prop('disabled', true);
  $("#texto_nombre").prop('disabled', true);
  $("#texto_apellidos").prop('disabled', true);
  $("#texto_email").prop('disabled', true);
  $("#texto_celular").prop('disabled', true);
  $("#texto_fnacimiento").prop('disabled', true);
  $("#ddl_genero").prop('disabled', true);
  $("#ddl_pais").prop('disabled', true);
  $("#texto_direccion").prop('disabled', true);
  $("#ddl_regiones").prop('disabled', true);
  $("#ddl_comunas").prop('disabled', true);
  $("#ddl_viaAdmision").prop('disabled', true);
  $("#ddl_carrera").prop('disabled', true);
  $("#ddl_beca").prop('disabled', true);
  $("#jornada").prop('disabled', true);
  $("#btnGrabaPaso1").prop('disabled', true);
  $("#ddl_archivos").prop('disabled', true);
  //
  
}
function bloqeuoDataSesion(){
  
  $("#id_tipoDocumento").prop('disabled', true);
  $("#idTxtNRut").prop('disabled', true);
  $("#idTxtNDocumento").prop('disabled', true);
  $("#texto_nombre").prop('disabled', true);
  $("#texto_apellidos").prop('disabled', true);
  $("#texto_email").prop('disabled', true);
  $("#texto_celular").prop('disabled', true);

  

}
function mostrarDoc(i){

    if(i == 2){
      $('#docSubir').show(2000);
    }else{
      $('#docSubir').hide(2000);
    }
   }

   function llamarTipoDocMat(valFP){
    let i= valFP;
    if(i == 1){
      $('#Mat').show(2000);
      $('#MatPay').show(2000);
      $('#otros').hide(2000);
      $('#otrosPay').hide(2000);
      $('#idAvisoCon').hide(2000);
    }else{
      $('#otros').show(2000);
      $('#otrosPay').show(2000);
      $('#Mat').hide(2000);
      $('#MatPay').hide(2000);
      $('#idAvisoCon').show(2000);
    }

   }

function habilitarTblArchivos(){
 
    $('#tblArchivos').show(2000);
    //$("#btnGrabaPaso1").prop('disabled', false);
}

function habilitarTblArchivosPago(){
  /* VERIFICAR CANTIDAD DE DOCUMENTOS*/ 
  if ($('#contratoAcept').prop('checked')== true){
  let filas = $("#docArchivos").find('tbody tr').length;
  console.log(filas);
  
  let id_tipo = $("#ddl_archivos").val();
    $.ajax({
      type: "GET",
      url: "function/funcionesSelect.php?getNumDoc&id_tipo="+id_tipo ,
      data:"",
      success:function(data){
        if (data != filas){
          let total = data - filas;
          Swal.fire(
            'Atención!',
            'Faltan '+total+ ' de un total de '+data+' documentos por cargar.',
            'info'
          );
          $('#contratoAcept').prop('checked', false);
            return false;
        }else{
          if((document.getElementById("contratoAcept").checked) ==true ){
            $('#tblPagos').show(2000);
            var rut = $("#idTxtNRut").val()
            $.ajax({
              type: "GET",
              url: "function/funcionInsertarFinanza.php?llenarImgPat&rut="+rut.trim(),
              data:"",
              success:function(msg){
              // $("#ddl_paises").html(msg);
            }})
            
          }else{
            $('#tblPagos').hide();
          }
        }
  
        
       //$("#ddl_paises").html(msg);
    }});
  }
   /* */
  }
function llamarPais(){
      $.ajax({
        type: "GET",
        url: "function/funcionesSelect.php?getAllPais",
        data:"",
        success:function(msg){
         $("#ddl_paises").html(msg);
      }})
   }

   function llamarTipoDoc(){
    let tipo_admision = $("#ddl_archivos").val();
    $.ajax({
        type: "GET",
        url: "function/funcionesSelect.php?getAllTipoDoc&tipo_admision=" +tipo_admision,
        data:"",
        success:function(msg){
         $("#subArchivos").html(msg);
      }})
   }

   function llamarAdmision(){
      $.ajax({
        type: "GET",
        url: "function/funcionesSelect.php?getAllAdmision",
        data:"",
        success:function(msg){
         $("#ddl_admisiones").html(msg); 
         $('#instConv').hide();
      }})
   }
 
   function llamarInstitucion(){
      $.ajax({
        type: "GET",
        url: "function/funcionesSelect.php?getAllInstitucion",
        data:"",
        success:function(msg){
         $("#ddl_convalidantes").html(msg);
         llamarSelect();
      }})
   }
/*=============================================
LLAMAR BECAS
=============================================*/
   function llamarBecas(){
    $.ajax({
      type: "GET",
      url: "function/funcionesSelect.php?getAllBeca",
      data:"",
      success:function(msg){
       $("#ddl_becas").html(msg);
       
    }})
 }

 /*=============================================
LLAMAR BECAS
=============================================*/
function llamarBecasOne(){
  $.ajax({
    type: "GET",
    url: "function/funcionesSelect.php?getAllBeca",
    data:"",
    success:function(msg){
     $("#ddl_becas").html(msg);
     
  }})
}
/*=============================================
LLENAR CAMPOS BECA
=============================================*/
 function llenarCamposBecaMatriculas(){
  const dscto_pregrado_mat = $("#ddl_beca option:selected").attr("dscto_pregrado_mat");
  const dscto_pregrado_ara = $("#ddl_beca option:selected").attr("dscto_pregrado_ara");
  const dscto_licenciatura_mat = $("#ddl_beca option:selected").attr("dscto_licenciatura_mat");
  const dscto_licenciatura_ara = $("#ddl_beca option:selected").attr("dscto_licenciatura_ara");

  $('#dscto_pregrado_mat').val(dscto_pregrado_mat);
  $('#dscto_pregrado_ara').val(dscto_pregrado_ara);
  $('#dscto_licenciatura_mat').val(dscto_licenciatura_mat);
  $('#dscto_licenciatura_ara').val(dscto_licenciatura_ara);

 }
/*=============================================
LLAMAR OFERTAS MATRICULA
=============================================*/
 function llamarOfertaMatricula(){

  let cod_jornada = $("#jornada").val();
  let cod_carrera = $("#ddl_carrera").val();

  $.ajax({
    type: "GET",
    url: "function/funcionesSelect.php?getOneOfetaMat",
    data:"cod_jornada="+cod_jornada+"&cod_carrera="+cod_carrera,
    success:function(data){

     console.log(data)
     if(data != '' || data != null || data != false){
      $("#porcentaje_becas_mat").val(data[2]);
      $("#porcentaje_becas_ara").val(data[3]);
     }else{
      $("#porcentaje_becas_mat").val(0);
      $("#porcentaje_becas_ara").val(0);
     }
     
  }
})
}
/*=============================================
LLAMAR PROG. CARRERAS
=============================================*/
function llamarProgCarrera(idJornada){

  if (idJornada != null || idJornada != undefined){
   jornada = idJornada;
  }else{
   jornada = $("#jornada").val();
  }
  
    $.ajax({
      type: "GET",
      url: "function/funcionesSelect.php?getAllCarrProg&jornada="+jornada,
      data:"",
      success:function(msg){
       $("#ddl_carreras").html(msg);
    }})
 }
  
   function llamarTableDoc(){
    let idTxtNRut = $("#idTxtNRut").val();
      $.ajax({
        type: "GET",
        url: "cargaArchivo.php?getDocForUser&idTxtNRut="+idTxtNRut,
        data:"",
        success:function(msg){
         $("#ddl_tableArchivo").html(msg);
      }})
   }
   function mostraSaldo(){

    const id = $("#ddl_carrera option:selected").attr("id");
    const modalidad = $("#ddl_carrera option:selected").attr("modalidad");
    const regimen = $("#ddl_carrera option:selected").attr("regimen");
    const matricula_anual = $("#ddl_carrera option:selected").attr("matricula_anual");
    const arancel_contado_anual = $("#ddl_carrera option:selected").attr("arancel_contado_anual");
    const matricula_semestral = $("#ddl_carrera option:selected").attr("matricula_semestral");
    const arancel_credito_semestral = $("#ddl_carrera option:selected").attr("arancel_credito_semestral");

    
    matricula_anualCL = new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(matricula_anual);
    arancel_contado_anualCL = new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(arancel_contado_anual);
    
    matricula_semestralCL = new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(matricula_semestral);
    arancel_credito_semestralCL = new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(arancel_credito_semestral);

    $("#matAnual").val(matricula_anualCL);
    $("#aranAnual").val(arancel_contado_anualCL);

    $("#matSemestral").val(matricula_semestralCL);
    $("#aranCreditoSemes").val(arancel_credito_semestralCL);

    $("#texto_modalidad").val(modalidad);
    $("#texto_regimen").val(regimen);
    $("#id_carrera").val(id);


   }

   function mostraSubirArchivo(){
    $("#docAlmunReg").prop('disabled', false);
    //$("#btnSubir").prop('disabled', false);
    const txt = $("#ddl_Subirarchivo option:selected").attr("nombre");
    $("#textoAdjunto").text(txt);
   }

   function mostrarInstituciones(){
   // alert('El valor es: ' + $("#ddl_viaAdmision").val())
    if($("#ddl_viaAdmision").val() == 2){
      $('#instConv').show(2000);
    }else{
      $('#instConv').hide(2000);
      $("#ddl_convalidante").val('0');
    }
   }


   function llamarcomunas(){
    $.ajax({
      type: "GET",
      url: "function/funcionesSelect.php?getAllComunas",
      data:"",
      success:function(msg){
       $("#ddl_comuna").html(msg);
    }})
 }

 function llamarRegiones(){
  $.ajax({
    type: "GET",
    url: "function/funcionesSelect.php?getAllRegion",
    data:"",
    success:function(msg){
     $("#ddl_region").html(msg);
  }})
 }
/*=============================================
VALIDAR EXTENSIÓN DE ARCHIVOS
=============================================*/
 function fileValidation(){
  var fileInput = document.getElementById('docUdate');
  var filePath = fileInput.value;
  var allowedExtensions = /(.jpg|.jpeg|.pdf)$/i;
  if(!allowedExtensions.exec(filePath)){
      Swal.fire(
        'A ocurrido un error!',
        'Solo puede cargar archivos .jpeg/.jpg/.pdf ',
        'error'
      );
      fileInput.value = '';
      return false;
  }else{       
     // SubirArchivo(allowedExtensions.exec(filePath)[0]);
      SubirArchivo();
  }
}
/*=============================================
INSERTAR ARCHIVOS
=============================================*/

function SubirArchivo() {
  var file = document.getElementById("docUdate").files[0]

  if($("#idTxtNRut").val() == '' || $("#idTxtNRut").val() == null
  ||$("#ddl_Subirarchivo").val() == '' || $("#ddl_Subirarchivo").val() == null
  ||$("#docUdate").val() == '' || $("#docUdate").val() == null
  ||$("#idUsuario").val() == '' || $("#idUsuario").val() == null
){
Swal.fire(
'A ocurrido un error!',
'No se puedo insertar datos, porque existen campos vacios',
'error'
);

file.value = '';
return false;
}else{

  let rut = $("#idTxtNRut").val();
  let id_tipo = $("#ddl_Subirarchivo option:selected").attr("tipo");
  let id_usuario = $("#idUsuario").val();
  
  var form = new FormData();
  form.append('file', file);
  form.append('rut', rut);
  form.append('id_tipo', id_tipo);
  form.append('id_usuario', id_usuario);

  $.ajax({
      url: "cargaArchivo.php?insertArchivo",
      type: "POST",
      cache: false,
      contentType: false,
      processData: false,
      mimeType: "multipart/form-data",

      data : form,
      success: function(data) {
                
        if (data == 1){                      
          Swal.fire(
              'Operación exitosa!',
              'El archivo se cargo correctamente'
          );
          llamarTableDoc();
          $("#docUdate").val('')
        }else if(data == 3){
          Swal.fire(
              'A ocurrido un error!',
              'Este documento ya fue ingresado',
              'error'
            );
            file.value = '';
            llamarTableDoc();
            $("#docUdate").val('')
        }else{
          Swal.fire(
            'A ocurrido un error!',
            'No se puedo ingresar la matricula',
            'error'
          );
          file.value = '';
          llamarTableDoc();
          $("#docUdate").val('')
        }
         
      }
  });
}
}
/*=============================================
VALIDACIONES
=============================================*/
function validarIncertar(){
  

var correo = $("#texto_email").val();
var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

const hoy = new Date();
const anoActual = hoy.getFullYear();

var fecha2 = $("#texto_fnacimiento").val();
var nac= fecha2.substr(-20, 4);

var diff = parseInt(anoActual) - parseInt(nac);


if($("#idTxtNRut").val() == '' || $("#idTxtNRut").val() == null)
{
  Swal.fire(
  'A ocurrido un error!',
  'No se puedo insertar datos, El campo RUT esta vacio',
  'error'
);
   return false;
}else if ($("#id_tipoDocumento").val() == '0'){
  Swal.fire(
    'A ocurrido un error!',
    'No se puedo insertar datos, No ha seleccionado Tipo de documentos de identidad',
    'error'
  );
     return false;
  }else if($("#texto_nombre").val() == '' || $("#texto_nombre").val() == null){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, El campo Nombre esta vacio',
      'error'
    );
       return false;
  }else if($("#texto_apellidos").val() == '' || $("#texto_apellidos").val() == null){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, El campo Apellido esta vacio',
      'error'
    );
       return false;
  }else if (correo == '' || correo == null){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, El campo Correo electrónico esta vacio',
      'error'
    );
    return false;
  }else if ($("#texto_celular").val() == '' || $("#texto_celular").val() == null){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, El campo Correo electrónico esta vacio',
      'error'
    );
    return false;
  }else if ($("#texto_fnacimiento").val() == '' || $("#texto_fnacimiento").val() == null){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, El campo Fecha de nacimiento esta vacio',
      'error'
    );
    return false;
  }else if($("#ddl_estadoCivil").val() == '0'){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, No ha seleccionado un Estado Civil',
      'error'
    );
       return false;
  }else if($("#ddl_genero").val() == '0'){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, No ha seleccionado un Genero',
      'error'
    );
       return false;
  }else if ($("#texto_direccion").val() == '' || $("#texto_direccion").val() == null){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, El campo Dirección esta vacio',
      'error'
    );
    return false;
  }else if($("#ddl_regiones").val() == '0'){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, No ha seleccionado una Region',
      'error'
    );
       return false;
  }else if($("#ddl_comunas").val() == '0'){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, No ha seleccionado una Comuna',
      'error'
    );
       return false;
  }else if($("#ddl_viaAdmision").val() == '0'){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, No ha seleccionado Vía de Admisión',
      'error'
    );
       return false;
  }else if($("#jornada").val() == '0'){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, No ha seleccionado una Jornada',
      'error'
    );
       return false;
    }else if($("#ddl_carrera").val() == '0'){
  Swal.fire(
    'A ocurrido un error!',
    'No se puedo insertar datos, No ha seleccionado una carreara',
    'error'
  );
     return false;
}else if (!regex.test(correo)) {
  Swal.fire(
    'A ocurrido un error!',
    'Formato de correo incorrecto',
    'error'
  )
  return false;
 }else if(diff < 18){
    Swal.fire(
      'A ocurrido un error!',
      'La fecha de nacimiento es menor a lo requerido',
      'error'
    )
    return false;
  }else if($("#ddl_beca").val() == '10' && diff < 60){
    Swal.fire(
      'A ocurrido un error!',
      'Usted no cumple con los requisitos para esta beca',
      'error'
    )
    return false;
  }else{
  insertarMatricula();
 }
}
function validarDoc(nom){
if($("#id_tipoDocumento").val() == '0'){
  Swal.fire(
    'A ocurrido un error!',
    'Debe seleccionar Tipo de documentos de Identidad:',
    'error'
  );

  $('#'+nom).val('');
  
}

}
/*=============================================
INSERTAR MATRICULAS
=============================================*/
function insertarMatricula(){
  //var dataString = 'nombre= casv'
  let rut = $("#idTxtNRut").val();
  let pasaporte = $("#idTxtPasaporte").val();
  let NDocumento = $("#idTxtNDocumento").val();
  let tipoDocumento= $("#id_tipoDocumento").val();
  let nombre = $("#texto_nombre").val().toUpperCase();
  let apellido = $("#texto_apellidos").val().toUpperCase();
  let email = $("#texto_email").val();
  let tel_movil = $("#texto_celular").val();  
  let fnacimiento = $("#texto_fnacimiento").val();
  let estadoCivil = $("#ddl_estadoCivil").val();
  let genero = $("#ddl_genero").val();
  let pais = $("#ddl_pais").val();
  let direccion = $("#texto_direccion").val().toUpperCase();
  let comunas = $("#ddl_comunas").val();
  let regiones = $("#ddl_regiones").val();
  let viaAdmision = $("#ddl_viaAdmision").val();
  let convalidante = $("#ddl_convalidante").val();
  let id_jornada = $("#jornada").val();
  let carrera = $("#ddl_carrera").val();
  let modalidad1_post = $("#texto_modalidad").val();
  let regimen = $("#ddl_carrera option:selected").attr("regimenID");
  let id_beca = $("#ddl_beca").val();

  let dataString = 'rut='+rut.trim()+'&pasaporte='+pasaporte.trim()+'&NDocumento='+NDocumento.trim()+'&tipoDocumento='+tipoDocumento.trim()
                    +'&nombre='+nombre.trim()+'&apellido='+apellido.trim()+'&email='+email.trim() 
                    +'&tel_movil='+tel_movil.trim()+'&fnacimiento='+fnacimiento.trim()+'&estadoCivil='+estadoCivil.trim()
                    +'&genero='+genero.trim()+'&pais='+pais.trim()+'&direccion='+direccion.trim() +'&comunas='+ comunas.trim() +'&regiones='+regiones.trim() 
                    +'&viaAdmision='+viaAdmision.trim() +'&convalidante='+convalidante.trim()+'&id_beca='+id_beca.trim()+
                    '&id_jornada='+id_jornada.trim()+'&carrera='+carrera.trim()+'&modalidad1_post='+modalidad1_post.trim()+'&regimen='+regimen.trim();


$.ajax({
            type: "POST",
            url: "function/funcionInsertar.php?postInsertar",
            data: dataString,
            success: function(data) {
              console.log(data);
              if (data == 3){ 
                Swal.fire(
                  'A ocurrido un error!',
                  'No se puedo ingresar la matricula, el RUT ya esta ingresado',
                  'error'
                )
              }else if (data == 2){   
                Swal.fire(
                  'A ocurrido un error!',
                  'No se puedo ingresar la matricula',
                  'error'
                );
                }else{
                 
                  Swal.fire(
                    'Operación exitosa!',
                    'Los datos se guardaron correctamente'
                );
                localStorage.setItem("idMatricula", data);
                localStorage.setItem("rut", rut);
                localStorage.setItem("carrera",  $('select[name="ddl_carrera"] option:selected').text());

                $("#ddl_viaAdmision").prop('disabled', true);
                $("#jornada").prop('disabled', true);
                $("#ddl_carrera").prop('disabled', true);
                $("#ddl_beca").prop('disabled', true);
                $("#btnGrabaPaso1").prop('disabled', true);
              //  $('#ddl_viaAdmision').hide(1000);
                habilitarTblArchivos();
                //enviarCorreo('Su matrícula se generó correctamente, gracias por tu interés en la Universidad Miguel de Cervantes.');
                console.log(data);
                }
               
            }

        });
}
/*=============================================
INSERTAR PRE CARGAMATRICULAS
=============================================*/
function insertarPreMatricula(){
  //var dataString = 'nombre= casv'
  let rut = $("#idTxtNRut").val();

  
 /* let dataString = 'rut='+rut;


$.ajax({
            type: "POST",
            url: "function/funcionInsertar.php?postInsertarPreCarga",
            data: dataString,
            success: function(data) {
              console.log(data);               
            }

        });*/
}

function compruebaValidoEntero(){
  alert("buera de foco");
}
/*=============================================
INSERTAR AVAL
=============================================*/
function insertarAval(){
  
  let rut =$("#idTxtNRut").val();
  let nombre = $("#texto_nombre").val();
  let apellido = $("#texto_apellidos").val();
  let email = $("#texto_email").val();
  let tel_movil = $("#texto_celular").val();  
  let estadoCivil = $("#ddl_estadoCivil").val();
  let pais = $("#ddl_pais").val();
  let direccion = $("#texto_direccion").val().toUpperCase();
  let comunas = $("#ddl_comunas").val();
  let regiones = $("#ddl_regiones").val();
  let id_contrato = localStorage.getItem('idContrato');

  let dataString = 'rut='+rut.trim()+'&nombre='+nombre.trim()+'&apellido='+apellido.trim()+'&email='+email.trim() 
                    +'&tel_movil='+tel_movil+'&estadoCivil='+estadoCivil +'&pais='+pais+'&direccion='+direccion
                    +'&comunas='+ comunas.trim() +'&regiones='+regiones.trim() +'&id_contrato='+id_contrato.trim();


$.ajax({
            type: "POST",
            url: "function/funcionInsertar.php?postInsertarAval",
            data: dataString,
            success: function(data) {
              console.log(data);
            }

        });
}
/*=============================================
UPDATE PRE MATRICULAS
=============================================*/
function updatePreMatricula(){
 
  let carreras = 0
  let regimens = 'Sin Datos'

  let rut = $("#idTxtNRut").val();
  let pasaporte = $("#idTxtPasaporte").val();
  let NDocumento = $("#idTxtNDocumento").val();
  let nombre = $("#texto_nombre").val();
  let apellido = $("#texto_apellidos").val();
  let email = $("#texto_email").val();
  let tel_movil = $("#texto_celular").val();  
  let fnacimiento = $("#texto_fnacimiento").val();
  let estadoCivil = $("#ddl_estadoCivil").val();
  let genero = $("#ddl_genero").val();
  let pais = $("#ddl_pais").val();
  let direccion = $("#texto_direccion").val();
  let comunas = $("#ddl_comunas").val();
  let regiones = $("#ddl_regiones").val();
  let viaAdmision = $("#ddl_viaAdmision").val();
  let convalidante = $("#ddl_convalidante").val();
  let id_jornada = $("#jornada").val();
  let carrera = $("#ddl_carrera").val();
  let modalidad1_post = $("#texto_modalidad").val();
  let regimen = $("#ddl_carrera option:selected").attr("regimenID");;

  if (carrera === undefined) {
    carreras = 0;
  }else{
    carreras = carrera;
  }
  if (regimen === undefined) {
    regimens = 'Sin Datos';
  }else{
    regimens = regimen;
  }

  let dataString = 'rut='+rut+'&pasaporte='+pasaporte+'&NDocumento='+NDocumento
                    +'&nombre='+nombre+'&apellido='+apellido+'&email='+email 
                    +'&tel_movil='+tel_movil+'&fnacimiento='+fnacimiento+'&estadoCivil='+estadoCivil
                    +'&genero='+genero+'&pais='+pais+'&direccion='+direccion +'&comunas='+ comunas +'&regiones='+regiones 
                    +'&viaAdmision='+viaAdmision +'&convalidante='+convalidante+'&id_jornada='+id_jornada 
                    +'&carrera='+carreras + '&modalidad1_post='+modalidad1_post + '&regimen='+regimens;


$.ajax({
            type: "POST",
            url: "function/funcionUpdate.php?postUpdatePrecarga",
            data: dataString,
            success: function(data) {
              console.log(data);               
            }

        });

        console.log('descomentar');
}
/*=============================================
finalizar carga
=============================================*/
function finalizarCarga(){
  Swal.fire({
      title: 'Desea finalizar el proceso?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'OK'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire(
          'Finalizado!',
          'Se a finalizado correctamente.',
          'success'
        );
        //location.reload();
        location.href="https://matriculate.umc.cl/sgu/MatriculaOnline/";
        localStorage.clear();
      }
    })
}

function limpiarCampos(){
  $("#idTxtNRut").val('');
  $("#idTxtPasaporte").val('');
  $("#idTxtNDocumento").val('');
  $("#id_tipoDocumento").val('0');
  $("#texto_nombre").val('');

  $("#texto_apellidos").val('');
  $("#texto_email").val('');
  $("#texto_celular").val(''); 
 // $("#texto_fnacimiento").val();
  $("#ddl_estadoCivil").val('0');
  $("#ddl_genero").val('0');
  $("#texto_direccion").val('');
  $("#ddl_viaAdmision").val('0');
  $("#ddl_convalidante").val('0');
  $("#jornada").val('0');
  $("#ddl_carrera").val('0');
}

function deleteArchivo(id){
Swal.fire({
  title: 'Desea eliminar el documento?',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'OK'
}).then((result) => {
  if (result.isConfirmed) {

    $.ajax({
      type: "GET",
      url: "cargaArchivo.php?eliminarArchivo&id="+id,
      success: function(data) {
          if (data == 1){
            Swal.fire(
              'Finalizado!',
              'Se elimino correctamente.',
              'success'
            );
            llamarTableDoc();  
          }else{
            
          }
      }

  });


   // limpiarCampos();
  }
})
}

function pagarMatricula(){
let matAnual =  $("#matAnual").val();
let aranAnual = $("#aranAnual").val(); 

if(matAnual == '' || matAnual == null
||aranAnual == '' || aranAnual == null

){
Swal.fire(
'A ocurrido un error!',
'No se puedo pagar, existen campos vacios',
'error'
);
return false;
}else{


Swal.fire({
title: 'Desea ejecutar el pago?',
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'OK'
}).then((result) => {
if (result.isConfirmed) {
        
          Swal.fire(
            'Finalizado!',
            'Su pago de matricula es de ' + matAnual + ' y de arancel es de ' + aranAnual,
            'success'
          );
    }

})
}
}
function pagarMatriculaOtros(){
let matSemestral =  $("#matSemestral").val();
let aranCreditoSemes = $("#aranAnual").val(); 

if(matSemestral == '' || matSemestral == null
  ||aranCreditoSemes == '' || aranCreditoSemes == null

){
Swal.fire(
'A ocurrido un error!',
'No se puedo pagar, existen campos vacios',
'error'
);
return false;
}else{

Swal.fire({
 title: 'Desea ejecutar el pago?',
 icon: 'warning',
 showCancelButton: true,
 confirmButtonColor: '#3085d6',
 cancelButtonColor: '#d33',
 confirmButtonText: 'OK'
}).then((result) => {
 if (result.isConfirmed) {
         
           Swal.fire(
             'Finalizado!',
             'Su pago de matricula semestral es de ' + matSemestral + ' y de arancel semestral es de ' + aranCreditoSemes,
             'success'
           );
     }

})
}

}

function webPagar(ddl_TipoPago){
  Swal.fire({
    title: 'Está seguro de grabar? Si presiona OK, se generará la Matricula.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'OK'
   }).then((result) => {
    if (result.isConfirmed) {
      if (ddl_TipoPago == 1){
        llamarTipoDocMat(1); 
        insertarAnualContrato(3,1);
      } else if(ddl_TipoPago == 2){
        llamarTipoDocMat(2); 
        insertarAnualContrato(3,2);
        
      }

    }
   
  })
}

 /*=============================================
INSERTAR CONTRATO ANUAL
=============================================*/
function insertarAnualContrato(tipo, ddl_TipoPago){

      let viaAdmision = $("#ddl_viaAdmision").val();
      let rut = $("#idTxtNRut").val();
      let id_carrera= $("#ddl_carrera").val();
      let monto_matricula = 0
      let monto_arancel = 0
      if(ddl_TipoPago == 1){
        /*MATRICULA ANUAL*/
          monto_matricula = $("#ddl_carrera option:selected").attr("matricula_anual");
          monto_arancel = $("#ddl_carrera option:selected").attr("arancel_contado_anual");
      }else{
          /*MATRICULA SEMESTRAL*/
          monto_matricula = $("#ddl_carrera option:selected").attr("matricula_semestral");
          monto_arancel = $("#ddl_carrera option:selected").attr("arancel_credito_semestral");
      }
      let tpopago = ddl_TipoPago;
      
      let jornada= $("#jornada").val();
      let modalidad = $("#texto_modalidad").val();
    
      let id_beca_arancel = $("#ddl_beca option:selected").attr("id_beca_arancel");
      let dscto_pregrado_mat = $('#dscto_pregrado_mat').val();
      let dscto_pregrado_ara = $('#dscto_pregrado_ara').val();
      let dscto_licenciatura_matv = $('#dscto_licenciatura_mat').val();
      let dscto_licenciatura_ara = $('#dscto_licenciatura_ara').val();
    
      let porcentaje_becas_mat = $("#porcentaje_becas_mat").val();
      let porcentaje_becas_ara = $("#porcentaje_becas_ara").val();
      let idMatricula =localStorage.getItem('idMatricula');
    
      let dataString =  'tipo='+tipo+'&viaAdmision='+viaAdmision+'&TipoPago='+tpopago+'&rut='+rut+'&id_carrera='+id_carrera+'&monto_matricula='+monto_matricula
                        +'&monto_arancel='+monto_arancel+'&jornada='+jornada+'&modalidad='+modalidad+'&id_beca_arancel='+id_beca_arancel+'&dscto_pregrado_mat='+dscto_pregrado_mat
                        +'&dscto_pregrado_ara='+dscto_pregrado_ara+'&dscto_licenciatura_matv='+dscto_licenciatura_matv
                        +'&dscto_licenciatura_ara='+dscto_licenciatura_ara +'&porcentaje_becas_mat='+porcentaje_becas_mat
                        +'&porcentaje_becas_ara='+porcentaje_becas_ara+'&idMatricula='+idMatricula;
    
    
      if (monto_matricula == '' || monto_matricula == null || 
          rut == '' || rut == null || viaAdmision ==0
         || monto_arancel== '' || monto_arancel == null ){
        Swal.fire(
          'A ocurrido un error!',
          'Se Debe seleccionar Vía de Admisión una jornada y una carrera',
          'error'
        );
      return false;
      }else{
        $.ajax({
                type: "POST",
                url: "function/funcionInsertarFinanza.php?postInsertarContrato",
                data: dataString,
                success: function(data) {
                  localStorage.setItem("carrera",  $('select[name="ddl_carrera"] option:selected').text());
                  let nombre =localStorage.getItem('nombre');
                  let apellido =localStorage.getItem('apellido');
                  let carrera =localStorage.getItem('carrera');

                 if (data == 2){                      
                          Swal.fire(
                          'A ocurrido un error!',
                          'No se puedo ingresar la matricula',
                          'error'
                        )
                      //console.log(data);
                    }else{
                        if(data['monto'] !=0 && data['tipoPago'] == 4 && tipo != 3){
                          $.ajax({
                            type: "GET",
                            url: "function/function.php?generar_cobros&id_contrato="+data['idContrato'],
                            data:"",
                            success:function(data){
                             console.log(data);
                          }});
                        localStorage.setItem("idContrato", data['idContrato']);
                        $("#btnOtrosPay").prop('disabled', true);
                        matAnticipada(localStorage.getItem('idContrato'));
                        setTimeout(() => {    
                          location.href="https://matriculate.umc.cl/sgu/MatriculaOnline/transbank/vendor/transbank/transbank-sdk/examples/webpay-plus/index.php?action=create&monto="+data['monto']+"&rut="+localStorage.getItem('rut')+"";
                          }, "1000");
                     
                         // console.log(data['monto']);
    
                        } else if(data['monto'] == 0 && data['tipoPago'] == 5 && tipo != 3){
                          $.ajax({
                            type: "GET",
                            url: "function/function.php?generar_cobros&id_contrato="+data['idContrato'],
                            data:"",
                            success:function(data){
                             console.log(data);
                          }});
                          localStorage.setItem("idContrato", data['idContrato']);
                          localStorage.setItem("idPagare", data['idPagare']);
                          insertarAval();
                          enviarCorreo( "Gracias "+nombre+" "+apellido+", por matricularte en la UMC en la carrera "+carrera+".<br/>"
                                        +"Para finalizar el proceso, debes enviarnos el contrato (que descargaste cuando terminaste tu matrícula en línea) firmado por correo electrónico a matriculaonline@corp.umc.cl<br/><br>"
                                        +"Para insertar tu firma en el contrato y/o pagaré, te recomendamos seguir el siguiente instructivo:<br/>"
                                        +"https://helpx.adobe.com/cl/reader/using/sign-pdfs.html#:~:text=Pasos%20para%20firmar%20un%20PDF,firmar%20en%20el%20panel%20derecho.<br/>"
                                        +"Nos comunicaremos contigo a la brevedad para darte la bienvenida y comenzar a remitir la información de acceso a nuestras plataformas.");
                          $('#modalOtros').click();
                          $("#btnWebPay").prop('disabled', true);
                        }else if(data['monto'] != 0 && data['tipoPago'] == 5 && tipo != 3){
                         $.ajax({
                            type: "GET",
                            url: "function/function.php?generar_cobros&id_contrato="+data['idContrato'],
                            data:"",
                            success:function(data){
                             console.log(data);
                          }});
                          localStorage.setItem("idContrato", data['idContrato']);
                          localStorage.setItem("idPagare", data['idPagare']);
                          insertarAval();
                          $("#btnWebPay").prop('disabled', true);
                          matAnticipada(localStorage.getItem('idContrato'));
                          setTimeout(() => {    
                          location.href="https://matriculate.umc.cl/sgu/MatriculaOnline/transbank/vendor/transbank/transbank-sdk/examples/webpay-plus/index.php?action=create&monto="+data['monto']+"&rut="+localStorage.getItem('rut')+"";
                          }, "1000");
                        
                        // console.log(data['monto']);
                         
                        }
                      //console.log(data);
                    }
                    if(tipo == 3){
                      if (ddl_TipoPago == 1){
    
                        matricula_anualCLDES = new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(data['monto_matricula_final_total']);
                        arancel_contado_anualCLDES= new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(data['monto_arancel_final_total']);
                        mto = new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(data['mto']);
    
                        $("#DesMatAnual").val(matricula_anualCLDES); 
                        $("#desAranAnual").val(arancel_contado_anualCLDES);
                        $("#totalFinalAnual").val(mto);
    
                      }else if(ddl_TipoPago == 2){
    
                        matricula_semestralCLDes = new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(data['monto_matricula_final_total']);
                        arancel_credito_semestralCLDes = new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(data['monto_arancel_final_total']);
                        mtoS = new Intl.NumberFormat('es-CL', { style: 'currency', currency: 'CLP' }).format(data['mto']);
      
                        $("#DesMatSemestral").val(matricula_semestralCLDes); 
                        $("#desAranCreditoSemes").val(arancel_credito_semestralCLDes);
                        $("#totalFinalSemes").val(mtoS);
                        
                      }else{
                        $("#DesMatAnual").val(''); 
                        $("#desAranAnual").val('');
                        $("#DesMatSemestral").val(''); 
                        $("#desAranCreditoSemes").val('');
                        $('#Mat').hide();
                        $('#otros').hide();
                      }
        
                      
    
                      console.log();
                    }
                   
                }
    
            });
          }   
  
}

function matAnticipada(id_contrato){
    const hoy = new Date();
    const anoActual = hoy.getFullYear();
    $.ajax({
      type: "GET",
      url: "function/function.php?matAnticipada&ano="+anoActual+"&id_contrato="+id_contrato,
      data:"",
      success:function(data){
      console.log(data);
    }});
  }
function esRut() {
 
    if (document.getElementById("id_tipoDocumento").value === "R") {
      //document.getElementById("idTxtPasaporte").disabled = true;
      //document.getElementById("idTxtNDocumento").disabled = false;
      //document.getElementById("idTxtNRut").disabled = false;
      document.getElementById("idTxtPasaporte").value = "";

      //document.getElementById("div_rut").style.display="block";
      //document.getElementById("div_documento").style.display="block";
      document.getElementById("div_pasaporte").style.display="none";
      
      
      
    } else {
      document.getElementById("idTxtPasaporte").disabled = false;
      //document.getElementById("idTxtNDocumento").disabled = true;
      //document.getElementById("idTxtNRut").disabled = true;
      //document.getElementById("idTxtNRut").value = "";
      //document.getElementById("idTxtNDocumento").value = "";


      //document.getElementById("div_rut").style.display="none"; 
      //document.getElementById("div_documento").style.display="none";
      document.getElementById("div_pasaporte").style.display="block";
      }
    //textonpasaporte.style.display = ddltipoDocumento.value == "R" ? "block" : "none";
}



 function llamarvalor(){
  alert('El valor es: ' + $("#ddl_pais").val())
 }
 
function llamarSelect(){
      // Switchery
      var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
      $('.js-switch').each(function() {
          new Switchery($(this)[0], $(this).data());
      });
      // For select 2
      $(".select2").select2();

      $(".ajax").select2({
          ajax: {
              url: "https://api.github.com/search/repositories",
              dataType: 'json',
              delay: 250,
              data: function(params) {
                  return {
                      q: params.term, // search term
                      page: params.page
                  };
              },
              processResults: function(data, params) {
                  // parse the results into the format expected by Select2
                  // since we are using custom formatting functions we do not need to
                  // alter the remote JSON data, except to indicate that infinite
                  // scrolling can be used
                  params.page = params.page || 1;
                  return {
                      results: data.items,
                      pagination: {
                          more: (params.page * 30) < data.total_count
                      }
                  };
              },
              cache: true
          },
          escapeMarkup: function(markup) {
              return markup;
          }, // let our custom formatter work
          minimumInputLength: 1,
      });
  }

function imprimirContrato(){
    let idContrato= localStorage.getItem('idContrato');
    location.href="https://sgu.umc.cl/sgu/contrato.php?id_contrato="+idContrato+"&tipo=al_nuevo";
}
function imprimirPagare(){
    let idPagare= localStorage.getItem('idPagare');
    location.href="https://sgu.umc.cl/sgu/pagare_colegiatura.php?id_pagare_colegiatura="+idPagare+"&tipo=al_nuevo";
}
function borrarSalir(){
    localStorage.clear();
    location.href="https://matriculate.umc.cl/";
}

function enviarCorreo(mensaje){

  let correo =localStorage.getItem('email');

  let dataString = mensaje;


                let msj = {
                  correo: correo,
                  mensaje:  mensaje
              };
          
              fetch("https://matriculate.umc.cl/sgu/MatriculaOnline/correo.php",{
                  method:'POST',
                  body:JSON.stringify(msj),
                  headers: {
                      'Content-Type':'application/json'
                  }
              })
              .then(console.log)
              .catch(console.error);

}