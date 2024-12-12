@extends('layouts.main') 
@section('title', __('Carga Masiva'))
<link rel="stylesheet" href="{{ asset('vendor/fileupload/css/jquery.fileupload.css') }}">
<script>
  // Añade un evento para ejecutar el código cuando la página se haya cargado
  window.addEventListener('load', function() {
      const divHistorical = document.getElementById('cargamasiva');
      divHistorical.style.display = 'block'; // Muestra el div
  });
</script>

  <style>
#cargamasiva {
          display: none; /* Oculta el div inicialmente */
      }
</style>
<div class="section-body normal-width" id="cargamasiva">
  <div class="mx-0 mt-5 row">
    <div class="mx-auto col-md-12 rounded-card">
      <div class="card">
        <div class="card-header">
          <h5 class="text-center w-100" id="new-title">Carga Masiva</h5>
        </div>
        <div class="card-body form-card-body">
          <strong>INSTRUCCIONES:</strong>
          <ul class="note-list">
            <li> Esta herramienta agiliza la carga rápida de bases de datos en CSV o TXT actualizando la base de datos de un formulario único, para que los usuarios puedan ver la totalidad de información vigente. </li>
            <li> Si desea actualizar los datos en un registro, seleccione el nombre del formulario deseado, seleccione el archivo a cargar y luego haga clic en el botón “Cargar y Actualizar Datos” para subir el nuevo archivo. </li>
            <li> Evite cargar archivos que sean distintos al formato correcto recomendado. Proceda con precaución. </li>
            <li> Si desea puede verificar el formato correcto de sus archivos aquí:
              <ul>
                <li> <a href="../../docs/Registro Usuario.xlsx" target="_blank">Registro Usuario</a></li>
                <li> <a href="../../docs/Registro Espacios.xlsx" target="_blank">Registro Espacios</a></li>
                <li> <a href="../../docs/Registro DEA.xlsx" target="_blank">Registro DEA</a></li>
              </ul> </li>
          </ul>
          
		  <form method="post" action="carga-masiva" id="fileupload" class="form-inline" enctype="multipart/form-data">
			{{ csrf_field() }}
			<!--{ !! Form::label('marca_id', 'Actualizar Datos Registrados:') !!}
				  <br>
				  { !! Form::select('marca_id', $marcas->pluck('nombre', 'id'),null, ['class'=> 'form-control']) !!}-->
          <div class="form-group">
            <select name="formulario" class="form-control" id="formularioss">
              <option value="9">Registro Usuario</option>
              <option value="7">Registro Espacios</option>
              <option value="33">Registro DEA</option>
            </select>
          </div>
			<span class="btn btn-success fileinput-button">
			  <i class="glyphicon glyphicon-plus"></i>
			  <span>Cargar y Actualizar Datos</span>
			  <!-- The file input field used as target for the file upload widget -->
			  <input type="file" id="fileuploader" name="archivos" multiple>
			</span>
      
        <input type="submit" name="enviar" class="btn btn-success fileinput-button">
		  </form>

		  <br>
		  <br>
		  <p> Carga de archivo: </p>
		  <!-- The global progress bar -->
		  <div id="progress" class="progress">
			<div class="progress-bar progress-bar-success"></div>
		  </div>
		  <!-- The container for the uploaded files -->
		  <div id="files" class="files"></div>
		  <br>
      @if (isset($error))
      <div class="text-danger">
        <h4>{!!html_entity_decode($error)!!}</h4>
      </div>
      @endif
      @if (isset($resultado))
      <div class="text-success">
        <h4>{!!html_entity_decode($resultado)!!}</h4>
      </div>
      @endif
        </div>
     
      </div>
    
    </div>
  </div>
</div>
<div class="forms-footer">
  <div class="footer-bottom footer-mobile">
    <div class="footer_gov_">
      <div class="centradototal_ fooflex">
        <div class="logos_footer_gov">
          <a href="https://www.colombia.co" target="_blank">
            <img class="marcaco_l" src="../../images/logo.png" alt="colombia.co" />
          </a>
        </div>
        <div class="alcaldia_mod_footer">
          <a href="https://www.medellin.gov.co/es">
            <img class="log_nww_footer" src="../../images/logo_nav_footer.png" alt="Alcaldía de Medellín" />
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('vendor/fileupload/js/vendor/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('vendor/fileupload/js/jquery.fileupload.js') }}"></script>
<script src="{{ asset('vendor/fileupload/js/jquery.fileupload-process.js') }}"></script>
<script src="{{ asset('vendor/fileupload/js/jquery.fileupload-validate.js') }}"></script>
<script src="{{ asset('vendor/fileupload/js/jquery.iframe-transport.js') }}"></script>
<script>
  $(function() {
        'use strict';
        var url = "",
          uploadButton = $(' < button / > ').addClass('
            btn btn - primary ').prop('
            disabled ', true).text('
            Procesando...').on('
            click ', function() {
            var $this = $(this),
              data = $this.data(); $this.off('click').text('Cancelar').append(' < i class = "fa fa-spinner fa-spin" >< /i>').on('click', function() {
              $this.remove();
              data.abort();
            }); data.submit().always(function() {
              $this.remove();
            });
          }); $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(xlsx|xls|txt|ods)$/i,
        maxFileSize: 999000,
        disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
      }).on('fileuploadadd', function(e, data) {
          data.context = $(' < div / > ').appendTo('
            #files ');
            $.each(data.files, function(index, file) {
              var node = $(' < p / > ').append($(' < span / > ').text(file.name));
              if (!index) {
                node.append(' < br > ').append(uploadButton.clone(true).data(data));
              }
              node.appendTo(data.context);
            });
          }).on('fileuploadprocessalways', function(e, data) {
            var index = data.index,
              file = data.files[index],
              node = $(data.context.children()[index]);
            if (file.preview) {
              node.prepend(' < br > ').prepend(file.preview);
            }
            if (file.error) {
              node.append(' < br > ').append($(' <span class = "text-danger" > ').text('
                  Extension de archivo no válida'));
                }
                if (index + 1 === data.files.length) {
                  data.context.find('button').text('Subir archivo').prop('disabled', !!data.files.error);
                }
              }).on('fileuploadprogressall', function(e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css('width', progress + '%');
              }).on('fileuploaddone', function(e, data) {
                  $.each(data.files, function(index) {
                    console.log(index, data)
                    var success = $(' <span class = "text-success"  > ').text('
                      ¡Registros actualizados exitosamente!');
                      var results = $(' <span class = "text-success"  > ').text(data.result.files.results + '
                        Registros Guardados ');
                        $(data.context.children()[index]).append(' < br > ').append(success).append(' < br > ').append(results);
                      });
                  }).on('fileuploadfail', function(e, data) {
                      $.each(data.files, function(index) {
                          var error = $(' <span class = "text-danger" / > ').text('
                            Error al subir archivo. Favor verificar que la estructura del archivo sea correcta.');
                            $(data.context.children()[index]).append(' < br > ').append(error);
                          });
                      }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
                  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
      const formularioSelect = document.getElementById('formularioss');
      const fileUploader = document.getElementById('fileuploader');

      fileUploader.addEventListener('change', function(event) {
          const selectedOption = formularioSelect.value;
          const fileName = event.target.files[0].name;
          const fileBaseName = fileName.split('.').slice(0, -1).join('.');

         /* if (fileBaseName !== selectedOption) {
              alert('El nombre del archivo no coincide con la opción seleccionada.');
              fileUploader.value = ''; // Resetea el input para evitar la carga del archivo
          }*/
      });
  });
</script>
<style>
  .btn-success {
    margin: 0 0.25em;
}
</style>