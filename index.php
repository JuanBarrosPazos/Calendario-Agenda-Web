<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calendario de Eventos</title>

<!-- Scripts CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/datatables.min.css">
<link rel="stylesheet" href="css/bootstrap-clockpicker.css">
<link rel="stylesheet" href="fullcalendar/main.css">

<!-- Scripts JS -->
<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/datatables.min.js"></script>
<script src="js/bootstrap-clockpicker.js"></script>
<script src="js/moment-with-locales.js"></script>
<script src="fullcalendar/main.js"></script>

    <style>
      .MyButtonClose {  display: block;
                        width: auto;
                        margin: 2px 6px 2px 90%;
                        float: right !important;
                        background-color: #ec0332 !important;
                        font-size: 1.2em;
                        color: #f8bd3d !important; 
                        border-top: 1px solid #ff1c49 !important;
                        border-left: 1px solid #ff1c49 !important;
                        border-bottom: 1px solid #660101 !important;
                        border-right: 1px solid #660101 !important;
                        border-radius: 8px !important; 
                        font-weight: bold !important;
                        padding: 0.1em 0.6em;
                      }
      .MyButtonClose:hover { 
                        color: #ec0332 !important; 
                        border-top: 1px solid #a77200 !important;
                        border-left: 1px solid #a77200 !important;
                        border-bottom: 1px solid #f8bd3d !important;
                        border-right: 1px solid #f8bd3d !important;
                      }
      .MyButtonCancel{
                        background-color: #ffaf04 !important;
                      }
      .MyButtonClose:hover, .MyButtonCancel:hover{
                        background-color: #e49c01 !important;
                      }

    </style>

  </head>
  <body>

    <div class="container-fluid">
      <section class="content-header">
        <h1>
          Calendario
          <small>Panel de control</small>
        </h1>
      </section>

      <div class="row">
        <div class="col-10">
          <div id="Calendario1" style="border: 1px solid #000; padding:2px"></div>
        </div>
        <div class="col-2">
          <div id="external-events" style="margin-bottom:1em; height:350px; border: 1px solid #343434; border-radius: 6px; overflow: auto; padding:0.4em">
            <h4 class="text-center">Eventos predefinidos</h4>
            <div id="listaeventospredefinidos">

      <?php

        require("conexion.php");
        $conexion = regresarConexion();

        global $datos;
        $datos = mysqli_query($conexion, "SELECT id,titulo,horainicio,horafin,colortexto,colorfondo FROM eventospredefinidos ORDER BY horainicio ASC");
        global $ep;
        $ep = mysqli_fetch_all($datos, MYSQLI_ASSOC);

        function ListEventPre(){
          global $datos;
          global $ep;
          foreach ($ep as $fila) {
          echo "<div class='fc-event' data-titulo='$fila[titulo]' data-horafin='$fila[horafin]' data-horainicio='$fila[horainicio]' data-colorfondo='$fila[colorfondo]' data-colortexto='$fila[colortexto]' style='border:solid 1px #343434; color:$fila[colortexto]; background-color:$fila[colorfondo]; margin:4px; padding: 6px; border-radius: 6px !important;'>
          $fila[titulo]<br>".substr($fila['horainicio'],0,5)." => " .substr($fila['horafin'],0,5)."</div>";
               }
          } // FIN FUNCTION ListEventPre()

          ListEventPre();
      ?>

            </div>
          </div>
          <hr>
          <div class="" style="text-align:center">
            <button type="button" id="BotonEventosPredefinidos" class="btn btn-success">
              Administrar eventos predefinidos
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Formulario de Eventos -->
    <div class="modal fade" id="FormularioEventos" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close MyButtonClose" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">X</span>
            </button>
          </div>

          <div class="modal-body">
            <input type="hidden" id="Id">
            <input type="hidden" id="OldTitulo">
            <div class="form-row">
              <div class="form-group col-12">
                <label for="">Titulo del Evento:</label>
                <input type="text" id="Titulo" class="form-control" placeholder="">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Fecha de inicio:</label>
                <div class="input-group" data-autoclose="true">
                  <input type="date" id="FechaInicio" value="" class="form-control">
                </div>
              </div>
              <div class="form-group col-md-6" id="TituloHoraInicio">
                <label>Hora de inicio:</label>
                <div class="input-group clockpicker" data-autoclose="true">
                  <input type="text" id="HoraInicio" value="" class="form-control" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="">Fecha de fin:</label>
                <div class="input-group" data-autoclose="true">
                  <input type="date" id="FechaFin" class="form-control" value="">
                </div>
              </div>
              <div class="form-group col-md-6" id="TituloHoraFin">
                <label for="">Hora de fin:</label>
                <div class="input-group clockpicker" data-autoclose="true">
                  <input type="text" id="HoraFin" class="form-control" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="form-row">
              <label for="">Descripcion:</label>
              <textarea id="Descripcion" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-row">
              <label for="">Color de fondo:</label>
              <input type="color" value="#3788D8" id="ColorFondo" class="form-control" style="height:36px;">
            </div>
            <div class="form-row">
              <label for="">Color de texto:</label>
              <input type="color" value="#ffffff" id="ColorTexto" class="form-control" style="height:36px;">
            </div>

          </div>

          <div class="modal-footer">
            <button type="button" id="BotonAgregar" class="btn btn-success">Agregar</button>
            <div style="display:inline-block; width:98%; text-align: right">
            <button type="button" id="BotonModificar" class="btn btn-success">Modifica Este</button>
            <button type="button" id="BotonModificarRel" class="btn btn-success">Modifica Relacionados</button>
            <button type="button" id="BotonModificarRelTot" class="btn btn-success">Modifica Todos</button>
            </div>
            <div style="display:inline-block; width:98%; text-align: right">
            <button type="button" id="BotonBorrar" class="btn btn-danger">Borrar Este Evento</button>
            <button type="button" id="BotonBorrarRel" class="btn btn-danger">Borrar Relacionados</button>
            </div>
            <button type="button" class="btn btn-success MyButtonCancel" data-bs-dismiss="modal">Cancelar</button>
          </div>

        </div>
      </div>
    </div>


    <script>

