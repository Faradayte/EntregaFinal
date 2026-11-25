<?php
require_once 'conexion.php';
$sql = "SELECT id, Nombre, Descripcion, Fotos, Precio, CantAlmacen, Fabricante, Origen FROM Productos ORDER BY id DESC LIMIT 8";
$resultado = mysqli_query($con, $sql);
if (!$resultado) { die("Error al consultar productos: " . mysqli_error($con)); }
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Inicio | eStore</title>
    <meta name="description" content="Catálogo de productos eStore">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
  <div class="header-area"><div class="main-header">
    <div class="header-top top-bg d-none d-lg-block"><div class="container-fluid"><div class="row justify-content-between align-items-center">
      <div class="header-info-left d-flex align-items-center"><div class="flag"><img src="assets/img/icon/header_icon.png" alt=""></div><ul class="contact-now"><li>Bienvenido a eStore</li></ul></div>
      <div class="header-info-right"><ul><li><a href="login.html">Mi cuenta</a></li><li><a href="product_list.php">Productos</a></li><li><a href="cart.html">Carrito</a></li></ul></div>
    </div></div></div>
    <div class="header-bottom header-sticky"><div class="container-fluid"><div class="row align-items-center">
      <div class="col-xl-1 col-lg-1 col-md-1 col-sm-3"><div class="logo"><a href="index.php"><img src="assets/img/logo/logo.png" alt="eStore"></a></div></div>
      <div class="col-xl-6 col-lg-8 col-md-7 col-sm-5"><div class="main-menu f-right d-none d-lg-block"><nav><ul id="navigation">
        <li><a href="index.php">Inicio</a></li><li><a href="Catagori.php">Categorías</a></li>
        <li><a href="product_list.php">Productos</a><ul class="submenu"><li><a href="product_list.php">Catálogo completo</a></li></ul></li>
        <li><a href="about.html">Acerca de</a></li><li><a href="contact.html">Contacto</a></li>
      </ul></nav></div></div>
      <div class="col-xl-5 col-lg-3 col-md-3 col-sm-3 fix-card"><ul class="header-right f-right d-none d-lg-block"><li><div class="shopping-card"><a href="cart.html"><i class="fas fa-shopping-cart"></i></a></div></li><li class="d-none d-lg-block"><a href="login.html" class="btn header-btn">Iniciar sesión</a></li></ul></div>
      <div class="col-12"><div class="mobile_menu d-block d-lg-none"></div></div>
    </div></div></div>
  </div></div>
</header>
<main>
<div class="slider-area"><div class="single-slider slider-height2 d-flex align-items-center" data-background="assets/img/hero/h1_hero.jpg"><div class="container"><div class="row"><div class="col-xl-7"><div class="hero-cap"><h1>Bienvenido a eStore</h1><p>Descubre nuestros productos disponibles.</p><a href="product_list.php" class="btn hero-btn">Ver catálogo</a></div></div></div></div></div></div>
<section class="latest-product-area padding-bottom"><div class="container"><div class="row"><div class="col-lg-12"><div class="section-tittle mb-30"><h2>Productos recientes</h2><p>Productos registrados en nuestra tienda</p></div></div></div><div class="row">
<?php if (mysqli_num_rows($resultado) > 0) { while ($producto = mysqli_fetch_assoc($resultado)) { ?>
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4"><div class="single-product mb-30 h-100"><div class="product-img"><?php if (!empty($producto['Fotos'])) {
        $infoImagen = @getimagesizefromstring($producto['Fotos']);
        if ($infoImagen !== false) {
            $mimeImagen = image_type_to_mime_type($infoImagen[2]);
            echo '<img class="img-fluid" src="data:' . $mimeImagen . ';base64,' . base64_encode($producto['Fotos']) . '" alt="' . htmlspecialchars($producto['Nombre'], ENT_QUOTES, 'UTF-8') . '">';
        } else { echo '<div class="alert alert-secondary">Imagen no disponible</div>'; }
    } else { echo '<div class="alert alert-secondary">Sin fotografía</div>'; } ?></div><div class="product-caption"><h4><a href="single-product.php?id=<?php echo (int)$producto['id']; ?>"><?php echo htmlspecialchars($producto['Nombre']); ?></a></h4><div class="price"><ul><li>$<?php echo number_format((float)$producto['Precio'], 2); ?></li></ul></div><p class="mb-1">Disponibles: <?php echo (int)$producto['CantAlmacen']; ?></p><a class="btn btn-sm btn-outline-primary mt-2" href="single-product.php?id=<?php echo (int)$producto['id']; ?>">Ver detalles</a></div></div></div>
<?php } } else { ?><div class="col-12"><p>No hay productos registrados.</p></div><?php } ?>
</div><div class="row"><div class="col-12 text-center mt-4"><a href="product_list.php" class="btn_3">Ver todos los productos</a></div></div></div></section>
<section class="shop-method-area section-padding30"><div class="container"><div class="row"><div class="col-lg-4"><div class="method-wrapper"><i class="ti-package"></i><h6>Productos disponibles</h6><p>Consulta existencias desde el catálogo.</p></div></div><div class="col-lg-4"><div class="method-wrapper"><i class="ti-search"></i><h6>Búsqueda sencilla</h6><p>Encuentra productos por nombre o descripción.</p></div></div><div class="col-lg-4"><div class="method-wrapper"><i class="ti-shopping-cart"></i><h6>Compra fácil</h6><p>Explora los detalles de cada producto.</p></div></div></div></div></section>
</main>
<footer><div class="footer-area footer-padding"><div class="container"><div class="row">
  <div class="col-lg-4 col-md-6"><div class="single-footer-caption mb-50"><div class="footer-logo"><a href="index.php"><img src="assets/img/logo/logo2_footer.png" alt="eStore"></a></div><div class="footer-tittle"><div class="footer-pera"><p>Explora nuestro catálogo de productos.</p></div></div></div></div>
  <div class="col-lg-4 col-md-6"><div class="single-footer-caption mb-50"><div class="footer-tittle"><h4>Enlaces</h4><ul><li><a href="index.php">Inicio</a></li><li><a href="Catagori.php">Categorías</a></li><li><a href="product_list.php">Productos</a></li></ul></div></div></div>
  <div class="col-lg-4 col-md-6"><div class="single-footer-caption mb-50"><div class="footer-tittle"><h4>Ayuda</h4><ul><li><a href="about.html">Acerca de</a></li><li><a href="contact.html">Contacto</a></li></ul></div></div></div>
</div><div class="row"><div class="col-12"><div class="footer-copy-right text-center"><p>© <?php echo date('Y'); ?> eStore. Todos los derechos reservados.</p></div></div></div></div></div></footer>
<script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>
<script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slicknav.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/animated.headline.js"></script>
<script src="assets/js/jquery.magnific-popup.js"></script>
<script src="assets/js/jquery.nice-select.min.js"></script>
<script src="assets/js/jquery.sticky.js"></script>
<script src="assets/js/jquery.counterup.min.js"></script>
<script src="assets/js/waypoints.min.js"></script>
<script src="assets/js/price_rangs.js"></script>
<script src="assets/js/contact.js"></script>
<script src="assets/js/jquery.form.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
<script src="assets/js/mail-script.js"></script>
<script src="assets/js/main.js"></script>
</body></html>
