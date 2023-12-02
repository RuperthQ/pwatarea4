<?php
// Conectarse a la base de datos
require_once '../../../../config/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $categoria_id = $_POST['categoria_id'];
        $stock_inicial = $_POST['stock_inicial'];
        $stock_actual = $_POST['stock_inicial']; // Por defecto, el stock actual es igual al stock inicial

        // Obtener el nombre de la categoría
        $queryCategoria = "SELECT nombre FROM categorias WHERE id = ?";
        $stmtCategoria = $pdo->prepare($queryCategoria);
        $stmtCategoria->execute([$categoria_id]);
        $categoria = $stmtCategoria->fetchColumn();

        // Reemplazar espacios en blanco por guiones en el nombre de la categoría
        $categoria = str_replace(' ', '-', $categoria);

        $imagenes = $_FILES['imagenes'];

        $rutasImagenes = []; // Un arreglo para almacenar las rutas relativas de las imágenes

        // Consulta SQL para insertar en la base de datos (sin el ID del producto)
        $query = "INSERT INTO productos (nombre, descripcion, precio, categoria_id, imagenes_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nombre, $descripcion, $precio, $categoria_id, null]);

        // Obtener el ID del producto insertado
        $productoId = $pdo->lastInsertId();

        // Crear la carpeta de la categoría si no existe
        $categoriaFolder = "../../../../uploads/products/" . $categoria . "/" . $productoId;
        if (!is_dir($categoriaFolder)) {
            mkdir($categoriaFolder);
        }

        // Generar una URL amigable basada en el nombre del producto
        $nombreSinEspacios = str_replace(' ', '-', $nombre);

        // Iterar a través de las imágenes y guardarlas
        foreach ($imagenes['name'] as $key => $nombreImagen) {
            $extension = pathinfo($nombreImagen, PATHINFO_EXTENSION);
            $nombreArchivo = $nombreSinEspacios . '-' . ($key + 1) . '.' . $extension;
            $rutaRelativa = 'uploads/products/' . $categoria . "/" . $productoId . "/" . $nombreArchivo; // Ruta relativa desde la carpeta raíz

            // No necesitas incluir la ruta completa, solo la ruta relativa
            move_uploaded_file($imagenes['tmp_name'][$key], "../../../../" . $rutaRelativa);

            $rutasImagenes[] = $rutaRelativa; // Agregar la ruta relativa de la imagen al arreglo
        }

        // Convertir el arreglo de rutas relativas en una cadena para almacenar en la base de datos
        $imagenesStr = implode(',', $rutasImagenes);

        // Insertar las imágenes en la tabla de imágenes
        foreach ($rutasImagenes as $rutaImagen) {
            $queryInsertImagen = "INSERT INTO imagenes (producto_id, ruta, descripción) VALUES (?, ?, ?)";
            $stmtInsertImagen = $pdo->prepare($queryInsertImagen);
            $stmtInsertImagen->execute([$productoId, $rutaImagen, $descripcion]);
            $imagenId = $pdo->lastInsertId(); // Obtener el ID de la imagen insertada
        }

        // Actualizar la columna imagenes_id en la tabla productos
        $queryUpdateImagenId = "UPDATE productos SET imagenes_id = ? WHERE id = ?";
        $stmtUpdateImagenId = $pdo->prepare($queryUpdateImagenId);
        $stmtUpdateImagenId->execute([$imagenId, $productoId]);

        // Insertar en la tabla de inventario_productos
        $queryInventario = "INSERT INTO inventario_productos (producto_id, stock_inicial, stock_actual) VALUES (?, ?, ?)";
        $stmtInventario = $pdo->prepare($queryInventario);
        $stmtInventario->execute([$productoId, $stock_inicial, $stock_actual]);

        // Resto del código para redirigir o realizar otras operaciones necesarias
        header("Location: ../views/products.php");
    } catch (PDOException $e) {
        echo "Error al agregar producto: " . $e->getMessage();
    }
}