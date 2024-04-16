<?php
include_once "../header/header_panel.php";
include_once '../BD-Connection/conection.php';
include_once '../BD-Connection/datos_clientes.php';
if ($_GET){
    $codigo_p=$_GET["producto"];
}
if ($_POST){
    $codigo=$_POST["textcodigo"];
    $cantidad=$_POST["textcantidad"];
    $fecha=$_POST["textfecha"];
    $res=datos_clientes::registro_Stock_baja($codigo,$cantidad,$fecha,$mysqli);
    if ($res==true){
        echo ' <script>
 swal({
  title: "Exito!",
  text: "Agregado producto Stock",
  icon: "success",
  button: "OK",
}).then((value) => {
    location.href="productos_generar.php";
});
 </script>';
    }
}


?>
    <br>
    <div class="white rounded z-depth-2 center-block" style="border-radius: 6px; width: 90%">
        <div style="padding: 1em;">
            <h5 class="alert-primary" style="padding: 6px;border-radius: 6px">Dar de baja bodega principal</h5>
            <hr>
            <br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>"
                  method="post">
                <section class="row">
                    <div class="control-pares col-md-2">
                        <label for="">Codigo</label>
                        <input type="text" name="textcodigo" class="form-control" placeholder="Codigo"
                               value="<?php echo $codigo_p?>"  required readonly=readonly>
                    </div>
                    <div class="control-pares col-md-2">
                        <label for="">Cantidad</label>
                        <input type="text" name="textcantidad" class="form-control" placeholder="$"
                               value="<?php if ($_POST){ $_POST["textcantidad"];}else{  echo "0";}?>" required>
                    </div>
                    <div class="control-pares col-md-2">
                        <label for="">Fecha</label>
                        <input type="date" name="textfecha" class="form-control" placeholder="$"
                               value="<?php
                               if ($_POST) {
                                   echo $_POST["textfecha"];
                               } else {
                                   $fcha = date("Y-m-d");
                                   echo $fcha;
                               }

                               ?>" >
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="control-pares col-md-4">
                        <input type="submit" value="Guardar" class="btn white-text blue-grey btn-primary"/>
                    </div>
                </section>
            </form>
            <a class="btn btn-dark light-blue right" href="producto_cambio_precio.php"><i class="icon-arrow-left2"></i>Regresar</a>
            <hr>
        </div>
    </div>

<?php
include_once "../header/footer_temporal.php";
?>