<?php
include_once "../header/header_panel.php";
$dolar = datos_clientes::cambio_dolar($mysqli);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
    <div class="container white rounded z-depth-2" style="border-radius: 6px;">
        <div style="padding: 1em">
            <h5 class="alert alert-success">Stock de Producto</h5>
            <hr>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <section class="row">
                    <div class="control-pares col-md-4">
                        <input type="text" name="textproducto" class="form-control" placeholder="Buscar ....." required>
                    </div>
                    <div class="control-pares col-md-4">
                        <input type="submit" value="Buscar producto" class="btn white-text blue-grey btn-primary"/>
                    </div>
                </section>
            </form>
            <hr>
        </div>
    </div>
    <hr>
    <div class=" z-depth-1 rounded white center-block" style="width: 90%">
        <table class="table table-bordered" style="padding: 1em;">
            <thead>
            <tr style="border-bottom: 1px solid black">
                <th scope="col">#Codigo</th>
                <th scope="col">Producto</th>
                <th scope="col">Marca</th>
                <th scope="col">Cantidad Importacion</th>
                <th scope="col">Cantidad Ventas</th>
                <th scope="col">Cantidad Total</th>
                <th scope="col">Dar Baja</th>
                <th scope="col">Informe de salida</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($_POST["textproducto"])) {
                $producto = $_POST["textproducto"];
                $result4 = $mysqli->query("SELECT * FROM `inventario_producto` WHERE `nombre_producto` LIKE '%$producto%' OR `codigo_producto` LIKE '%$producto%'OR `marca` LIKE '%$producto%' ORDER by codigo_producto ASC");
            } else {
                $result4 = $mysqli->query("SELECT * FROM `inventario_producto`");
            }
            while ($resultado = $result4->fetch_assoc()) {
                $resultadosuma=datos_clientes::suma_stock_materiales($resultado['codigo_producto'], $mysqli);
                if ($resultadosuma==null){
                    $resultadosuma=0;
                }
                ?>
                <tr>
                    <th scope="row"><?php echo $resultado['codigo_producto']; ?></th>
                    <td><?php echo $resultado['nombre_producto']; ?></td>
                    <td><?php echo $resultado['marca']; ?></td>
                    <td class=" center-align"> <?php echo $resultado['cantidad']; ?></td>
                    <td class="alert alert-danger center-align"> <?php echo $resultadosuma; ?></td>
                    <td class="alert alert-primary  center-align"> <?php echo (abs($resultadosuma-$resultado['cantidad'])); ?></td>
                    <td><a href="salida_stock.php?producto=<?php echo $resultado['codigo_producto']; ?>" class="btn btn-danger"><i class="icon-upload2 bt btn-danger"></i></a></td>
                    <td><a href="informes.php?producto=<?php echo $resultado['codigo_producto']; ?>" class="btn btn-success"  target="_blank">infome salida</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php
include_once "../header/footer_temporal.php";
?>