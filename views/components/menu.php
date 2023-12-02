<?php
// Conectarse a la base de datos
require_once '../config/conn.php';

try {

  // Consulta para obtener las categorías
  $query = "SELECT nombre FROM categorias";
  $stmt = $pdo->prepare($query);
  $stmt->execute();

  $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // echo json_encode($categorias);
} catch (PDOException $e) {
  echo "Error al obtener categorías: " . $e->getMessage();
}
?>

<nav class="bg-gray-800 text-white p-3 hidden md:flex rounded-b-lg">
  <div class="container mx-auto w-11/12 flex justify-center items-center">
    <ul class="hidden md:flex space-x-10" style="white-space: nowrap;">
      <?php foreach ($categorias as $categoria) { ?>
        <li><a href="<?= '' . '/e-commerce/views/' . $categoria['nombre'] . '.php' ?>" class="text-white hover:text-amber-400"><?= $categoria['nombre'] ?></a></li>
      <?php } ?>
    </ul>
  </div>
</nav>