document.addEventListener("DOMContentLoaded", function(){

    new FullCalendar.Draggable(document.getElementById('listaeventospredefinidos'), {
      itemSelector: '.fc-event',
      eventData: function(eventEl){
        return{
            title: eventEl.innerText.trim()
        }
      }
    });

    $('.clockpicker').clockpicker();

    let calendario1 = new FullCalendar.Calendar(document.getElementById('Calendario1'),{
      droppable: true,
      height: 850,
      headerToolbar:{
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      editable: true,
      events: 'datoseventos.php?accion=listar',
      dateClick: function(info){
        limpiarFormulario();
        $('#BotonAgregar').show();
        $('#BotonModificar').hide();
        $('#BotonModificarRel').hide();
        $('#BotonModificarRelTot').hide();
        $('#BotonBorrar').hide();
        $('#BotonBorrarRel').hide();

        if (info.allDay) {
          $('#FechaInicio').val(info.dateStr);
          $('#FechaFin').val(info.dateStr);
        }else{
          let fechaHora = info.dateStr.split("T");
          $('#FechaInicio').val(fechaHora[0]);
          $('#FechaFin').val(fechaHora[0]);
          $('#HoraInicio').val(fechaHora[1].substring(0,5));
        }
        $("#FormularioEventos").modal('show');
      },
      eventClick: function(info) {
        $('#BotonAgregar').hide();
        $('#BotonModificar').show();
        $('#BotonModificarRel').show();
        $('#BotonModificarRelTot').show();
        $('#BotonBorrar').show();
        $('#BotonBorrarRel').show();
        $('#Id').val(info.event.id);
        $('#Titulo').val(info.event.title);
        $('#OldTitulo').val(info.event.title);
        $('#Descripcion').val(info.event.extendedProps.descripcion);
        $('#FechaInicio').val(moment(info.event.start).format("YYYY-MM-DD"));
        $('#FechaFin').val(moment(info.event.end).format("YYYY-MM-DD"));
        $('#HoraInicio').val(moment(info.event.start).format("HH:mm"));
        $('#HoraFin').val(moment(info.event.end).format("HH:mm"));
        $('#ColorFondo').val(info.event.backgroundColor);
        $('#ColorTexto').val(info.event.textColor);
        $("#FormularioEventos").modal('show');
      },
      eventResize: function(info){
        $('#Id').val(info.event.id);
        $('#Titulo').val(info.event.title);
        //$('#OldTitulo').val(info.event.title);
        $('#Descripcion').val(info.event.extendedProps.descripcion);
        $('#FechaInicio').val(moment(info.event.start).format("YYYY-MM-DD"));
        $('#FechaFin').val(moment(info.event.end).format("YYYY-MM-DD"));
        $('#HoraInicio').val(moment(info.event.start).format("HH:mm"));
        $('#HoraFin').val(moment(info.event.end).format("HH:mm"));
        $('#ColorFondo').val(info.event.backgroundColor);
        $('#ColorTexto').val(info.event.textColor);
        let registro = recuperarDatosFormulario();
        modificarRegistro(registro);
      },
      eventDrop: function(info){
        $('#Id').val(info.event.id);
        $('#Titulo').val(info.event.title);
        //$('#OldTitulo').val(info.event.title);
        $('#Descripcion').val(info.event.extendedProps.descripcion);
        $('#FechaInicio').val(moment(info.event.start).format("YYYY-MM-DD"));
        $('#FechaFin').val(moment(info.event.end).format("YYYY-MM-DD"));
        $('#HoraInicio').val(moment(info.event.start).format("HH:mm"));
        $('#HoraFin').val(moment(info.event.end).format("HH:mm"));
        $('#ColorFondo').val(info.event.backgroundColor);
        $('#ColorTexto').val(info.event.textColor);
        let registro = recuperarDatosFormulario();
        modificarRegistro(registro);
      },
      drop: function(info){
        limpiarFormulario();
        $('#ColorFondo').val(info.draggedEl.dataset.colorfondo);
        $('#ColorTexto').val(info.draggedEl.dataset.colortexto);
        $('#Titulo').val(info.draggedEl.dataset.titulo);
        let fechaHora = info.dateStr.split("T");
        $('#FechaInicio').val(fechaHora[0]);
        $('#FechaFin').val(fechaHora[0]);
        if (info.allDay) {
          $('#HoraInicio').val(info.draggedEl.dataset.horainicio);
          $('#HoraFin').val(info.draggedEl.dataset.horafin);
        }else{
          $('#HoraInicio').val(fechaHora[1].substring(0,5));
          $('#HoraFin').val(moment(fechaHora[1].substring(0,5)).add(1,'hours'));
        }
        let registro = recuperarDatosFormulario();
        agregarEventoPredefinido(registro);
      }
    });

    calendario1.render();

    //Eventos de botones de la aplicacion
    $('#BotonAgregar').click(function(){
      let registro = recuperarDatosFormulario();
      agregarRegistro(registro);
      $('#FormularioEventos').modal('hide');
    });

    $('#BotonModificar').click(function(){
        let registro = recuperarDatosFormulario();
      if (confirm("MODIFICARAS EL EVENTO "+registro.titulo+"!!!")) {
        modificarRegistro(registro);
        $('#FormularioEventos').modal('hide');
      }else{$('#FormularioEventos').modal('hide');}
    });

    $('#BotonModificarRel').click(function(){
      /*alert("ESTA FUNCION NO ESTA DISPONIBLE");*/
        let registro = recuperarDatosFormulario();
      if (confirm(" EXCEPTO FECHA!!! MODIFICARAS EL EVENTO "+registro.oldtitle+", Y EN CALENDARIO TODOS LOS RELACIONADOS!!!")) {
        modificarRegistroRel(registro);
        $('#FormularioEventos').modal('hide');
      }else{$('#FormularioEventos').modal('hide');}
    });

    $('#BotonModificarRelTot').click(function(){
      /*alert("ESTA FUNCION NO ESTA DISPONIBLE");*/
        let registro = recuperarDatosFormulario();
      if (confirm(" EXCEPTO FECHA!!! MODIFICARAS EL EVENTO "+registro.oldtitle+", Y EN CALENDARIO Y EVENTOS PREDEFINIDOS TODOS LOS RELACIONADOS!!!")) {
        modificarRegistroRelTot(registro);
        $('#FormularioEventos').modal('hide');
      }else{$('#FormularioEventos').modal('hide');}
    });

    $('#BotonBorrar').click(function(){
        let registro = recuperarDatosFormulario();
      if (confirm("BORRARAS EL EVENTO "+registro.titulo+"!!!")) {
        borrarRegistro(registro);
        $('#FormularioEventos').modal('hide');
      }else{$('#FormularioEventos').modal('hide');}
    });

    $('#BotonBorrarRel').click(function(){
        let registro = recuperarDatosFormulario();
      if (confirm("BORRARAS EL EVENTO "+registro.titulo+" Y TODOS LOS RELACIONADOS EN EL CALENDARIO!!!")) {
        borrarRegistroRel(registro);
        $('#FormularioEventos').modal('hide');
      }else{$('#FormularioEventos').modal('hide');}
    });

    $('#BotonEventosPredefinidos').click(function(){
      window.location = "eventospredefinidos.html";
    });


    //funciones para comunicarse con el servidor AJAX!
    function agregarRegistro(registro) {
      $.ajax({
        type: 'POST',
        url: 'datoseventos.php?accion=agregar',
        data: registro,
        success: function(msg){
          calendario1.refetchEvents();
        },
        error: function(error) {
          alert("ERROR AL AGREGAR EL EVENTO: " + error);
        }
      });
    }

    function modificarRegistro(registro){
      $.ajax({
        type: 'POST',
        url: 'datoseventos.php?accion=modificar',
        data: registro,
        success: function(msg){
          calendario1.refetchEvents();
        },
        error: function(error) {
          alert("ERROR AL MODIFICAR EL EVENTO: " + error);
        }
      });
    }

    function modificarRegistroRel(registro){
      $.ajax({
        type: 'POST',
        url: 'datoseventos.php?accion=modificarRel&oldtitle='+registro.oldtitle,
        data: registro,
        success: function(msg){
          calendario1.refetchEvents();
          location.reload();
        },
        error: function(error) {
          alert("ERROR AL MODIFICAR EL EVENTO: "+registro.oldtitle);
        }
      });
    }

    function modificarRegistroRelTot(registro){
      $.ajax({
        type: 'POST',
        url: 'datoseventos.php?accion=modificarRelTot&oldtitle='+registro.oldtitle,
        data: registro,
        success: function(msg){
          calendario1.refetchEvents();
          location.reload();
        },
        error: function(error) {
          alert("ERROR AL MODIFICAR EL EVENTO: "+registro.oldtitle);
        }
      });
    }

    function borrarRegistro(registro){
      $.ajax({
        type: 'POST',
        url: 'datoseventos.php?accion=borrar',
        data: registro,
        success: function(msg){
          calendario1.refetchEvents();
        },
        error: function(error) {
          alert("ERROR AL BORRAR EL EVENTO: "+registro.id);
        }
      });
    }

    function borrarRegistroRel(registro){
      $.ajax({
        type: 'POST',
        url: 'datoseventos.php?accion=borrarRel&titulo='+registro.titulo,
        data: registro,
        success: function(msg){
          calendario1.refetchEvents();
        },
        error: function(error) {
          alert("ERROR AL BORRAR: "+registro.titulo);
        }
      });
    }

    function agregarEventoPredefinido(registro){
      $.ajax({
        type: 'POST',
        url: 'datoseventos.php?accion=agregar',
        data: registro,
        success: function(msg){
          calendario1.removeAllEvents();
          calendario1.refetchEvents();
        },
        error: function(error) {
          alert("ERROR AL AGREGAR EL EVENTO: " + error);
        }
      });
    }


    //funciones que interactuan con el FormularioEventos

    function limpiarFormulario(){
      $('#Id').val('');
      $('#Titulo').val('');
      $('#OldTitulo').val('');
      $('#Descripcion').val('');
      $('#FechaFin').val('');
      $('#FechaInicio').val('');
      $('#HoraInicio').val('');
      $('#HoraFin').val('');
      $('#ColorFondo').val('#3788D8');
      $('#ColorTexto').val('#ffffff');
    }

    function recuperarDatosFormulario(){
      let registro = {
        id: $('#Id').val(),
        oldtitle: $('#OldTitulo').val(),
        titulo: $('#Titulo').val(),
        descripcion: $('#Descripcion').val(),
        inicio: $('#FechaInicio').val() + ' ' + $('#HoraInicio').val(),
        fin: $('#FechaFin').val() + ' ' + $('#HoraFin').val(),
        colorfondo: $('#ColorFondo').val(),
        colortexto: $('#ColorTexto').val()
      }
      return registro;
    }

});
    </script>


  </body>
</html>
