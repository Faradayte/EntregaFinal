
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar producto</title>
</head>

<body>

<?php

if (isset($_POST["registrar"])) {

    $con = mysqli_connect("db", "root", "root_password", "Proyectofinal");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $nombre = mysqli_real_escape_string($con, $_POST["Nombre"]);
    $descripcion = mysqli_real_escape_string($con, $_POST["Descripcion"]);
    $precio = mysqli_real_escape_string($con, $_POST["Precio"]);
    $cantidad = mysqli_real_escape_string($con, $_POST["CantAlmacen"]);
    $fabricante = mysqli_real_escape_string($con, $_POST["Fabricante"]);
    $origen = mysqli_real_escape_string($con, $_POST["Origen"]);
    $foto = mysqli_real_escape_string($con, file_get_contents($_FILES["Fotos"]["tmp_name"]));
    $sql = "INSERT INTO Productos (Nombre, Descripcion, Fotos, Precio, CantAlmacen, Fabricante, Origen)
    VALUES ('$nombre', '$descripcion', '$foto', '$precio', '$cantidad', '$fabricante', '$origen');";

    if (!mysqli_query($con, $sql)) {
        die('Error: ' . mysqli_error($con));
    } else {
        echo "<p>El producto se ha registrado correctamente.</p>";
    }
    mysqli_close($con);
}
?>
<h1>Agregar producto</h1>
<form action="agregar_producto.php" method="post" enctype="multipart/form-data">
    <label for="Nombre">Nombre:</label>
    <input type="text" name="Nombre" id="Nombre" required>
    <br><br>
    <label for="Descripcion">Descripción:</label>
    <textarea name="Descripcion" id="Descripcion" required></textarea>
    <br><br>
    <label for="Fotos">Fotografía:</label>
    <input type="file" name="Fotos" id="Fotos" accept="image/*" required>
    <br><br>
    <label for="Precio">Precio:</label>
    <input type="number" name="Precio" id="Precio" step="0.01" required>
    <br><br>
    <label for="CantAlmacen">Cantidad en almacén:</label>
    <input type="number" name="CantAlmacen" id="CantAlmacen" required>
    <br><br>
    <label for="Fabricante">Fabricante:</label>
    <input type="text" name="Fabricante" id="Fabricante" required>
    <br><br>
    <label for="Origen">Origen:</label>
    <input type="text" name="Origen" id="Origen" required>
    <br><br>
    <input type="submit" name="registrar" value="Registrar producto">
</form>
</body>
</html>
