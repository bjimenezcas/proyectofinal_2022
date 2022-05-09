var success_model;
var updated_model;

function FileUpload(previewId) {
    var response = previewId.response.uploaded;
    var error = response.error;
    var success = response.success;
    var updated = response.updated;
    success_model = response.success_model;
    updated_model = response.updated_model;
    LoopTableData(success_model, 'success');
    LoopTableData(updated_model, 'updated');

    $('#process_message').html('Se van a crear <span class="badge bg-success">' + success + '</span> registros, se van a actualizar <span class="badge bg-primary">' + updated + '</span> registros y existen <span class="badge bg-danger">' + error + '</span> errores.');
    $('#form_process').show();
}
//FileUpload();
function LoopTableData(data, type) {
    var div,html_data,title;
    if (type == 'success') {
        div = $('#div_success_model');
        title='<h4 class="text-center text-success"><div class="spinner-grow text-success" role="status"></div> Registros para crear</h4>';
    }
    else if(type == 'updated') {
        div = $('#div_updated_model');
        title='<h4 class="text-center text-primary"><div class="spinner-grow text-primary" role="status"></div> Registros para actualizar</h4>';
    }
    if(data && data.length !== 0)
    {
        html_data=title+'<table class="table"> <thead> <tr> <th scope="col">Usuario</th> <th scope="col">DNI</th> <th scope="col">Rol</th> <th scope="col">Código gestor</th> <th scope="col">Estado</th> <th scope="col">Inicial de agencia</th> <th scope="col">Fecha de baja</th> <th scope="col">F. creación</th> </tr></thead> <tbody>';
        for (const element of data) {

            html_data+='<tr><td>'+element.code_large+'</td><td>'+element.dni+'</td><td>'+element.rol+'</td><td>'+element.code_short+'</td><td>'+element.status+'</td><td>'+element.agency+'</td><td>'+element.unsubscribed_date+'</td><td>'+element.created_at+'</td></tr>';
        }
        html_data+='</tbody></table>';
    }
div.html(html_data);
}

function LoadingButtonCsv(type) {
    if (type == 'show') {
        $('#ButtonSaveFileCsv').prop('disabled', true);

        $('#ButtonSaveFileCsv').html('  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...');
    } else if (type == 'hide') {

        $('#ButtonSaveFileCsv').html('Hecho');
    }
}

function SaveFileUpload() {
    var selector = $('#SelectSave').val();
    if (selector !== '') {

        LoadingButtonCsv('show');
        $.ajax({
            url: 'upload_save',
            type: 'post',
            data: {
                "selector": selector,
                "success_model": success_model,
                "updated_model": updated_model
            },
            dataType: 'json',
            success: function (mensaje) {

                LoadingButtonCsv('hide');
                $('#process_message').append('<p>Proceso ejecutado correctamente</p>');
            },
            error: function () {
                alert('An error has occured while adding a new block.');
            }
        });

    }
}