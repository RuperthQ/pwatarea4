<?php
// Conectarse a la base de datos
require_once '../../../../config/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        if (isset($_POST['nombre_categoria'])) {
            // Procesar el formulario de categoría
            $nombre = $_POST['nombre_categoria'];
            $descripcion = $_POST['descripcion_categoria'];
            
            $query = "INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$nombre, $descripcion]);
            
            // Redirigir o devolver una respuesta según sea necesario
            header("Location: /e-commerce/admin/modules/categories/views/category.php");
        }
    } catch (PDOException $e) {
        echo "Error al agregar categoría: " . $e->getMessage();
    }
}
