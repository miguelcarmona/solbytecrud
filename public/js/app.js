$(document).ready(function() {

    /**
     * Modal de imágenes a pantalla completa
     */

    // Abrir modal seleccionando el src de la imagen automáticamente
    $('[aria-img-modal]').on('click', function(e) {
        e.preventDefault();
        let img_src = $(this).attr('src');
        $('#img_modal img').attr('src', img_src);
        $('#img_modal').addClass('visible');
    });

    // Cerrar el modal cuando se hace clic en cualquier parte
    $('#img_modal').on('click', function(e) {
        $(this).removeClass('visible');
    });


    /**
     * Modal para eliminar una categoría
     */
    $('#modalDeleteCategory').on('show.bs.modal', function (event) {
        
        var modal = $(this);
        var button = $(event.relatedTarget); // Button that triggered the modal
        $('#form-destroy').attr('action', button.data('form_action'));
        modal.find('.modal-body p').html(button.data('car_name'));
        modal.find('[aria-borrar]').attr('onclick','$(\'#form-destroy\').submit();');
    });


    /**
     * Modal para eliminar un coche
     */
    $('#modalDeleteCar').on('show.bs.modal', function (event) {
        
        var modal = $(this);
        var button = $(event.relatedTarget); // Button that triggered the modal
        $('#form-destroy').attr('action', button.data('form_action'));
        modal.find('.modal-body p').html(button.data('car_name'));
        modal.find('[aria-borrar]').attr('onclick','$(\'#form-destroy\').submit();');
    });


    /**
     * Modal para eliminar imágenes de los coches al editar la ficha
     * Si no es un entero imageId, se borra la imagen principal. Si es entero se borra de la galería
     */
    $('#modalDeleteImage').on('show.bs.modal', function (event) {
        
        var modal = $(this);
        var button = $(event.relatedTarget); // Button that triggered the modal
        modal.find('.modal-body img').attr('src',button.data('image_src'));
        modal.find('[aria-borrar]').attr('onclick',
            'carDeleteImage(' + button.data('car_id') + ',' + button.data('image_id') + ',\'' + button.data('csrf_token') + '\');');
    });


    /**
     * Formulario para ordenar la tabla cars
     */
    $('#carSearch select#sort, #carSearch select#direction').on('change', function() {
        $('#carSearch').submit();
    });

    /** Limpiar el input search con el botón X */
    $('#carSearch div.input-group .btn-secondary').on('click', function() {
        $('#search_input_id').val(''); // Vacía el input
        $('#carSearch').submit(); // Envía el formulario para vaciar
    //      $(this).blur(); // Quita el foco del botón
    });

    // Limpia el foco del botón de mostrar el formulario de ordenar
    $('#order-button').on('click', function(){
        $(this).blur();
    });


    /**
     * PWA
     */
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/service-worker.js');
    }

});

/**
 * Realiza una petición ajax para eliminar la imagen principal o de galería de un coche
 */
function carDeleteImage(carId, imageId, csrf_token) {
        
    $('#modalDeleteImage').modal('hide');

    let url;
    let figureId;
    if( !imageId ) {
        url = '/cars/' + carId + '/destroymainimage';
        figureId = 'image-'+ carId;
    } else {
        url = '/cars/' + carId + '/images/' + imageId;
        figureId = 'image-' + carId + '-' + imageId;
    }

    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrf_token,
            'Content-Type': 'application/json'  
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(figureId).remove();
        } else {
            alert('Error al eliminar la imagen');
        }
    })
    .catch(error => console.error('Error:', error));
}
