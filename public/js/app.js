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

});