<nav class="bg-white shadow-lg text-black p-4">
  <div class="container mx-auto flex justify-between items-center">
    <h1 class="text-black text-2xl font-semibold"><a href="../index.php">E-commerce</a></h1>
    <button id="mobile-menu-button" class="md:hidden text-black hover:text-gray-300 focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
      </svg>
    </button>
    <?php
    // include 'search.php';
    ?>
    <ul class="hidden md:flex space-x-4 font-semibold items-center">
      <i class="fa-solid fa-house"></i>
      <li><a href="#" class="text-black hover:text-amber-400">Inicio</a></li>
      <li><a href="./auth/views/login.php" class="text-black hover:text-amber-400">Admin</a></li>
    </ul>
  </div>
</nav>