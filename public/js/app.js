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
     * Modal para eliminar un coche
     */
    $('#modalDeleteCar').on('show.bs.modal', function (event) {
        
        var modal = $(this);
        var button = $(event.relatedTarget); // Button that triggered the modal
        $('#form-car-destroy').attr('action', button.data('form_action'));
        modal.find('.modal-body p').html(button.data('car_name'));
        modal.find('[aria-borrar]').attr('onclick','$(\'#form-car-destroy\').submit();');
    });


    /**
     * Modal para eliminar imágenes de los coches al editar la ficha
     * Si no es un entero imageId, se borra la imagen principal. Si es entero se borra de la galería
     */
    $('#modalDeleteImage').on('show.bs.modal', function (event) {
        
        var modal = $(this);
        var button = $(event.relatedTarget); // Button that triggered the modal
        var carId = button.data('car_id');
        var imageId = button.data('image_id');
        var imageSrc = button.data('image_src');
        modal.find('.modal-body img').attr('src',imageSrc);
        modal.find('[aria-borrar]').attr('onclick','carDeleteImage(' + carId + ',' + imageId + ');');
    });


});