<script>
  // Al hacer clic en "Editar", habilitar la edición de las celdas de la fila y resaltar la fila
  $('.edit-product').click(function(e) {
    e.preventDefault();
    var row = $(this).closest('tr');
    var editedCells = row.find('td[data-column]');
    var deleteproduct = row.find('.delete-product');

    // Agregar una clase de resaltado a la fila
    row.addClass('bg-indigo-100');

    // Agregar la clase 'editable' y atributo 'contenteditable' a las celdas editables
    editedCells.addClass('editable').attr('contenteditable', 'true');
    row.find('.save-changes, .cancel-edit').removeClass('hidden');
    $(this).addClass('hidden');

    // Ocultar el botón de "Eliminar"
    deleteproduct.addClass('hidden');
  });

  // Al hacer clic en "Anular", cancelar la edición y revertir los cambios
  $('.cancel-edit').click(function(e) {
    e.preventDefault();
    var row = $(this).closest('tr');
    var editedCells = row.find('.editable');

    // Quitar la clase de resaltado de la fila
    row.removeClass('bg-indigo-100');

    // Quitar la clase 'editable' y el atributo 'contenteditable' de las celdas editables
    editedCells.attr('contenteditable', 'false').removeClass('editable');
    row.find('.edit-product').removeClass('hidden');
    row.find('.save-changes').addClass('hidden');
    row.find('.cancel-edit').addClass('hidden');
    row.find('.delete-product').removeClass('hidden');
  });

  // Al hacer clic en "Guardar Cambios" de una fila, deshabilitar la edición y quitar el resaltado
  $('.save-changes').click(function(e) {
    e.preventDefault();
    var row = $(this).closest('tr');
    var editedCells = row.find('.editable');
    var updatedData = {};

    // Obtener el producto_id de la fila actual
    var productoId = row.find('.producto-id').text();

    // Agregar el producto_id a los datos actualizados
    updatedData['producto_id'] = productoId;

    // Obtener los datos editados de la fila
    editedCells.each(function() {
      var columnName = $(this).attr('data-column');
      var newValue = $(this).text();

      // Si la columna es 'precio', convertir el valor a un número decimal
      if (columnName === 'precio') {
        newValue = parseFloat(newValue.replace('$', '').replace(',', ''));
      }

      updatedData[columnName] = newValue;
    });

    // También obtener el producto_id de la fila
    var productoId = row.find('td[data-column="id"]').text();
    updatedData['producto_id'] = productoId;

    // Enviar los datos editados al servidor con Ajax
    $.ajax({
      url: '../sql/update-product.php',
      type: 'POST',
      data: updatedData,
      dataType: 'json',
      success: function(response) {
        if (response.message) {
          Swal.fire({
            title: 'Éxito',
            text: response.message,
            icon: 'success',
            confirmButtonText: 'OK'
          }).then(function() {
            // Una vez que el usuario hace clic en "OK", recargar la página
            location.reload();
          });
        } else if (response.error) {
          Swal.fire('Error', response.error, 'error');
        }
        // Deshabilitar la edición después de guardar y quitar el resaltado
        editedCells.attr('contenteditable', 'false').removeClass('editable highlight');
        row.find('.edit-product').removeClass('hidden');
        row.find('.save-changes').addClass('hidden');
      },
      error: function(error) {
        console.error('Error al guardar cambios: ', error);
        Swal.fire('Error', 'Hubo un error al guardar los cambios', 'error');
      }
    });
  });
</script>