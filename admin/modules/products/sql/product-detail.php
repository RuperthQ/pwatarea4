<?php
// Conectarse a la base de datos
require_once '../../../../config/conn.php';

// Obtén los parámetros de la URL
$categoriaNombre = isset($_GET['categoria']) ? str_replace('-', ' ', urldecode($_GET['categoria'])) : null;
$productoNombre = isset($_GET['nombre']) ? str_replace('-', ' ', urldecode($_GET['nombre'])) : null;

// Verifica si ambos parámetros están presentes
if ($categoriaNombre !== null && $productoNombre !== null) {

    try {

        // Obtén el ID de la categoría
        $queryCategoriaId = "SELECT id FROM categorias WHERE nombre = ?";
        $stmtCategoriaId = $pdo->prepare($queryCategoriaId);
        $stmtCategoriaId->execute([$categoriaNombre]);
        $categoriaId = $stmtCategoriaId->fetchColumn();

        // Obtén la información del producto, sus dimensiones y el stock
        $queryProducto = "SELECT p.*, d.largo, d.ancho, d.alto, i.stock_actual, im.ruta as imagen_ruta
                    FROM productos AS p 
                    LEFT JOIN dimensiones_productos AS d ON p.id = d.producto_id
                    LEFT JOIN inventario_productos AS i ON p.id = i.producto_id
                    LEFT JOIN imagenes AS im ON im.producto_id = p.id
                    WHERE p.categoria_id = ? AND p.nombre = ?";
        $stmtProducto = $pdo->prepare($queryProducto);
        $stmtProducto->execute([$categoriaId, $productoNombre]);
        $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);

        if ($producto !== false) {
            // Si se encontró el producto, puedes acceder a las dimensiones y el stock
            $largo = $producto['largo'];
            $ancho = $producto['ancho'];
            $alto = $producto['alto'];
            $stockActual = $producto['stock_actual'];

            // Obtén las imágenes del producto
            $producto_id = $producto['id'];
            $queryImagenes = "SELECT ruta FROM imagenes WHERE producto_id = ?";
            $stmtImagenes = $pdo->prepare($queryImagenes);
            $stmtImagenes->execute([$producto_id]);
            $imagenes = array();
            while ($imagen = $stmtImagenes->fetch(PDO::FETCH_ASSOC)) {
                $imagenes[] = $imagen['ruta'];
            }
            $producto['imagenes'] = $imagenes;

            // Resto del código para mostrar los detalles del producto
        } else {
            echo "Producto no encontrado";
            // echo "Categoría: $categoriaNombre, Producto: $productoNombre";
        }
    } catch (PDOException $e) {
        echo "Error en la conexión a la base de datos: " . $e->getMessage();
    }
} else {
    // Maneja el caso en el que los parámetros no están presentes
    echo "URL incorrecta";
}