<?php
// Conectarse a la base de datos
require_once '../../../../config/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados desde la tabla
    $productoId = $_POST['producto_id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    // $categoriaId = $_POST['categoria_id']; // Cambiar a la columna correcta

    $destacado = $_POST['destacado'];

    try {

        // Actualizar el producto en la base de datos
        $query = "UPDATE productos SET
                    nombre = :nombre,
                    descripcion = :descripcion,
                    precio = :precio,
                    destacado = :destacado
                    -- categoria_id = :categoria_id
                WHERE id = :producto_id";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':destacado', $destacado);
        // $stmt->bindParam(':categoria_id', $categoriaId); // Cambiar a la columna correcta
        $stmt->bindParam(':producto_id', $productoId);

        // Actualizar o insertar las dimensiones del producto en la base de datos
        $queryVerificarDimensiones = "SELECT COUNT(*) FROM dimensiones_productos WHERE producto_id = :producto_id";
        $stmtVerificarDimensiones = $pdo->prepare($queryVerificarDimensiones);
        $stmtVerificarDimensiones->bindParam(':producto_id', $productoId);
        $stmtVerificarDimensiones->execute();

        if ($stmtVerificarDimensiones->fetchColumn() > 0) {
            // Si existen dimensiones para este producto, actualizar
            $queryActualizarDimensiones = "UPDATE dimensiones_productos SET
                                            largo = :largo,
                                            ancho = :ancho,
                                            alto = :alto
                                            WHERE producto_id = :producto_id";
        } else {
            // Si no existen dimensiones para este producto, insertar
            $queryActualizarDimensiones = "INSERT INTO dimensiones_productos (producto_id, largo, ancho, alto) 
                                            VALUES (:producto_id, :largo, :ancho, :alto)";
        }

        $stmtActualizarDimensiones = $pdo->prepare($queryActualizarDimensiones);
        $stmtActualizarDimensiones->bindParam(':largo', $largo);
        $stmtActualizarDimensiones->bindParam(':ancho', $ancho);
        $stmtActualizarDimensiones->bindParam(':alto', $alto);
        $stmtActualizarDimensiones->bindParam(':producto_id', $productoId);
        $stmtActualizarDimensiones->execute();

        if ($stmt->execute()) {
            echo json_encode(["message" => "Producto actualizado correctamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar el producto"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error en la conexión a la base de datos: " . $e->getMessage()]);
    }
}