<?php
$page_title = 'Editar Expediente Inmuebles';
require_once('includes/load.php');
$user = current_user();
$nivel_user = $user['user_level'];

if ($nivel_user == 1) {
    page_require_level_exacto(1);
}
if ($nivel_user == 2) {
    page_require_level_exacto(2);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user == 28) {
    page_require_level_exacto(28);
}
if ($nivel_user == 29) {
    page_require_level_exacto(29);
}
if ($nivel_user > 2 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7 && $nivel_user < 28) :
    redirect('home.php');
endif;
if ($nivel_user > 29) {
    redirect('home.php');
}
if (!$nivel_user) {
    redirect('home.php');
}

$id_rel_exp_inmuebles = (int)$_GET['id'];
$id_inmbueble = (int)$_GET['idbi'];
$e_exp_inmueble = find_by_id('rel_expedientes_inmuebles', $id_rel_exp_inmuebles, 'id_rel_expedientes_inmuebles');
$inmueble = find_by_id('bienes_inmuebles', $id_inmbueble, 'id_bien_inmueble');
?>
<?php
if (isset($_POST['edit_expediente_inmuebles'])) {

    $nombre_documento = $_POST['nombre_documento'];

    $folio = $inmueble['folio'];
    $resultado = str_replace("/", "-", $folio);
    $carpeta = 'uploads/inmuebles/' . $resultado;

    $name = $_FILES['documento']['name'];
    $size = $_FILES['documento']['size'];
    $type = $_FILES['documento']['type'];
    $temp = $_FILES['documento']['tmp_name'];

    if (is_dir($carpeta)) {
        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
    } else {
        mkdir($carpeta, 0777, true);
        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
    }
    
    if($name != ''){
        $query  = "UPDATE rel_expedientes_inmuebles SET nombre_documento = '{$nombre_documento}', documento = '{$name}'";
    }

    if($name == ''){
        $query  = "UPDATE rel_expedientes_inmuebles SET nombre_documento = '{$nombre_documento}'";
    }

    $query .= " WHERE id_rel_expedientes_inmuebles='{$db->escape($id_rel_exp_inmuebles)}'";

    $result = $db->query($query);

    if ($result == 1) {
        //sucess
        $session->msg('s', "La información del expediente del inmueble ha sido actualizada correctamente.");
        insertAccion($user['id_user'], '"' . $user['username'] . '" editó expediente con id: ' . (int)$e_exp_inmueble['id_rel_expedientes_inmuebles'] . ' del inmueble con id: ' . $inmueble['id_bien_inmueble'], 2);
        redirect('edit_expediente_inmuebles.php?id=' . (int)$e_exp_inmueble['id_rel_expedientes_inmuebles'] . '&idbi=' . (int)$inmueble['id_bien_inmueble'], false);
    } else {
        //failed
        $session->msg('d', 'Lamentablemente no se ha actualizado el expediente del inmueble, debido a que no hay cambios registrados.');
        redirect('edit_expediente_inmuebles.php?id=' . (int)$e_exp_inmueble['id_rel_expedientes_inmuebles'] . '&idbi=' . (int)$inmueble['id_bien_inmueble'], false);
    }
}
?>
<?php header('Content-Type: text/html; charset=utf-8');
include_once('layouts/header.php'); ?>
<div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
<div class="row login-page6" style="width: 40%; height: 350px; margin-left: 25%; margin-top: 5%;">
    <div class="panel-heading" style="height: 11%">
        <strong>
            <span style="font-size: 16px;">EDITAR EXPEDIENTE DE INMUEBLE: <?php echo $inmueble['folio']; ?></span>
        </strong>
    </div>
    <div class="panel-body" style=" margin-top: -5%;">
        <form method="post" action="edit_expediente_inmuebles.php?id=<?php echo (int)$e_exp_inmueble['id_rel_expedientes_inmuebles']; ?>&idbi=<?php echo (int)$inmueble['id_bien_inmueble']?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre_documento">Nombre del Documento</label>
                        <input class="form-control" type="text" name="nombre_documento" value="<?php echo $e_exp_inmueble['nombre_documento'] ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="documento">Documento</label>
                        <input type="file" class="form-control" name="documento">
                        <label style="font-size:12px; color:#E3054F;">Archivo Actual:
                            <?php echo remove_junk($e_exp_inmueble['documento']); ?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group clearfix" style="margin-top: 10%;">
                <a href="expediente_inmuebles.php?id=<?php echo $inmueble['id_bien_inmueble'] ?>" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                    Regresar
                </a>
                <button type="submit" name="edit_expediente_inmuebles" class="btn btn-info">Guardar</button>
            </div>
        </form>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>