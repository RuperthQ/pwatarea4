<head>
  <title>Categorias</title>
</head>

<?php
include '../../../dashboard.php';
require_once '../sql/get-categories.php';
?>

<main class="ml-0 md:ml-56 pt-4 px-8 flex">
  <!-- Sección de Agregar y Eliminar Categorías -->

  <section class="bg-white mt-6 mx-6 p-6 rounded-lg shadow-xl md:w-2/6">

    <!-- Agregar Categoria -->
    <?php
    include '../components/add-category.php'
    ?>
    <!-- Eliminar Categoria -->
    <?php
    include '../components/delete-category.php'
    ?>

  </section>

  <table class="w-full mt-6 text-sm border-gray-400 bg-white shadow-xl rounded-lg mb-4">
    <thead>
      <tr class="rounded-lg border-b light:border-white/40 text-slate-600">
        <th class="py-3 px-2">#</th>
        <th class="py-3 px-2">Nombre</th>
        <th class="py-3 px-2">Descripción</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $contadorFilas = 1;
      foreach ($categorias as $categoria) { ?>
        <tr class="border-b light:border-white/40 text-slate-500">
          <td class="px-4 py-2 w-5 text-slate-400"><?= $contadorFilas ?></td>
          <?php
          $contadorFilas++;
          ?>
          <td class="px-2 py-2 w-56" data-column="nombre"><?= $categoria['nombre'] ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

</main>