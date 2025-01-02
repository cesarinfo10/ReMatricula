<!DOCTYPE html>
      <html lang="es">
      <head>
        <title>Mantenedor Becas</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" ></head>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      </head>
      <div style="height:30px !important;background-color: #014289;">
      </div>
      <body>
      <div class="jumbotron text-center" style="height: 150px !important; ">
      <img src="../../login/assets/img/logo-universidad-miguel-de-cervantes-umc_sesion.png" alt="LOGO">
        <h1>Mantenedor</h1>
      </div>
      <div class="container">
      <nav class="navbar navbar-expand-sm bg-dark navbar-dark" style="background-color: #014289 !important;">

  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="ocultarTodo()">Ocultar Mantenedor</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="mostrarBecas()">BECAS</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="mostrarOfertas()">OFERTAS</a>
    </li>
  </ul>
</div>
</nav>
      <div class="container" id="becas">
        <div class="row">
          <div class="col-sm-12">
          <h3 class="text-center">Becas</h3>
            <div class="row">
                <div class="col-sm-4">
                <label>Descripción Descuento</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion">
                </div>
                <div class="col-sm-4">
                <label>Desc. Pregrado Mat.</label>
                <input type="number" class="form-control" id="dscto_pregrado_mat" name="dscto_pregrado_mat">
                </div>
                <div class="col-sm-4">
                <label>Desc. Pregrado Ara.</label>
                <input type="number" class="form-control" id="dscto_pregrado_ara" name="dscto_pregrado_ara">
                </div>
            </div>
    
            
          </div>
          </div>
          <div class="row">
          <div class="col-sm-12">
      
            <div class="row pt-3">
                <div class="col-sm-4">
                <label>Desc. Licenciatura Mat.</label>
                <input type="number" class="form-control" id="dscto_licenciatura_mat" name="dscto_licenciatura_mat">
                </div>
                <div class="col-sm-4">
                <label>Desc. Licenciatura Arancel</label>
                <input type="number" class="form-control" id="dscto_licenciatura_ara" name="dscto_licenciatura_ara">
                </div>
                <div class="col-sm-4 text-center">
                <label></label>
                <input type="hidden" class="form-control" id="id">
                <br>
                <button type="button" class="btn btn-success" id="btnInsert" onclick="insertarBeca()">Guardar</button>
                <button type="button" class="btn btn-success" id="btnUpdate" onclick="updateBeca()">Guardar</button>
                </div>
            </div>
    
            
          </div>
          </div>
          <div class="row">
          <div class="col-sm-12">

     
          <div id="ddl_becastbl"></div>


        </div>
        </div>
      </div>
      
      <div class="container" id="Ofertas">
        <div class="row">
          <div class="col-sm-12">
      <h3 class="text-center">Ofertas</h3>
            <div class="row">
                <div class="col-sm-4">
                <label>Jornada</label>
                <select class="form-control" name="jornada" id="jornada" onchange="llamarProgCarrera();" style="visibility: visible;">
                <option value="0">Seleccione</option>
                  <option value="D" class="1">Diurno</option>
                  <option value="V" class="2">Vespertino</option>
              </select>
                </div>
                <div class="col-sm-4">
                <label>Desc. Pregrado Mat.</label>
                <div id="ddl_carreras">
                  <select class="form-control" style="visibility: visible;">
                  <option value="0">Seleccione</option>

                </select>
                  </div>
                </div>
                <div class="col-sm-4">
                <label>Porcentaje Matricula</label>
                <input type="number" class="form-control" id="porcentaje_becas_mat" name="porcentaje_becas_mat">
                </div>
            </div>
    
            
          </div>
          </div>
          <div class="row">
          <div class="col-sm-12">
      
            <div class="row pt-3">
                <div class="col-sm-4">
                <label>Porcentaje Arancel</label>
                <input type="number" class="form-control" id="porcentaje_becas_ara" name="porcentaje_becas_ara">
                </div>
                <div class="col-sm-4 text-center">
                <br>
                <br>
                <button type="button" class="btn btn-success" id="btnInsertOf" onclick="insertarOfertas()">Guardar</button>
                <button type="button" class="btn btn-success" id="btnUpdateOf" onclick="updateOfertas()">Guardar</button>
                </div>
                <div class="col-sm-4 text-center">
                <label></label>
                <input type="hidden" class="form-control" id="idOferta">
                </div>
            </div>
    
            
          </div>
          </div>
          <div class="row">
          <div class="col-sm-12">

     
          <div id="ddl_Ofertastbl"></div>


        </div>
        </div>
      </div>

      </body>
      <script src="/sgu/MatriculaOnline/js/jquery-1.10.1.min.js"></script>
      <script src="/sgu/MatriculaOnline/js/mantenedores.js"></script>
      </html>