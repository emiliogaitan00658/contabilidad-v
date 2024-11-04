
<style>
    .linea {
        display: inline-block;
        font-family: 'lucida grande', helvetica, verdana, arial, sans-serif!important;
    }
    #contenidoTabla {
        font-size: 5px;
        font-family: 'lucida grande', helvetica, verdana, arial, sans-serif!important;
    }
    td {
        font-size: 13px;
        font-family: 'lucida grande', helvetica, verdana, arial, sans-serif!important;
    }
    th {
        font-size: 13px;
        font-family: 'lucida grande', helvetica, verdana, arial, sans-serif!important;
    }
</style>
<body>
<?php
include_once '../BD-Connection/conection.php';
include_once '../BD-Connection/datos_clientes.php';
$talonario = datos_clientes::cambio_do($indsucursal, $mysqli);

$booos = datos_clientes::verficiar_talonario($key, $mysqli);
if ($booos["indtalonario"] == null || $booos["indtalonario"] == "") {
    datos_clientes::Factura_genera_codigo($key, $talonario, $indsucursal, $mysqli);
    //datos_clientes::cambio_fecha_factura();
}
$cliente = datos_clientes::datos_clientes_generales($booos["indcliente"], $mysqli);
/// verificamos de que se registro el control de la factura
datos_clientes::update_Control_factura($talonario, $key, $mysqli);
?>
<div style="margin-top: 4.5em!important;margin-left: 2em!important;">
    <p style="margin-left: 3.5em;width: 65%!important; font-size: 13px;" class="linea"><b><?php echo $cliente['nombre'] . " " . $cliente['apellido']; ?></b></p>
    <span style="position: static!important; width: 20%!important; font-size: 16px;margin-left: 3em;" class="linea"><b><?php echo datos_clientes::fecha_get_pc(); ?></b></span>
</div>
<br>
<table style="height: 150px; width: 600px;" id="contenidoTabla">
    <tbody>
    <?php
    $subtotal = datos_clientes::sumatotal_subtotal($key, $mysqli);
    //$total = datos_clientes::sumatotal_factursa_subfactura($key, $mysqli);
    $total = datos_clientes::sumatotal_factura_total($key, $mysqli);

    $bandera = 0;
    $result4 = $mysqli->query("SELECT * FROM `factura` where factura.indtemp='$key'");
    while ($resultado = $result4->fetch_assoc()) {
        $bandera = $bandera + 1;
        $descuento="";
        if ($resultado['descuento']!=0){$descuento="**Des"; $ultimo_descuento=$resultado['descuento'];}
        ?>
        <tr style="height: 5px;">
            <td style="width: 10px; height: 20px;margin-left: 0;padding-left: 0;"
                class="left-align"><?php echo $resultado['codigo_producto']; ?></td>
            <td style="width: 40px; height: 20px;margin-left: 0px"
                class="right-align"><?php echo $resultado['unidad']; ?></td>
            <td style="width: 460px; height: 20px;margin-left: 0px!important;"><?php echo datos_clientes::nombre_producto_completo($resultado['codigo_producto'], $mysqli); ?>  <i><?php echo $descuento; ?></i></td>
            <td style="width: 68px; height: 20px;padding-left: 0em"
                class="right-align"><?php echo number_format(($resultado['precio_unidad']), 2, '.', ','); ?></td>
            <td style="width: 68px; height: 20px;padding-left: 0em"
                class="right-align"><?php echo number_format(($resultado['precio_total']), 2, '.', ','); ?></td>
        </tr>
        <?php
    }
    $res = 9 - $bandera;
    if ($bandera == "0") {
    } else {
        for ($i = 1; $i <= $res; $i++) {
            ?>
            <tr style="height: 5px;">
                <td style="width: 100px; height: 20px;">&nbsp;</td>
                <td style="width: 40px; height:20px;">&nbsp;</td>
                <td style="width: 400px; height:20px;">&nbsp;</td>
                <td style="width: 68px; height:20px;">&nbsp;</td>
                <td style="width: 68px; height:20px;">&nbsp;</td>
            </tr>
        <?php }
    } ?>
    <tr style="height: 5px;">
        <td style="width: 100px; height: 20px;">&nbsp;</td>
        <td style="width: 40px; height:20px;">&nbsp;</td>
        <td style="width: 400px; height:20px;">&nbsp;<?php if ($ultimo_descuento!="") { echo "* Descuento aplicado sus productos = ".$ultimo_descuento. "%"." ( C$".number_format(($subtotal-$total), 2, '.', ',')."  ) "; }?></td>
        <td style="width: 68px; height:20px;">&nbsp;</td>
        <td style="width: 68px; height:20px;">&nbsp;</td>
    </tr>
    <tr style="height: 5px;margin-top: 0!important;">
        <td style="width: 100px; height:20px;">&nbsp;</td>
        <td style="width: 40px; height:20px;">&nbsp;</td>
        <td style="width: 400px; height:20px;">&nbsp;</td>
        <td style="width: 68px; height:20px;">&nbsp;</td>
        <td style="width: 68px; height:20px;font-size: 15px!important;"><?php echo number_format(($subtotal), 2, '.', ','); ?></td>
    </tr>
    <tr style="height: 5px;">
        <td style="width: 100px; height:20px;">&nbsp;</td>
        <td style="width: 40px; height:20px;">&nbsp;</td>
        <td style="width: 400px; height:20px;">&nbsp;</td>
        <td style="width: 68px; height:20px;">&nbsp;</td>
        <td style="width: 50px; height:20px;font-size: 15px!important;"><?php echo number_format(($total), 2, '.', ','); ?></td>
    </tr>
    </tbody>
</table>
</body>
