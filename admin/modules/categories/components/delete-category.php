

<script>
  // En algún evento o función
  function eliminarCategoria() {
    var categoriaEliminar = document.getElementById('categoria_eliminar').value;

    // Mostrar una alerta de confirmación con SweetAlert2
    Swal.fire({
      title: '¿Estás seguro?',
      text: 'Esta acción eliminará la categoría y sus productos asociados.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Si se confirma, realizar la llamada AJAX
        fetch('../sql/delete-category.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'categoria_eliminar=' + encodeURIComponent(categoriaEliminar),
          })
          .then(response => response.json())
          .then(data => {
            if (data.message) {
              // Mostrar una alerta de éxito con SweetAlert2
              Swal.fire('Eliminado', data.message, 'success');
              location.reload();
              // Aquí podrías recargar la página o actualizar la interfaz según lo necesites
            } else if (data.error) {
              // Mostrar una alerta de error con SweetAlert2
              Swal.fire('Error', data.error, 'error');
            }
          })
          .catch(error => {
            console.error('Error:', error);
          });
      }
    });
  }
</script>