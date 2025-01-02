$(document).ready(function(){
  llamarBecasTBL();
  llamarOfertasTBL()
  $('#btnUpdate').hide();
  $('#btnUpdateOf').hide();
  $('#becas').hide();
  $('#Ofertas').hide();
  
  });

/*=============================================
LLAMAR BECAS
=============================================*/
   function llamarBecasTBL(){
    $.ajax({
      type: "GET",
      url: "/sgu/MatriculaOnline/mantenedores/service/mantenedor.php?getAllBeca",
      data:"",
      success:function(msg){
       $("#ddl_becastbl").html(msg);
       
    }})
 }
/*=============================================
INSERTAR BECAS
=============================================*/
function insertarBeca(){
  if($("#descripcion").val() == '' || $("#descripcion").val() == null
  || $("#dscto_pregrado_mat").val() == '' || $("#dscto_pregrado_mat").val() == null
  || $("#dscto_pregrado_ara").val() == '' || $("#dscto_pregrado_ara").val() == null
  || $("#dscto_licenciatura_mat").val() == '' || $("#dscto_licenciatura_mat").val() == null
  || $("#dscto_licenciatura_ara").val() == '' || $("#dscto_licenciatura_ara").val() == null)
{
  Swal.fire(
  'A ocurrido un error!',
  'No se puedo insertar los datos, Todos los campos deben estar llenos',
  'error'
);
   return false;
}else{

  
  //var dataString = 'nombre= casv'
  let descripcion = $("#descripcion").val();
  let dscto_pregrado_mat = $("#dscto_pregrado_mat").val();
  let dscto_pregrado_ara = $("#dscto_pregrado_ara").val();
  let dscto_licenciatura_mat = $("#dscto_licenciatura_mat").val();
  let dscto_licenciatura_ara = $("#dscto_licenciatura_ara").val();

  
  let dataString = 'descripcion='+descripcion+'&dscto_pregrado_mat='+dscto_pregrado_mat+
  '&dscto_pregrado_ara='+dscto_pregrado_ara +'&dscto_licenciatura_mat='+dscto_licenciatura_mat+
  '&dscto_licenciatura_ara='+dscto_licenciatura_ara;


$.ajax({
            type: "POST",
            url: "/sgu/MatriculaOnline/mantenedores/service/mantenedor.php?incertBeca",
            data: dataString,
            success: function(data) {
              if (data == 1){
                Swal.fire(
                  'Operación Exitosa !',
                  'Se insertaron correctamente los datos.',
                  'success'
                );
                limiarCampos();  
                llamarBecasTBL();
              }else{
                Swal.fire(
                  'A ocurrido un error!',
                  'No se puedo ingresar los datos',
                  'error'
                )
              }             
            }

        });
      }
}

function limiarCampos(){
  $("#descripcion").val('');
  $("#dscto_pregrado_mat").val('');
  $("#dscto_pregrado_ara").val('');
  $("#dscto_licenciatura_mat").val('');
  $("#dscto_licenciatura_ara").val('');

  $('#btnInsert').show();
  $('#btnUpdate').hide();
}
/*=============================================
LLAMAR UNA BECAS
=============================================*/
function llamarOneBecas(id){
  $.ajax({
    type: "GET",
    url: "/sgu/MatriculaOnline/mantenedores/service/mantenedor.php?getOneBeca&id="+id,
    data:"",
    success:function(data){
     console.log(data[1]);
     $("#descripcion").val(data[1]);
     $("#dscto_pregrado_mat").val(data[2]);
     $("#dscto_pregrado_ara").val(data[3]);
     $("#dscto_licenciatura_mat").val(data[4]);
     $("#dscto_licenciatura_ara").val(data[5]);
     $("#id").val(data[0]);

     $('#btnUpdate').show();
     $('#btnInsert').hide();
     
  }})
}
/*=============================================
UPDATE BECAS
=============================================*/
function updateBeca(){
  //var dataString = 'nombre= casv'
  let id = $("#id").val();
  let descripcion = $("#descripcion").val();
  let dscto_pregrado_mat = $("#dscto_pregrado_mat").val();
  let dscto_pregrado_ara = $("#dscto_pregrado_ara").val();
  let dscto_licenciatura_mat = $("#dscto_licenciatura_mat").val();
  let dscto_licenciatura_ara = $("#dscto_licenciatura_ara").val();

  
  let dataString = 'id='+id+'&descripcion='+descripcion+'&dscto_pregrado_mat='+dscto_pregrado_mat+
  '&dscto_pregrado_ara='+dscto_pregrado_ara +'&dscto_licenciatura_mat='+dscto_licenciatura_mat+
  '&dscto_licenciatura_ara='+dscto_licenciatura_ara;
console.log(id);

$.ajax({
            type: "POST",
            url: "/sgu/MatriculaOnline/mantenedores/service/mantenedor.php?updateBeca",
            data: dataString,
            success: function(data) {
              if (data == 1){
                Swal.fire(
                  'Operación Exitosa !',
                  'Se actualizarón correctamente los datos.',
                  'success'
                );
                limiarCampos();  
                llamarBecasTBL();
              }else{
                Swal.fire(
                  'A ocurrido un error!',
                  'No se puedo ingresar los datos',
                  'error'
                )
              }             
            }

        });
}

