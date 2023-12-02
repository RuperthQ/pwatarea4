<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce</title>
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://kit.fontawesome.com/9d60ee0290.css" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/9d60ee0290.js" crossorigin="anonymous"></script>
</head>

<style>
    /* Estilos para la barra de desplazamiento */
    ::-webkit-scrollbar {
        width: 8px;
        /* Ancho de la barra de desplazamiento */
    }

    ::-webkit-scrollbar-track {
        background-color: #f1f1f1;
        /* Color de fondo de la pista de desplazamiento */
    }

    ::-webkit-scrollbar-thumb {
        background-color: #888;
        /* Color del pulgar de desplazamiento */
        border-radius: 4px;
        /* Radio de borde del pulgar de desplazamiento */
    }

    ::-webkit-scrollbar:hover {
        width: 10px;
        /* Ancho de la barra de desplazamiento */
    }

    ::-webkit-scrollbar-thumb:hover {
        background-color: #555;
        /* Cambio de color al pasar el cursor sobre el pulgar */
    }
</style>

<body class="bg-gray-100 font-sans">
    <!-- Sidebar -->
    <nav class="bg-slate-700 text-white w-60 h-screen fixed flex flex-col">
        <div class="border-b p-6">
            <h1 class="text-2xl font-semibold flex justify-between">
                <a href="/e-commerce/index.php" target="_blank">Tienda Online</a>
            </h1>
        </div>

        <ul class="flex-grow text-1xl">
            <!-- Categorias -->
            <a href="/e-commerce/admin/modules/categories/views/category.php">
                <li class="px-6 py-3 cursor-pointer transition duration-200 ease-out hover:bg-gradient-to-l hover:from-cyan-500 hover:shadow-xl hover:ease-in"><i class="fa-solid fa-tags fa-flip-horizontal mr-4"></i>Categorias</li>
            </a>
            <!-- Productos -->
            <a href="/e-commerce/admin/modules/products/views/products.php">
                <li class="px-6 py-3 cursor-pointer transition duration-200 ease-out hover:bg-gradient-to-l hover:from-cyan-500 hover:shadow-xl hover:ease-in"><i class="fa-solid fa-box-open mr-4"></i>Productos</li>
            </a>
            <!-- Imagenes -->
            <a href="/e-commerce/admin/modules/images/views/images.php">
                <li class="px-6 py-3 cursor-pointer transition duration-200 ease-out hover:bg-gradient-to-l hover:from-cyan-500 hover:shadow-xl hover:ease-in"><i class="fa-solid fa-tags fa-flip-horizontal mr-4"></i>Imagenes</li>
            </a>
        </ul>
    </nav>