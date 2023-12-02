<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Login</title>
</head>

<body class="bg-gradient-to-r from-orange-500 to-cyan-600 min-h-screen flex items-center justify-center">
  <div class="login-container bg-white p-8 rounded shadow-md max-w-md w-full">
    <div class="login-banner">
      <!-- Contenido del banner -->
    </div>
    <div class="login-form mt-4">
      <div class="form-container">
        <form class="login" method="POST" action="../login.php">
          <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Bienvenido</h1>
          <div class="form-login">
            <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico:</label>
            <input type="email" id="email" name="email" class="form-input mt-1 p-2 w-full rounded-md focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200" required>

            <label for="password" class="block mt-4 text-sm font-medium text-gray-700">Contraseña:</label>
            <input type="password" id="password" name="password" class="form-input mt-1 p-2 w-full rounded-md focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200" required>

            <button type="submit" class="mt-6 w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200">
              Iniciar sesión
            </button>
          </div>

          <p class="mt-4 text-sm text-gray-600">
            ¿Aún no tienes una cuenta? <a href="register.php" class="text-blue-500 hover:underline">Crear Cuenta</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</body>

</html>