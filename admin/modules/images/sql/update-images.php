<?php
// Conectarse a la base de datos
require_once '../../../../config/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        $productId = $_POST['product_id'];

        // Obtener el nombre de la categoría
        $queryCategoria = "SELECT nombre FROM categorias WHERE id = (SELECT categoria_id FROM productos WHERE id = ?)";
        $stmtCategoria = $pdo->prepare($queryCategoria);
        $stmtCategoria->execute([$productId]);
        $categoria = $stmtCategoria->fetchColumn();

        // Reemplazar espacios en blanco por guiones en el nombre de la categoría
        $categoria = str_replace(' ', '-', $categoria);

        // Obtener el nombre del producto
        $queryNombreProducto = "SELECT nombre FROM productos WHERE id = ?";
        $stmtNombreProducto = $pdo->prepare($queryNombreProducto);
        $stmtNombreProducto->execute([$productId]);
        $nombreProducto = $stmtNombreProducto->fetchColumn();

        // Reemplazar espacios en blanco por guiones en el nombre del producto
        $nombreProducto = str_replace(' ', '-', $nombreProducto);

        // Verifica si se seleccionaron archivos
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            // Procesa cada imagen seleccionada
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $image_name = $_FILES['images']['name'][$key];
                $image_tmp = $_FILES['images']['tmp_name'][$key];

                // Verifica si la imagen es válida (puedes agregar más validaciones según tus necesidades)
                if (!empty($image_name) && getimagesize($image_tmp)) {
                    // Ruta donde se guardarán las imágenes (ajusta según tu estructura de archivos)
                    $upload_dir = '../../../../uploads/products/';

                    // Nombre de la imagen basado en el índice y la extensión
                    $extension = pathinfo($image_name, PATHINFO_EXTENSION);
                    $nombreArchivo = $nombreProducto . '-' . ($key + 1) . '.' . $extension;
                    $rutaRelativa = 'uploads/products/' . $categoria . "/" . $productId . "/" . $nombreArchivo;

                    // Crear la carpeta de la categoría si no existe
                    $categoriaFolder = "../../../../uploads/products/" . $categoria . "/" . $productId;
                    if (!is_dir($categoriaFolder)) {
                        if (!mkdir($categoriaFolder, 0777, true)) {
                            // Manejo de error si no se puede crear la carpeta
                            echo "Error: No se pudo crear la carpeta de la categoría.";
                            exit();
                        }
                    }

                    // Mueve la imagen al directorio de destino
                    move_uploaded_file($image_tmp, "../../../../" . $rutaRelativa);

                    // Inserta la ruta de la imagen en la base de datos
                    $query = "INSERT INTO imagenes (producto_id, ruta) VALUES (?, ?)";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$productId, $rutaRelativa]);
                    $imagenId = $pdo->lastInsertId(); // Obtener el ID de la imagen insertada
                }
            }
        }

        // Actualizar la columna imagenes_id en la tabla productos
        $queryUpdateImagenId = "UPDATE productos SET imagenes_id = ? WHERE id = ?";
        $stmtUpdateImagenId = $pdo->prepare($queryUpdateImagenId);
        $stmtUpdateImagenId->execute([$imagenId, $productId]);

        // Resto del código para redirigir o realizar otras operaciones necesarias
        header("Location: ../views/images.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}