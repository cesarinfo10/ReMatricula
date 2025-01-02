

/*=============================================
INSERTAR PRE CARGAMATRICULAS REGISTRO
=============================================*/
function registro(){

  let correo = $("#email").val();
  let regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  if($("#nombres").val() == '' || $("#nombres").val() == null){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, El campo Nombre esta vacio',
      'error'
    );
    return false;
    }else if($("#apellidos").val() == '' || $("#apellidos").val() == null){
    Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, El campo Apellido esta vacio',
      'error'
    );
      return false;
    }else if($("#rut").val() == '' || $("#rut").val() == null)
    {
      Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, El campo RUT esta vacio',
      'error'
    );
      return false;
    }/*else if($("#num_ducumento").val() == '' || $("#num_ducumento").val() == null)
    {
      Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, El campo Nº Documento esta vacio',
      'error'
    );
      return false;
    }*/else if($("#email").val() == '' || $("#email").val() == null)
    {
      Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, El campo Email esta vacio',
      'error'
    );
      return false;
    }else if (!regex.test(correo)) {
      Swal.fire(
        'A ocurrido un error!',
        'Formato de correo incorrecto',
        'error'
      )
    }else if($("#tel_movil").val() == '' || $("#tel_movil").val() == null)
    {
      Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, El campo Teléfono esta vacio',
      'error'
    );
      return false;
    }else if($("#pass").val() == '' || $("#pass").val() == null)
    {
      Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, El campo Password esta vacio',
      'error'
    );
      return false;
    }else if($("#pass_rep").val() == '' || $("#pass_rep").val() == null)
    {
      Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, Replique su contraña por favor',
      'error'
    );
      return false;
    }else if($("#pass").val() != $("#pass_rep").val())
    {
      Swal.fire(
      'A ocurrido un error!',
      'No se puedo insertar datos, Las contraseñas no coinciden',
      'error'
    );
      return false;
    }else{
      
    let nombres = $("#nombres").val().toUpperCase();
    let apellidos = $("#apellidos").val().toUpperCase();
    let rut = $("#rut").val();
    let num_ducumento = $("#num_ducumento").val();
    let email = $("#email").val();
    let tel_movil = $("#tel_movil").val();
    let pass = $("#pass").val();
    let pass_rep = $("#pass_rep").val();

    let dataString = 'nombres='+nombres.trim()+'&apellidos='+apellidos.trim()+'&rut='+rut.trim()+'&num_ducumento='+num_ducumento.trim()
                    +'&email='+email.trim()+'&tel_movil='+tel_movil.trim()+'&pass='+pass.trim()+'&pass_rep='+pass_rep.trim();
  console.log(dataString);
  
 $.ajax({
              type: "POST",
              url: "../service/registro.php?postInsertarPreCargaRegistro",
              data: dataString,
              success: function(data) {
                if (data==1){
                  Swal.fire(
                    'Operación exitosa!',
                    'Se ha registrado correctamente'
                );

                setTimeout(() => {
                  //location.href="http://localhost/MatriculaOnline/login/views/pages-login.html";
                  location.href="https://matriculate.umc.cl/sgu/MatriculaOnline/";
                }, "5000"); 
                }else if(data==3){
                  Swal.fire(
                    'Atención!',
                    'Su Email o RUT ya esta registrado en el Sistema',
                    'error'
                  )

                }else{
                  Swal.fire(
                    'A ocurrido un error!',
                    'No se pudo ingresar los datos',
                    'error'
                  )

                }     
              }
  
          });
        }
  }

  function validaRUT(){
    const valida = Fn.validaRut($("#rut").val().trim()) ? '1' : '2';
    if (valida == '2'){
      Swal.fire(
        'A ocurrido un error!',
        'RUT incorrecto o campo vacío',
        'error'
      )
      $("#rut").val('');
    }
  }
  function validaCel() {
  var telefono = $("#tel_movil").val();
  
  var expreg = /^(\+?56)?(\s?)(0?9)(\s?)[98765432]\d{7}$/m;
  
  if (!expreg.test(telefono)){
      Swal.fire(
        'A ocurrido un error!',
        'Celular incorrecto o campo vacío',
        'error'
      )
      $("#tel_movil").val('');
    }
  }