function deleteBeca(id){
  Swal.fire({
    title: '¿Desea eliminar la beca?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'OK'
  }).then((result) => {
    if (result.isConfirmed) {
  
      $.ajax({
        type: "GET",
        url: "/sgu/MatriculaOnline/mantenedores/service/mantenedor.php?deleteBeca&id="+id,
        success: function(data) {
            if (data == 1){
              Swal.fire(
                'Finalizado!',
                'Se elimino correctamente.',
                'success'
              );
              limiarCampos();  
              llamarBecasTBL();  
            }else{
              Swal.fire(
                'A ocurrido un error!',
                'No se puedo eliminar el datos',
                'error'
              )
            }
        }
  
    });
  
  
     // limpiarCampos();
    }
  })
  }


function mostrarBecas(){
  $('#becas').show(2000);
  $('#Ofertas').hide();
}

function mostrarOfertas(){
  $('#Ofertas').show(2000);
  $('#becas').hide();
}

function ocultarTodo(){
  $('#Ofertas').hide();
  $('#becas').hide();
}

/*=============================================
                  OFERTAS
=============================================*/

/*=============================================
LLAMAR OFERTAS
=============================================*/
function llamarOfertasTBL(){
  $.ajax({
    type: "GET",
    url: "/sgu/MatriculaOnline/mantenedores/service/mantenedor.php?getAllOfertas",
    data:"",
    success:function(msg){
     $("#ddl_Ofertastbl").html(msg);
     
  }})
}
/*=============================================
LLAMAR PROG. CARRERAS
=============================================*/
function llamarProgCarrera(idJornada){

  if (idJornada!= null || idJornada != undefined){
   jornada = idJornada;
  }else{
   jornada = $("#jornada").val();
  }
  
    $.ajax({
      type: "GET",
      url: "/sgu/MatriculaOnline/mantenedores/service/mantenedor.php?getAllCarrProg&jornada="+jornada,
      data:"",
      success:function(msg){
       $("#ddl_carreras").html(msg);
    }})
 }
/*=============================================
INSERTAR OFERTAS
=============================================*/
function insertarOfertas(){
  if($("#jornada").val() == 0 || $("#ddl_carrera").val() == 0
  || $("#porcentaje_becas_mat").val() == '' || $("#porcentaje_becas_mat").val() == null
  || $("#porcentaje_becas_ara").val() == '' || $("#porcentaje_becas_ara").val() == null)
{
  Swal.fire(
  'A ocurrido un error!',
  'No se puedo insertar los datos, Todos los campos deben estar llenos',
  'error'
);
   return false;
}else{

  
  //var dataString = 'nombre= casv'
  let cod_jornada = $("#jornada").val();
  let cod_carrera = $("#ddl_carrera").val();
  let porcentaje_becas_mat = $("#porcentaje_becas_mat").val();
  let porcentaje_becas_ara = $("#porcentaje_becas_ara").val();


  
  let dataString = 'cod_jornada='+cod_jornada+'&cod_carrera='+cod_carrera+
  '&porcentaje_becas_mat='+porcentaje_becas_mat +'&porcentaje_becas_ara='+porcentaje_becas_ara;


$.ajax({
            type: "POST",
            url: "/sgu/MatriculaOnline/mantenedores/service/mantenedor.php?incerOfertas",
            data: dataString,
            success: function(data) {
              if (data == 1){
                Swal.fire(
                  'Operación Exitosa !',
                  'Se insertaron correctamente los datos.',
                  'success'
                );
                limiarCamposOfetas();  
                llamarOfertasTBL();
              }else{
                Swal.fire(
                  'A ocurrido un error!',
                  'No se puedo ingresar los datos',
                  'error'
                )
              }             
            }

        });
      }
}
 /*=============================================
LLAMAR UNA OFERTA
=============================================*/
function llamarOneOferta(cod_jornada, cod_carrera){
  $.ajax({
    type: "GET",
    url: "/sgu/MatriculaOnline/mantenedores/service/mantenedor.php?getOneOferta&cod_jornada="+cod_jornada+"&cod_carrera="+cod_carrera,
    data:"",
    success:function(data){
     llamarProgCarrera(data[0])
     setTimeout(() => {
      $("#jornada").val(data[0]);
      $("#ddl_carrera").val(data[1]);
      $("#porcentaje_becas_mat").val(data[2]);
      $("#porcentaje_becas_ara").val(data[3]);

      $("#jornada").prop('disabled', true);
      $("#ddl_carrera").prop('disabled', true);

     }, 200);
     
     $('#btnInsertOf').hide();
     $('#btnUpdateOf').show();
     
  }})
}

