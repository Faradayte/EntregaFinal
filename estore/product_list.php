<?php
require_once 'conexion.php';
$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$fabricante = isset($_GET['fabricante']) ? trim($_GET['fabricante']) : '';
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'nombre';
$ordenes = array('nombre' => 'Nombre ASC', 'precio_asc' => 'Precio ASC', 'precio_desc' => 'Precio DESC');
if (!isset($ordenes[$orden])) { $orden = 'nombre'; }

$sql = "SELECT id, Nombre, Descripcion, Fotos, Precio, CantAlmacen, Fabricante, Origen FROM Productos WHERE 1=1";
$tipos = '';
$valores = array();
if ($buscar !== '') { $sql .= " AND (Nombre LIKE ? OR Descripcion LIKE ?)"; $tipos .= 'ss'; $texto = '%' . $buscar . '%'; $valores[] = $texto; $valores[] = $texto; }
if ($fabricante !== '') { $sql .= " AND Fabricante = ?"; $tipos .= 's'; $valores[] = $fabricante; }
$sql .= " ORDER BY " . $ordenes[$orden];
$stmt = mysqli_prepare($con, $sql);
if (!$stmt) { die("Error al preparar consulta: " . mysqli_error($con)); }
if ($tipos !== '') { mysqli_stmt_bind_param($stmt, $tipos, ...$valores); }
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$fabricantes = mysqli_query($con, "SELECT DISTINCT Fabricante FROM Productos WHERE Fabricante <> '' ORDER BY Fabricante");
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Productos | eStore</title>
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
<main><div class="slider-area"><div class="single-slider slider-height2 d-flex align-items-center" data-background="assets/img/hero/category.jpg"><div class="container"><div class="row"><div class="col-xl-12"><div class="hero-cap text-center"><h2>Productos</h2></div></div></div></div></div></div>
<section class="product_list section_padding"><div class="container"><div class="row"><div class="col-md-4"><div class="product_sidebar"><div class="single_sedebar"><h4>Buscar</h4><form action="product_list.php" method="GET"><input class="form-control mb-2" type="text" name="buscar" placeholder="Nombre o descripción" value="<?php echo htmlspecialchars($buscar); ?>"><input type="hidden" name="fabricante" value="<?php echo htmlspecialchars($fabricante); ?>"><input type="hidden" name="orden" value="<?php echo htmlspecialchars($orden); ?>"><button type="submit" class="btn_3">Buscar</button></form></div>
<div class="single_sedebar"><h4>Fabricante</h4><form action="product_list.php" method="GET"><input type="hidden" name="buscar" value="<?php echo htmlspecialchars($buscar); ?>"><input type="hidden" name="orden" value="<?php echo htmlspecialchars($orden); ?>"><select class="form-control" name="fabricante" onchange="this.form.submit()"><option value="">Todos</option><?php if ($fabricantes) { while ($fab = mysqli_fetch_assoc($fabricantes)) { ?><option value="<?php echo htmlspecialchars($fab['Fabricante']); ?>" <?php echo ($fabricante === $fab['Fabricante']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($fab['Fabricante']); ?></option><?php } } ?></select></form></div>
</div></div><div class="col-md-8"><div class="d-flex justify-content-between align-items-center flex-wrap mb-4"><p class="mb-2">Productos encontrados: <?php echo mysqli_num_rows($resultado); ?></p><form method="GET" action="product_list.php" class="form-inline"><input type="hidden" name="buscar" value="<?php echo htmlspecialchars($buscar); ?>"><input type="hidden" name="fabricante" value="<?php echo htmlspecialchars($fabricante); ?>"><label class="mr-2" for="orden">Ordenar:</label><select class="form-control" id="orden" name="orden" onchange="this.form.submit()"><option value="nombre" <?php echo $orden==='nombre'?'selected':''; ?>>Nombre</option><option value="precio_asc" <?php echo $orden==='precio_asc'?'selected':''; ?>>Precio menor a mayor</option><option value="precio_desc" <?php echo $orden==='precio_desc'?'selected':''; ?>>Precio mayor a menor</option></select></form></div><div class="row">
<?php if (mysqli_num_rows($resultado) > 0) { while ($producto = mysqli_fetch_assoc($resultado)) { ?>
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4"><div class="single-product mb-30 h-100"><div class="product-img"><?php if (!empty($producto['Fotos'])) {
        $infoImagen = @getimagesizefromstring($producto['Fotos']);
        if ($infoImagen !== false) {
            $mimeImagen = image_type_to_mime_type($infoImagen[2]);
            echo '<img class="img-fluid" src="data:' . $mimeImagen . ';base64,' . base64_encode($producto['Fotos']) . '" alt="' . htmlspecialchars($producto['Nombre'], ENT_QUOTES, 'UTF-8') . '">';
        } else { echo '<div class="alert alert-secondary">Imagen no disponible</div>'; }
    } else { echo '<div class="alert alert-secondary">Sin fotografía</div>'; } ?></div><div class="product-caption"><h4><a href="single-product.php?id=<?php echo (int)$producto['id']; ?>"><?php echo htmlspecialchars($producto['Nombre']); ?></a></h4><div class="price"><ul><li>$<?php echo number_format((float)$producto['Precio'], 2); ?></li></ul></div><p class="mb-1">Disponibles: <?php echo (int)$producto['CantAlmacen']; ?></p><a class="btn btn-sm btn-outline-primary mt-2" href="single-product.php?id=<?php echo (int)$producto['id']; ?>">Ver detalles</a></div></div></div>
<?php } } else { ?><div class="col-12"><p>No se encontraron productos con esos filtros.</p></div><?php } ?>
</div><a class="btn btn-outline-secondary" href="product_list.php">Quitar filtros</a></div></div></div></section></main>
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

<?php mysqli_stmt_close($stmt); mysqli_close($con); ?>
