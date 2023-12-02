<?php
// Conectarse a la base de datos
require_once '../../../../config/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID de la categoría a eliminar
    $categoria_id = $_POST['categoria_eliminar'];

    try {

        // Verificar si la categoría existe antes de eliminarla
        $queryVerificar = "SELECT COUNT(*) FROM categorias WHERE id = ?";
        $stmtVerificar = $pdo->prepare($queryVerificar);
        $stmtVerificar->execute([$categoria_id]);
        $categoriaExiste = $stmtVerificar->fetchColumn();

        if ($categoriaExiste) {
            // Iniciar una transacción para asegurar la integridad de los datos
            $pdo->beginTransaction();

            // Eliminar los productos asociados a la categoría
            $queryEliminarProductos = "DELETE FROM productos WHERE categoria_id = ?";
            $stmtEliminarProductos = $pdo->prepare($queryEliminarProductos);
            $stmtEliminarProductos->execute([$categoria_id]);

            // Eliminar la categoría
            $queryEliminar = "DELETE FROM categorias WHERE id = ?";
            $stmtEliminar = $pdo->prepare($queryEliminar);
            $stmtEliminar->execute([$categoria_id]);

            // Confirmar la transacción
            $pdo->commit();
            
            // header("Location: ../admin/modules/category.php");
            echo json_encode(["message" => "Categoría y productos asociados eliminados correctamente"]);
        } else {
            echo json_encode(["error" => "La categoría no existe"]);
        }
    } catch (PDOException $e) {
        // Revertir la transacción en caso de error
        $pdo->rollback();
        echo json_encode(["error" => "Error al eliminar categoría: " . $e->getMessage()]);
    }
}