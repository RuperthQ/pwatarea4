<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Registro</title>
</head>

<body class="bg-gradient-to-r from-cyan-500 to-orange-600 min-h-screen flex items-center justify-center">
  <div class="login-container bg-white p-8 rounded shadow-md max-w-md w-full">
    <div class="login-banner">
      <!-- Contenido del banner -->
    </div>
    <div class="login-form mt-4">
      <div class="form-container">
        <form class="registro" method="POST" action="../register.php">
          <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Formulario de Registro</h1>
          <div class="form-registro">
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre de usuario:</label>
            <input type="text" id="username" name="username" class="form-input mt-1 p-2 w-full rounded-md focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200" required>

            <label for="email" class="block mt-4 text-sm font-medium text-gray-700">Correo electrónico:</label>
            <input type="email" id="email" name="email" class="form-input mt-1 p-2 w-full rounded-md focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200" required>

            <label for="password" class="block mt-4 text-sm font-medium text-gray-700">Contraseña:</label>
            <input type="password" id="password" name="password" class="form-input mt-1 p-2 w-full rounded-md focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200" required>

            <label for="password-confirm" class="block mt-4 text-sm font-medium text-gray-700">Confirmar
              contraseña:</label>
            <input type="password" id="password-confirm" name="password-confirm" class="form-input mt-1 p-2 w-full rounded-md focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200" required>

            <label for="role_id" class="block mt-4 text-sm font-medium text-gray-700">Rol:</label>
            <select id="role_id" name="role_id" class="form-select mt-1 p-2 w-full rounded-md focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200">
              <option value="1">Administrador</option>
              <option value="2">Librarian</option>
              <option value="3">Reader</option>
            </select>

            <button type="submit" class="mt-6 w-full bg-gradient-to-r from-green-500 to-teal-600 text-white p-2 rounded-md hover:bg-teal-700 focus:outline-none focus:border-teal-700 focus:ring focus:ring-teal-200">
              Registrarse
            </button>
          </div>
        </form>
        <?php
        // Muestra mensajes de error o éxito si existen
        if (isset($_SESSION['error'])) {
          echo "<p class='mt-4 text-sm text-red-600'>" . $_SESSION['error'] . "</p>";
          unset($_SESSION['error']);
        } elseif (isset($_SESSION['success'])) {
          echo "<p class='mt-4 text-sm text-green-600'>" . $_SESSION['success'] . "</p>";
          unset($_SESSION['success']);
        }
        ?>
      </div>
    </div>
  </div>
</body>

</html>