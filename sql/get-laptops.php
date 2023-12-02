<?php
// Conectarse a la base de datos
require_once '../config/conn.php';

try {

  // Consulta SQL para obtener los productos con el nombre de la categoría y subcategoría, y el stock actual
  $queryProductos = "SELECT p.*, p.created_at AS registrado,
                            c.nombre AS categoria_nombre,
                            i.stock_actual,i.stock_inicial,
                            im.ruta AS imagen_ruta
                    FROM productos AS p
                    LEFT JOIN categorias AS c ON p.categoria_id = c.id
                    LEFT JOIN inventario_productos AS i ON p.id = i.producto_id
                    LEFT JOIN imagenes AS im ON p.imagenes_id = im.id
                    WHERE c.nombre = 'Laptops'";
  $stmtProductos = $pdo->prepare($queryProductos);
  $stmtProductos->execute();

  $productos = array();
  while ($row = $stmtProductos->fetch(PDO::FETCH_ASSOC)) {
    // Aquí agregamos las imágenes a cada producto.
    $producto_id = $row['id'];
    $queryImagenes = "SELECT ruta FROM imagenes WHERE producto_id = $producto_id";
    $stmtImagenes = $pdo->prepare($queryImagenes);
    $stmtImagenes->execute();
    $imagenes = array();
    while ($imagen = $stmtImagenes->fetch(PDO::FETCH_ASSOC)) {
      $imagenes[] = $imagen['ruta'];
    }
    $row['imagenes'] = $imagenes;

    $productos[] = $row;
  }
} catch (PDOException $e) {
  echo "Error al obtener productos: " . $e->getMessage();
}