/*=============================================
UPDATE OFERTAS
=============================================*/
function updateOfertas(){
  if($("#porcentaje_becas_mat").val() == '' || $("#porcentaje_becas_mat").val() == null
  || $("#porcentaje_becas_ara").val() == '' || $("#porcentaje_becas_ara").val() == null)
{
  Swal.fire(
  'A ocurrido un error!',
  'No se puedo Actualizar los datos, Todos los campos deben estar llenos',
  'error'
);
   return false;
}else{

  
  //var dataString = 'nombre= casv'
  let cod_jornada = $("#jornada").val();
  let cod_carrera = $("#ddl_carrera").val();
  let porcentaje_becas_mat = $("#porcentaje_becas_mat").val();
  let porcentaje_becas_ara = $("#porcentaje_becas_ara").val();


  
  let dataString = 'cod_jornada='+cod_jornada+'&cod_carrera='+cod_carrera+
  '&porcentaje_becas_mat='+porcentaje_becas_mat +'&porcentaje_becas_ara='+porcentaje_becas_ara;


$.ajax({
            type: "POST",
            url: "/sgu/MatriculaOnline/mantenedores/service/mantenedor.php?updateOfertas",
            data: dataString,
            success: function(data) {
              if (data == 1){
                Swal.fire(
                  'Operación Exitosa !',
                  'Se Actualizarón correctamente los datos.',
                  'success'
                );
                limiarCamposOfetas();  
                llamarOfertasTBL();
                $("#jornada").prop('disabled', false);
                $("#ddl_carrera").prop('disabled', false);
              }else{
                Swal.fire(
                  'A ocurrido un error!',
                  'No se puedo ingresar los datos',
                  'error'
                )
                $("#jornada").prop('disabled', false);
                $("#ddl_carrera").prop('disabled', false);
              }             
            }

        });
      }
}
/*=============================================
DELETE OFERTAS
=============================================*/
function deleteOfertas(jornada, ddl_carrera){
  Swal.fire({
    title: '¿Desea eliminar la Oferta?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'OK'
  }).then((result) => {
    if (result.isConfirmed) {
  
      $.ajax({
        type: "GET",
        url: "/sgu/MatriculaOnline/mantenedores/service/mantenedor.php?deleteOfertas&cod_jornada="+jornada+"&cod_carrera="+ddl_carrera,
        success: function(data) {
            if (data == 1){
              Swal.fire(
                'Finalizado!',
                'Se elimino correctamente.',
                'success'
              );
              llamarOfertasTBL(); 
              limiarCamposOfetas();  
            }else{
              Swal.fire(
                'A ocurrido un error!',
                'No se puedo eliminar el datos',
                'error'
              )
            }
        }
  
    });
  
  
     // limpiarCampos();
    }
  })
  }
function limiarCamposOfetas(){
  $("#jornada").val(0);
  $("#ddl_carrera").val(0);
  $("#porcentaje_becas_mat").val('');
  $("#porcentaje_becas_ara").val('');

  $('#btnInsertOf').show();
  $('#btnUpdateOf').hide();
}