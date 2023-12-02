<head>
  <title>Imagenes</title>
</head>

<?php
include '../../../dashboard.php';
include '../../products/sql/get-products.php';
?>

<!-- Sección de  de Productos -->
<main class=" ml-56 pt-4 p-8">
  <section class="p-6 rounded-lg">
    <div class="flex justify-between items-center mb-4">
      <input type="text" id="search" class="p-2 w-60 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-none" placeholder="Buscar">
    </div>
    <table class="w-full text-sm border-gray-400 bg-white shadow-xl rounded-lg mb-4">
      <thead>
        <tr class="rounded-lg text-slate-600">
          <th class="border-b light:border-white/40 py-3 px-2">#</th>
          <th class="border-b light:border-white/40 py-3 px-2">Nombre</th>
          <th class="border-b light:border-white/40 py-3 px-2">Descripción</th>
          <th class="border-b light:border-white/40 py-3 px-2">Imagenes</th>
          <th class="border-b light:border-white/40 py-3 px-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $contadorFilas = 1;
        foreach ($productos as $producto) { ?>
          <tr class="border-b light:border-white/40 text-slate-500">
            <td data-column="id" style="display: none;"><?= $producto['id'] ?></td>
            <td class="px-4 py-2 w-5 text-slate-400"><?= $contadorFilas ?></td>
            <?php
            $contadorFilas++;
            ?>
            <td class="px-2 py-2 w-60" data-column="nombre"><?= $producto['nombre'] ?></td>
            <td class="px-2 py-2 w-60" data-column="categoria"><?= $producto['categoria_nombre'] ?></td>
            <td class="px-2 py-2 inline-flex" data-column="imagenes">
              <?php
              // Obtener las rutas de las imágenes para este producto desde la tabla 'imagenes'
              $queryImagenes = "SELECT id, ruta FROM imagenes WHERE producto_id = ?";
              $stmtImagenes = $pdo->prepare($queryImagenes);
              $stmtImagenes->execute([$producto['id']]);

              // Mostrar las imágenes y botones de eliminar
              while ($row = $stmtImagenes->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="relative">';
                echo '<img src="' . "/e-commerce" . '/' . $row['ruta'] . '" alt="Imagen del producto" class="w-20 h-auto rounded-md object-cover mx-2">';
                echo '<button class="absolute top-0 right-1 px-2 py-1 text-red-600 hover:text-red-700 delete-image" data-image-id="' . $row['id'] . '">';
                echo '<i class="fa-solid fa-trash"></i>';
                echo '</button>';
                echo '</div>';
              }
              ?>
            </td>
            <td class="border-b light:border-white/40 text-slate-400 py-2 text-center" data-column="acciones">
              <button class="px-2 text-green-600 hover:text-green-800 add-image" data-product-id="<?= $producto['id'] ?>">
                <i class="fa-solid fa-plus"></i> Agregar
              </button>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </section>

  <!-- Modal para agregar imágenes -->
  <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none hidden" id="addImageModal">
    <div class="border rounded-lg shadow-md ring-2 ring-blue-700 relative w-auto my-6 mx-auto max-w-3xl">
      <!-- Contenido del modal -->
      <div class="relative flex flex-col bg-white border-0 rounded-lg shadow-lg outline-none focus:outline-none">
        <!-- Cabecera del modal -->
        <div class="flex items-start justify-between p-5 border-b border-solid rounded-t border-blue-500">
          <h3 class="text-2xl font-semibold text-blue-800">
            Agregar Imagen a Producto
          </h3>
          <button class="p-2 ml-auto bg-transparent border-0 text-blue-800 rounded-full hover:bg-blue-100 focus:outline-none" data-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        <!-- Cuerpo del modal -->
        <div class="p-6">
          <form enctype="multipart/form-data" method="POST" action="../sql/update-images.php">
            <input type="hidden" name="product_id" id="product_id">
            <div class="mb-6">
              <label for="images" class="block text-gray-600 text-sm font-medium mb-2">Seleccionar Imágenes:</label>
              <input type="file" name="images[]" id="images" class="border rounded-lg py-2 px-4 text-gray-800 leading-tight focus:outline-none focus:shadow-outline" accept="image/*" multiple required>
            </div>
            <div class="flex items-center justify-end">
              <button type="submit" class="bg-blue-500 text-white active:bg-blue-600 text-sm font-semibold px-6 py-2 rounded-full shadow hover:shadow-md hover:bg-blue-600 focus:outline-none">Cargar Imágenes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="fixed inset-0 z-40 bg-black opacity-25"></div> -->

  <!-- Agregar -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Abre el modal al hacer clic en el botón "Agregar"
      document.querySelectorAll('.add-image').forEach(function(element) {
        element.addEventListener('click', function() {
          var productId = this.getAttribute('data-product-id');
          document.querySelector('#product_id').value = productId;
          document.querySelector('#addImageModal').classList.remove('hidden');
        });
      });

      // Cierra el modal al hacer clic en la "X" o fuera del modal
      document.querySelectorAll('.close-modal, .bg-black').forEach(function(element) {
        element.addEventListener('click', function() {
          document.querySelector('#addImageModal').classList.add('hidden');
        });
      });

      // Cierra el modal si se presiona la tecla ESC
      window.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
          document.querySelector('#addImageModal').classList.add('hidden');
        }
      });
    });
  </script>

  <!-- Eliminar -->
  <script>
    document.querySelectorAll('.delete-image').forEach(function(element) {
      element.addEventListener('click', function() {
        var imageId = this.getAttribute('data-image-id');
        Swal.fire({
          title: '¿Estás seguro?',
          text: 'No podrás deshacer esta acción.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            // Realiza la solicitud AJAX para eliminar la imagen
            fetch('../sql/delete-images.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'image_id=' + encodeURIComponent(imageId)
              })
              .then(response => response.json())
              .then(data => {
                if (data.message) {
                  Swal.fire('Eliminado', 'La imagen ha sido eliminada con éxito.', 'success');
                  // Actualiza la vista para reflejar los cambios
                  location.reload(); // Esto recargará la página
                } else {
                  Swal.fire('Error', 'No se pudo eliminar la imagen.', 'error');
                }
              })
              .catch(error => {
                console.error('Error al eliminar la imagen:', error);
                Swal.fire('Error', 'No se pudo eliminar la imagen.', 'error');
              });
          }
        });
      });
    });
  </script>
</main>