<?php
include '../sql/get-tablets.php';
?>

<!-- Agrega estilos personalizados para el carrusel -->
<style>
  .slick-slide {
    transition: transform 0.3s ease-in-out;
  }

  .slick-prev {
    background: linear-gradient(to right, rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0));
  }

  .slick-next {
    background: linear-gradient(to left, rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0));
  }

  .slick-prev,
  .slick-next {
    color: rgba(0, 0, 0, 0.8);
    font-size: 50px;
    line-height: 1;
    border: none;
    cursor: pointer;
    position: absolute;
    top: 0;
    bottom: 0;
    transform: translateY(0);
    z-index: 1;
    padding: 0 15px;
    width: 5%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.7;
    transition: opacity 0.3s ease-in-out;
  }

  .slick-prev:hover,
  .slick-next:hover {
    opacity: 1;
  }

  .slick-prev {
    left: 0;
    margin-left: -15px;
  }

  .slick-next {
    right: 0;
    margin-right: -15px;
  }

  .slick-dots {
    position: absolute;
    left: 0;
    right: 0;
    height: 25px;
    list-style: none;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
  }

  .slick-dots li {
    margin: 0 5px;
  }

  .slick-dots button {
    border: none;
    background: none;
    font-size: 0;
    cursor: pointer;
    outline: none;
  }

  .slick-dots button::before {
    content: "\2022";
    font-size: 26px;
    color: rgba(0, 0, 0, 0.5);
  }

  .slick-dots button.slick-active::before {
    color: rgba(0, 0, 0, 0.8);
  }
</style>

<!-- Sección de Productos -->
<section class="container mx-auto mt-4 p-4 rounded-lg">
  <h2 class=" text-gray-800 text-3xl font-semibold mb">Tablets</h2>
</section>

<section class="container mx-auto my-8">

  <article id="productos-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 border-gray-100">
    <!-- Productos -->
    <?php foreach ($productos as $producto) { ?>
      <div class="bg-white p-4 shadow-md border-gray-500 rounded-lg hover:shadow-xl cursor-pointer">
        <div class="images-product mb-5 h-64">
          <?php
          foreach ($producto['imagenes'] as $ruta) {
            echo '<img src="' . '/e-commerce/' . '' . $ruta . '" alt="Imagen del producto" class="w-full h-64 rounded-md object-contain" loading="lazy">';
          }
          ?>
        </div>
        <h3 class="text-indigo-500  font-semibold"><?= $producto['nombre'] ?></h3>
        <div id="descripcion" class="h-16 overflow-hidden">
          <span class="font-semilight text-sm line-clamp-3">
            <?= $producto['descripcion'] ?>
          </span>
        </div>
        <section class="flex items-center justify-between mt-2">
          <div>
            <i class="fa-solid fa-box text-gray-600 mr-2"></i>
            <span class="text-gray-600"><strong>Stock :</strong> <?= $producto['stock_actual'] ?></span>
          </div>
          <div>
            <i class="fa-solid fa-dollar-sign text-gray-600 mr-2"></i>
            <span class="text-gray-600 font-bold"><?= number_format($producto['precio'], 2) ?></span>
          </div>
        </section>
        <div class="flex justify-end flex-wrap">
          <!-- Botón de WhatsApp -->
          <a target="_blank" href="https://wa.me/+593123456789?text=<?= urlencode("¡Hola! Estoy interesado en el producto {$producto['nombre']}. Precio: $ {$producto['precio']}. Disponibilidad: {$producto['stock_actual']} en stock.") ?>" class="bg-green-200 text-green-600 border border-green-500 hover:text-white hover:bg-green-600 font-semibold px-4 py-1 mt-2 shadow-lg rounded inline-block">
            <i class="fa-brands fa-whatsapp"></i> Comprar
          </a>
        </div>
      </div>
    <?php } ?>
  </article>

</section>

<!-- Carrusel -->
<script async>
  $(document).ready(function() {
    $('.images-product').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      dots: true,
      prevArrow: false,
      nextArrow: false
    });
  });
</script>