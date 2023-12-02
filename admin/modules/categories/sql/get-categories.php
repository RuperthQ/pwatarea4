<?php
// Conectarse a la base de datos
require_once '../../../../config/conn.php';

try {
    
    // Consulta para obtener las categorías
    $query = "SELECT * FROM categorias";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode($categorias);
} catch (PDOException $e) {
    echo "Error al obtener categorías: " . $e->getMessage();
}
