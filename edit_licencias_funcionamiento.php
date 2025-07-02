<?php
$page_title = 'Editar Licencia de Funcionamiento';
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

$id_rel_licencias_funcionamiento = (int)$_GET['id'];
$id_inmbueble = (int)$_GET['idbi'];
$e_licencia_fun = find_by_id('rel_licencias_funcionamiento', $id_rel_licencias_funcionamiento, 'id_rel_licencias_funcionamiento');
$inmueble = find_by_id('bienes_inmuebles', $id_inmbueble, 'id_bien_inmueble');
?>
<?php
if (isset($_POST['edit_licencias_funcionamiento'])) {

    $tipo_licencia = remove_junk($db->escape($_POST['tipo_licencia']));
    $no_licencia = remove_junk($db->escape($_POST['no_licencia']));
    $ejercicio = remove_junk($db->escape($_POST['ejercicio']));
    $fecha_pago = remove_junk($db->escape($_POST['fecha_pago']));

    $folio = $inmueble['folio'];
    $resultado = str_replace("/", "-", $folio);
    $carpeta = 'uploads/inmuebles/' . $resultado . '/' . $ejercicio;

    $name = $_FILES['comprobante_pago']['name'];
    $size = $_FILES['comprobante_pago']['size'];
    $type = $_FILES['comprobante_pago']['type'];
    $temp = $_FILES['comprobante_pago']['tmp_name'];

    $name2 = $_FILES['documento_licencia']['name'];
    $size2 = $_FILES['documento_licencia']['size'];
    $type2 = $_FILES['documento_licencia']['type'];
    $temp2 = $_FILES['documento_licencia']['tmp_name'];

    if (is_dir($carpeta)) {
        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        $move =  move_uploaded_file($temp2, $carpeta . "/" . $name2);
    } else {
        mkdir($carpeta, 0777, true);
        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        $move =  move_uploaded_file($temp2, $carpeta . "/" . $name2);
    }

    if ($name != '' && $name2 != '') {
        $query  = "UPDATE rel_licencias_funcionamiento SET tipo_licencia='{$tipo_licencia}', no_licencia='{$no_licencia}', ejercicio='{$ejercicio}',
                        fecha_pago='{$fecha_pago}', comprobante_pago='{$name}', documento_licencia = '{$name2}'";
    }
    if ($name != '' && $name2 == '') {
        $query  = "UPDATE rel_licencias_funcionamiento SET tipo_licencia='{$tipo_licencia}', no_licencia='{$no_licencia}', ejercicio='{$ejercicio}',
                        fecha_pago='{$fecha_pago}', comprobante_pago='{$name}'";
    }
    if ($name == '' && $name2 != '') {
        $query  = "UPDATE rel_licencias_funcionamiento SET tipo_licencia='{$tipo_licencia}', no_licencia='{$no_licencia}', ejercicio='{$ejercicio}',
                        fecha_pago='{$fecha_pago}', documento_licencia = '{$name2}'";
    }
    if ($name == '' && $name2 == '') {
        $query  = "UPDATE rel_licencias_funcionamiento SET tipo_licencia='{$tipo_licencia}', no_licencia='{$no_licencia}', ejercicio='{$ejercicio}',
                        fecha_pago='{$fecha_pago}'";
    }

    $query .= " WHERE id_rel_licencias_funcionamiento='{$db->escape($id_rel_licencias_funcionamiento)}'";

    $result = $db->query($query);

    if ($result == 1) {
        //sucess
        $session->msg('s', "La información de la Licencia de Funcionamiento ha sido actualizada correctamente.");
        insertAccion($user['id_user'], '"' . $user['username'] . '" editó licencia de funcionamiento con id: ' . (int)$e_licencia_fun['id_rel_licencias_funcionamiento'] . ' del inmueble con id: ' . $inmueble['id_bien_inmueble'], 2);
        redirect('edit_licencias_funcionamiento.php?id=' . (int)$e_licencia_fun['id_rel_licencias_funcionamiento'] . '&idbi=' . (int)$inmueble['id_bien_inmueble'], false);
    } else {
        //failed
        $session->msg('d', 'Lamentablemente no se ha actualizado la Licencia de Funcionamiento, debido a que no hay cambios registrados.');
        redirect('edit_licencias_funcionamiento.php?id=' . (int)$e_licencia_fun['id_rel_licencias_funcionamiento'] . '&idbi=' . (int)$inmueble['id_bien_inmueble'], false);
    }
}
?>
<?php header('Content-Type: text/html; charset=utf-8');
include_once('layouts/header.php'); ?>
<div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
<div class="row login-page6" style="width: 50%; height: 450px; margin-left: 25%; margin-top: 5%;">
    <div class="panel-heading" style="height: 11%">
        <strong>
            <span style="font-size: 16px;">EDITAR LICENCIA DE FUNCIONAMIENTO DEL INMUEBLE: <?php echo $inmueble['folio']; ?></span>
        </strong>
    </div>
    <div class="panel-body" style=" margin-top: -5%;">
        <form method="post" action="edit_licencias_funcionamiento.php?id=<?php echo (int)$e_licencia_fun['id_rel_licencias_funcionamiento']; ?>&idbi=<?php echo (int)$inmueble['id_bien_inmueble'] ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_licencia">Tipo de Licencia</label>
                        <input type="text" class="form-control" name="tipo_licencia" value="<?php echo $e_licencia_fun['tipo_licencia']; ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="no_licencia">Número de Licencia</label>
                        <input type="text" class="form-control" name="no_licencia" value="<?php echo $e_licencia_fun['no_licencia']; ?>" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="ejercicio">Ejercicio</label>
                        <div class="form-group">
                            <select class="form-control" name="ejercicio" onchange="changueAnio(this.value)" required>
                                <option value="">Escoge una opción</option>
                                <?php for ($i = 2021; $i <= (int) date("Y"); $i++) {
                                    echo "<option value='" . $i . "' " . ($e_licencia_fun['ejercicio'] == "$i" ? "selected='selected'" : "") . ">" . $i . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="fecha_pago">Fecha de Pago</label>
                        <input type="date" class="form-control" name="fecha_pago" value="<?php echo $e_licencia_fun['fecha_pago']; ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="comprobante_pago">Comprobante de Pago</label>
                        <input type="file" class="form-control" name="comprobante_pago" value="<?php echo $e_licencia_fun['comprobante_pago']; ?>"><label style="font-size:12px; color:#E3054F;">Archivo Actual:
                            <?php echo remove_junk($e_licencia_fun['comprobante_pago']); ?>
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="documento_licencia">Documento de Licencia</label>
                        <input type="file" class="form-control" name="documento_licencia" value="<?php echo $e_licencia_fun['documento_licencia']; ?>"><label style="font-size:12px; color:#E3054F;">Archivo Actual:
                            <?php echo remove_junk($e_licencia_fun['documento_licencia']); ?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group clearfix" style="margin-top: 10%;">
                <a href="licencias_funcionamiento.php?id=<?php echo $inmueble['id_bien_inmueble'] ?>" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                    Regresar
                </a>
                <button type="submit" name="edit_licencias_funcionamiento" class="btn btn-info">Guardar</button>
            </div>
        </form>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>