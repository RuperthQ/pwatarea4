<h2 class="text-2xl font-semibold mb-6">Opciones</h2>

<style>
  /* Estilos para las pestañas */
  .tab {
    display: flex;
    margin-bottom: 10px;
  }

  /* Estilos para el contenido de las pestañas */
  .tabcontent {
    display: none;
  }
</style>

<!-- Contenedor de pestañas -->
<div class="tab border-b">
  <button class="tablinks mr-0.5 bg-emerald-500 text-white rounded-t-lg px-2 py-1 hover:bg-emerald-700" onclick="openTab(event, 'Categoria')">Categoria</button>
  <button class="tablinks bg-red-500 text-white rounded-t-lg px-2 py-1 hover:bg-red-700" onclick="openTab(event, 'Eliminar')">Eliminar</button>
</div>

<!-- Contenido de las pestañas -->

<!-- Categoria -->
<div id="Categoria" class="tabcontent mt-6">
  <form action="../sql/add-category.php" class="space-y-4" method="POST" enctype="multipart/form-data">
    <div class="mb-4">
      <label for="nombre" class="block text-gray-600 font-semibold mb-2">Nombre de la Categoría</label>
      <input type="text" name="nombre_categoria" id="nombre_categoria" class="w-full border border-gray-400 text-gray-800 rounded-lg px-3 
      py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-none">
    </div>
    <div class="mb-4">
      <label for="descripcion_categoria" class="block text-gray-600 font-semibold mb-2">Descripción de la Categoría</label>
      <textarea name="descripcion_categoria" id="descripcion_categoria" class="w-full border border-gray-400 text-gray-800 rounded-lg px-3 
      py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-none" style="resize: none;"></textarea>
    </div>
    <div>
      <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">Agregar Categoría</button>
    </div>
  </form>
</div>

<!-- Eliminar -->
<div id="Eliminar" class="tabcontent mt-6">
  <form action="../sql/delete-category.php" class="space-y-4" method="POST">
    <div>
      <label for="categoria_eliminar" class="block font-semibold mb-1">Seleccione una categoría para eliminar</label>
      <select name="categoria_eliminar" id="categoria_eliminar" class="w-full border rounded-lg p-2">
        <?php
        // Obtener categorías desde la base de datos y cargar las opciones
        $queryCategorias = "SELECT id, nombre FROM categorias";
        $stmtCategorias = $pdo->query($queryCategorias);
        while ($row = $stmtCategorias->fetch(PDO::FETCH_ASSOC)) {
          echo '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
        }
        ?>
      </select>
    </div>
    <div>
      <button type="button" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300" onclick="eliminarCategoria()">
        Eliminar
      </button>
    </div>
  </form>
</div>

<script>
  // Función para mostrar el contenido de la pestaña seleccionada
  function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
  }
</script>