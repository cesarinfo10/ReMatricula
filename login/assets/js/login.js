$(document).ready(function() {

    $('#recuRUT').hide();
});


function login(){
    let email = $("#email").val();
    let pass = $("#pass").val();

    let dataString = 'email='+email +'&pass='+pass;
  
  
  $.ajax({
              type: "POST",
              url: "../service/login.php?getSesion",
              data: dataString,
              success: function(data) {
                if (data==2){
                    Swal.fire(
                        'A ocurrido un error!',
                        'Email o contraseña incorrectos',
                        'error'
                      )

                     $("#email").val('');
                     $("#pass").val('');
                } else if (data== 1){
                    localStorage.setItem("email", email)
                    location.href="https://matriculate.umc.cl/sgu/MatriculaOnline/IngresoMatriculaOnlineAlumno.php";
                } else if (data== 3){
                  localStorage.setItem("email", email);
                  location.href=" https://matriculate.umc.cl/sgu/MatriculaOnline/login/views/cambiar_pass.html"
                }            
              }
  
          });
  }

  function mostrarRut(){
    $('#recuRUT').show();
    $('#recuEmail').hide();
    $("#emailRecupera").val('');
}
function mostrarEmail(){
  $('#recuEmail').show();
  $('#recuRUT').hide();
  $("#RutRecupera").val('');
}
  function recuperarPass(){

    let correo =$("#emailRecupera").val();
    let rut =$("#RutRecupera").val();

    let dataString = 'email='+correo+'&rut='+rut;
  
  $.ajax({
              type: "POST",
              url: "../service/login.php?newPass",
              data: dataString,
              success: function(data) {
                if (data==2){
                    Swal.fire(
                        'Atención!',
                        'Su Email no esta registrado, por favor registrece para continuar',
                        'error'
                      )

                     $("#email").val('');
                     $("#pass").val('');
                } else if (data != 2 || data != 3 || data != null || data != ''){
                  console.log(data);

                  let msj = {
                    correo: data,
                    mensaje:  'Su nueva contraseña es su RUT, sin punto y con el digito verificador, por ejemplo 11111111-1, si termina en K debe ser en MAYÚSCULA'
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

                Swal.fire(
                  'Finalizado!',
                  'Correo enviado correctamente, por favor revise su bandeja  de entrada',
                  'success'
                );
                setTimeout(() => {
                  location.href="https://matriculate.umc.cl/";
                }, "5000"); 

                }  else if (data== 3){    
                  Swal.fire(
                    'Error!',
                    'No es possible continuar',
                    'error'
                  )
                }      
              }
  
          });

  }
  
  function updatePass(){

    let pass = $("#passRe").val();
    let pass_rep = $("#passRepRe").val();
    let email= localStorage.getItem('email')
  
    let dataString = 'email='+email +'&pass='+pass+'&pass_rep='+pass_rep;
if (pass != pass_rep){
  Swal.fire(
    'Error!',
    'El Password no coinciden',
    'error'
  )
}else{
  $.ajax({
              type: "POST",
              url: "../service/login.php?updatePass",
              data: dataString,
              success: function(data) {
                if (data==2){
                        Swal.fire(
                          'Error!',
                          'No es possible continuar',
                          'error'
                        )
                     $("#email").val('');
                     $("#pass").val('');
                } else if (data== 1){

                Swal.fire(
                  'Finalizado!',
                  'Será redirigido al Login',
                  'success'
                );
                setTimeout(() => {
                  location.href="https://matriculate.umc.cl/";
                }, "5000"); 

                }       
              }
  
          })
        }
  }