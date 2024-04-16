<?php include "../header/header_panel.php";
if ($_GET){
    $id = $_GET["producto"];
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<div class="center-block z-depth-1 rounded white" style="width: 75%">
    <div style="padding: 1em">
        <h5 class="alert alert-info">Todas la salida de productos<a href="productos_generar.php"
                                                                    class="right btn btn-info">Regresar</a> </h5>
        <hr>
    </div>
</div>
<hr>
<div class="z-depth-1 rounded white center-block" style="width: 95%;border-radius: 6px;padding: 1em;">
    <table class="table table-striped table-bordered" style="padding: 1em;">
        <thead>
        <tr style="border-bottom: 1px solid black;" class="alert alert-info">
            <th scope="col">No.Factura</th>
            <th scope="col" class="center-align">Marca</th>
            <th scope="col">Fecha</th>
            <th scope="col">Hora</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $result4 = $mysqli->query("SELECT * FROM `baja_materiales` where codigo_producto = '$id'");
        while ($resultado = $result4->fetch_assoc()) {
            ?>
                <tr>
                <td>
                    <a href="#"><?php echo $resultado["indmaterial"]; ?></a>
                </td>
                <td><b><?php echo $resultado["codigo_producto"]; ?></b></td>
                <td class="center-align"><?php echo datos_clientes::traforma_fecha($resultado["fecha"]); ?></td>
                <td class="center-align"><?php echo $resultado["hora"]; ?></td>
            <?php
        } ?>
        </tbody>
    </table>
</div>

<?php include "../header/footer_temporal.php" ?>


