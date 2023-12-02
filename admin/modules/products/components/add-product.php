<?php
// include '../../../../ajax/get-products.php';
?>

<div class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-black opacity-80 fixed inset-0" id="modalOverlayAP"></div> <!-- Fondo oscurecido -->
    <div class="bg-white pt-8 pr-8 pl-8 rounded-lg shadow-md z-10 relative" style="width: 60%;">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" id="closeModalButtonAP">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <h2 class="text-xl font-semibold mb-8 text-blue-500">Agregar Producto</h2>
        <form action="../sql/add-product.php" method="POST" enctype="multipart/form-data" class="grid grid-rows-3 grid-flow-col gap-4">
            <!-- Columna 1 -->
            <div class="col-span-1 row-span-1 w-52">
                <label class="block mb-2 text-gray-700">Nombre del Producto:</label>
                <input type="text" name="nombre" class="border w-full border-blue-500 rounded-xl p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            </div>

            <div class="col-span-1 row-span-2">
                <label class="block mb-2 text-gray-700">Descripción:</label>
                <textarea name="descripcion" class="border w-full h-32 border-blue-500 rounded-xl p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" style="resize: none;" required></textarea>
            </div>

            <!-- Columna 2 -->

            <div class="col-span-2">
                <input name="user_id" type="hidden" value="<?= isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '' ?>">
                <label for="categoria_id" class="block mb-2 text-gray-700">Categoria:</label>
                <select name="categoria_id" id="categoria_id" class="border w-full border-blue-500 rounded-xl p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required onchange="updateCategoriaPadreID(this)">
                    <!-- Aquí se cargarán las categorías principales dinámicamente -->
                    <?php
                    // Conectarse a la base de datos usando PDO
                    try {
                        $pdo = new PDO("mysql:host=localhost;dbname=ecommerce", "root", "");
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (PDOException $e) {
                        die("Error al conectar a la base de datos: " . $e->getMessage());
                    }
                    // Obtener categorías principales desde la base de datos y cargar las opciones
                    $queryUsuarios = "SELECT id, nombre FROM categorias";
                    $stmtUsuarios = $pdo->query($queryUsuarios);
                    while ($row = $stmtUsuarios->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="col-span-2">
                <label class="block mb-2 text-gray-700">Precio:</label>
                <div class="relative">
                    <span class="bg-gray-200 border border-blue-500 rounded-tl-xl rounded-bl-xl p-2 text-gray-700 absolute top-0 left-0">$</span>
                    <input type="text" name="precio" class="border border-blue-500 p-2 px-8 w-full rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    <span class="bg-gray-200 border border-blue-500 rounded-tl-none rounded-bl-none rounded-tr-xl rounded-br-xl p-2 text-gray-700 absolute top-0 right-0 cursor-pointer hover:bg-blue-500 hover:text-white transition duration-300 ease-in-out">.00</span>
                </div>
            </div>

            <div class="col-span-2">
                <label class="block text-gray-700">Stock Inicial:</label>
                <div class="relative">
                    <span class="bg-gray-200 border border-blue-500 rounded-tl-xl rounded-bl-xl py-2 px-4 text-gray-700 absolute top-0 left-0 cursor-pointer hover:bg-blue-500 hover:text-white transition duration-300 ease-in-out">#</span>
                    <input type="text" name="stock_inicial" class="border border-blue-500 rounded-xl p-2 px-12 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
            </div>

            <!-- Columna 3 -->

            <div class="col-span-3 row-span-1 w-48">
                <label class="block mb-2 text-gray-700">Imágenes:</label>
                <label for="imagenes" class="cursor-pointer bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 ease-in-out">
                    Seleccionar Imágenes
                </label>
                <input type="file" name="imagenes[]" id="imagenes" class="hidden" accept="image/*" multiple required>
            </div>

            <div class="col-span-3 row-span-2 w-80">
                <div class="grid grid-cols-4 gap-4" id="miniaturas"></div>
            </div>

            <!-- Botón de envío -->
            <div class="col-span-4 row-span-3 flex justify-end items-end mb-4">
                <div>
                    <button type="submit" class="bg-blue-500 text-white rounded-xl px-4 py-2 hover:bg-blue-700">Agregar Producto</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const modalAP = document.querySelector('.fixed.inset-0');
    const modalOverlayAP = document.getElementById('modalOverlayAP');
    const closeModalButtonAP = document.getElementById('closeModalButtonAP');
    const openModalAP = document.getElementById('openModalAP');

    openModalAP.addEventListener('click', () => {
        modalAP.classList.remove('hidden');
    });

    const closeModal = () => {
        modalAP.classList.add('hidden');
    };

    closeModalButtonAP.addEventListener('click', closeModal);
    modalOverlayAP.addEventListener('click', closeModal);

    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' || event.key === 'Esc') {
            closeModal();
        }
    });
</script>

<script>
    document.getElementById("imagenes").addEventListener("change", function(e) {
        const miniaturas = document.getElementById("miniaturas");
        miniaturas.innerHTML = "";

        const files = e.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.classList.add("w-20", "h-16", "mx-2", "mb-2");
                    miniaturas.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }
    });
</script>

<script>
    // Función para actualizar el campo oculto con el ID de la categoría principal seleccionada
    function updateCategoriaPadreID(selectElement) {
        var categoriaPadreID = selectElement.value;
        document.getElementById("categoriaPadreID").value = categoriaPadreID;
    }
</script>