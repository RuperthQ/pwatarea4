<?php
// Conectarse a la base de datos
require_once '../../../../config/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtener el ID de la imagen a eliminar desde la solicitud AJAX
  $imageId = $_POST['image_id'];

  try {

    // Paso 1: Busca todos los productos relacionados
    $queryProductosRelacionados = "SELECT id FROM productos WHERE imagenes_id = :image_id";
    $stmtProductosRelacionados = $pdo->prepare($queryProductosRelacionados);
    $stmtProductosRelacionados->bindParam(':image_id', $imageId);
    $stmtProductosRelacionados->execute();

    // Paso 2: Actualiza los productos relacionados
    $queryActualizarProductos = "UPDATE productos SET imagenes_id = NULL WHERE imagenes_id = :image_id";
    $stmtActualizarProductos = $pdo->prepare($queryActualizarProductos);
    $stmtActualizarProductos->bindParam(':image_id', $imageId);
    $stmtActualizarProductos->execute();

    // Paso 3: Eliminar la imagen
    // Obtener la ruta de la imagen desde la base de datos
    $queryObtenerRutaImagen = "SELECT ruta FROM imagenes WHERE id = :image_id";
    $stmtObtenerRutaImagen = $pdo->prepare($queryObtenerRutaImagen);
    $stmtObtenerRutaImagen->bindParam(':image_id', $imageId);
    $stmtObtenerRutaImagen->execute();
    $row = $stmtObtenerRutaImagen->fetch(PDO::FETCH_ASSOC);

    if ($row) {
      // Ruta de la imagen en el servidor
      $imagePath = "../../../../" . $row['ruta']; // Ajusta la ruta según tu estructura de archivos

      // Eliminar la imagen del servidor
      if (unlink($imagePath)) {
        // Eliminar la entrada de la imagen de la base de datos
        $queryEliminarImagen = "DELETE FROM imagenes WHERE id = :image_id";
        $stmtEliminarImagen = $pdo->prepare($queryEliminarImagen);
        $stmtEliminarImagen->bindParam(':image_id', $imageId);
        $stmtEliminarImagen->execute();

        echo json_encode(["message" => "Imagen eliminada correctamente"]);
        exit;
      }
    }

    // Si algo salió mal, devuelve una respuesta de error
    echo json_encode(["error" => "Error al eliminar la imagen"]);
  } catch (PDOException $e) {
    echo json_encode(["error" => "Error en la conexión a la base de datos: " . $e->getMessage()]);
  }
}
