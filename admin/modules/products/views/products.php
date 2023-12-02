<head>
  <title>Productos</title>
</head>

<?php
include '../../../dashboard.php';
include '../sql/get-products.php';
?>

<style>
  .sortable-header {
    cursor: pointer;
    position: relative;
  }

  .sortable-header::after {
    content: "";
    display: inline-block;
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    position: absolute;
    right: 5px;
    top: 50%;
    transition: transform 0.2s ease-in-out;
  }

  .sortable-header.sort-asc::after {
    border-bottom: 5px solid #333;
    /* Cambia el color según tu estilo */
    transform: translateY(-50%) rotate(180deg);
  }

  .sortable-header.sort-desc::after {
    border-top: 5px solid #333;
    /* Cambia el color según tu estilo */
    transform: translateY(-50%);
  }
</style>

<!-- Sección de Lista de Productos -->
<main class=" ml-56 pt-4 px-8">
  <section class="p-6 rounded-lg">
    <div class="flex justify-between items-center mb-4">
      <input type="text" id="search" class="p-2 w-60 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-none" placeholder="Buscar">
      <div>
        <button id="openModalAP" class="shadow-lg hover:shadow-xl bg-gradient-to-r from-cyan-400 to-blue-400 text-white px-4 py-2 rounded-md hover:from-cyan-500 hover:to-blue-500">Agregar</button>
      </div>
    </div>
    <table class="w-full text-sm border-gray-400 bg-white shadow-xl rounded-lg mb-4">
      <thead>
        <tr class="rounded-lg border-b light:border-white/40 text-slate-600">
          <th class="py-3 px-2">#</th>
          <th class="py-3 px-2">Nombre</th>
          <th class="py-3 px-2">Descripción</th>
          <th class="py-3 px-2">Categoría</th>
          <th class="py-3 px-2 sortable-header">Precio</th>
          <th class="py-3 px-2">Registrado</th>
          <th class="py-3 px-2">Acciones</th>
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
            <td class="px-2 py-2 w-52" data-column="nombre"><?= $producto['nombre'] ?></td>
            <td class="px-2 py-2 " data-column="descripcion"><?= $producto['descripcion'] ?></td>
            <td class="px-2 py-2 w-36"><?= $producto['categoria_nombre'] ?></td>
            <td class="px-2 py-2 w-24 text-green-600 font-semibold" data-column="precio">
              <span class="text-green-600">$</span>
              <?= number_format($producto['precio'], 2) ?>
            </td>
            <td class="px-2 py-2 w-56"><?= $producto['registrado'] ?></td>
            <td class="px-2 py-2 w-24 text-center">
              <button class="text-blue-600 hover:text-blue-800 edit-product" data-product-id="<?= $producto['id'] ?>">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>
              <button class="text-green-600 hover:text-green-800 save-changes hidden" data-product-id="<?= $producto['id'] ?>">
                <i class="fa-solid fa-floppy-disk"></i> Guardar
              </button>
              <button class="text-red-600 hover:text-red-800 delete-product px-2" data-product-id="<?= $producto['id'] ?>">
                <i class="fa-solid fa-trash"></i>
              </button>
              <button class="text-gray-600 hover:text-gray-900 cancel-edit px-2 hidden">
                <i class="fa-solid fa-ban"></i>
              </button>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </section>

  <!-- Buscar -->
  <script>
    $(document).ready(function() {
      // Cuando se ingresa texto en el campo de búsqueda
      $('#search').on('keyup', function() {
        var searchText = $(this).val().toLowerCase(); // Obtener el texto de búsqueda en minúsculas

        // Iterar a través de las filas de la tabla
        $('tbody tr').each(function() {
          var found = false;

          // Iterar a través de las celdas de la fila (excepto la primera celda oculta)
          $(this).find('td:not(:first-child)').each(function() {
            var cellText = $(this).text().toLowerCase(); // Obtener el texto de la celda en minúsculas

            // Verificar si el texto de la celda contiene el texto de búsqueda
            if (cellText.includes(searchText)) {
              found = true;
              return false; // Salir del bucle de celdas
            }
          });

          // Mostrar u ocultar la fila según si se encontró una coincidencia
          if (found) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      });
    });
  </script>

  <?php
  require '../components/update-product.php';
  require '../components/add-product.php';
  ?>
</main>