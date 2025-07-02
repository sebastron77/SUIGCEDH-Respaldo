<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('includes/load.php');

$page_title = 'Licencias de Funcionamiento';
$id_inmueble =  (int)$_GET['id'];
$user = current_user();
$nivel_user = $user['user_level'];
$id_user = $user['id_user'];
$inmueble = find_by_id('bienes_inmuebles', $id_inmueble, 'id_bien_inmueble');
$e_detalle = find_all_by('rel_licencias_funcionamiento', $id_inmueble, 'id_bien_inmueble');

$ver_info = find_by_id_inmueble((int)$_GET['id']);
$folio_carpeta = str_replace("/", "-", $ver_info['folio']);

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
?>

<?php
if (isset($_POST['licencias_funcionamiento'])) {
    $tipo_licencia = remove_junk($db->escape($_POST['tipo_licencia']));
    $no_licencia = remove_junk($db->escape($_POST['no_licencia']));
    $ejercicio = remove_junk($db->escape($_POST['ejercicio']));
    $fecha_pago = remove_junk($db->escape($_POST['fecha_pago']));
    $fecha_creacion = date('Y-m-d');

    $carpeta = 'uploads/inmuebles/' . $folio_carpeta . '/' . $ejercicio;

    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $name = $_FILES['comprobante_pago']['name'];
    $size = $_FILES['comprobante_pago']['size'];
    $type = $_FILES['comprobante_pago']['type'];
    $temp = $_FILES['comprobante_pago']['tmp_name'];

    $name2 = $_FILES['documento_licencia']['name'];
    $size2 = $_FILES['documento_licencia']['size'];
    $type2 = $_FILES['documento_licencia']['type'];
    $temp2 = $_FILES['documento_licencia']['tmp_name'];

    $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
    $move2 =  move_uploaded_file($temp2, $carpeta . "/" . $name2);

    // Inserta en la base de datos
    $query = "INSERT INTO rel_licencias_funcionamiento (";
    $query .= "id_bien_inmueble, tipo_licencia, no_licencia, ejercicio, fecha_pago, comprobante_pago, documento_licencia, usuario_creador, fecha_creacion";
    $query .= ") VALUES (";
    $query .= "'{$id_inmueble}', '{$tipo_licencia}', '{$no_licencia}', '{$ejercicio}', '{$fecha_pago}', '{$name}', '{$name2}', '{$id_user}', 
                '{$fecha_creacion}'";
    $query .= ")";
    $x = $db->query($query);

    if (isset($x)) {
        $session->msg('s', "La Licencia de Funcionamiento del Inmueble ha sido agregada correctamente.");
        insertAccion($user['id_user'], '"' . $user['username'] . '" agregó Licencia de Funcionamiento del Inmueble: ' . $inmueble['folio'] . '.', 2);
    } else {
        $session->msg('d', 'No se agregó ningún documento.');
    }

    redirect('licencias_funcionamiento.php?id=' . $id_inmueble, false);
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
<div class="row">
    <div class="col-md-6">
        <div class="panel login-page5" style="margin-left: 0%;">
            <div class="panel-heading">
                <strong style="font-size: 16px; font-family: 'Montserrat', sans-serif;">
                    <span class="material-symbols-rounded" style="margin-top: 3%; color: #3a3d44;">receipt_long</span>
                    <p style="margin-top: -2.5%; margin-left: 3%;">LICENCIAS DE FUNCIONAMIENTO DEL INMUEBLE: <?php echo $inmueble['folio']; ?></p>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="licencias_funcionamiento.php?id=<?php echo (int)$inmueble['id_bien_inmueble']; ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_licencia">Tipo de Licencia</label>
                                <input type="text" class="form-control" name="tipo_licencia" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_licencia">Número de Licencia</label>
                                <input type="text" class="form-control" name="no_licencia" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ejercicio">Ejercicio</label>
                                <div class="form-group">
                                    <select class="form-control" name="ejercicio" onchange="changueAnio(this.value)" required>
                                        <option value="">Selecciona Año</option>
                                        <?php for ($i = 2021; $i <= (int) date("Y"); $i++) {
                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha_pago">Fecha de Pago</label>
                                <input type="date" class="form-control" name="fecha_pago" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="comprobante_pago">Comprobante de Pago</label>
                                <input type="file" class="form-control" name="comprobante_pago" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="documento_licencia">Documento de Licencia</label>
                                <input type="file" class="form-control" name="documento_licencia" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <a href="bienes_inmuebles.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                            Regresar
                        </a>
                        <button type="submit" name="licencias_funcionamiento" class="btn btn-info">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6 panel-body" style="height: 100%;">
        <table class="table table-bordered table-striped" style="width: 100%; float: left;" id="tblProductos">
            <thead class="thead-purple" style="margin-top: -50px;">
                <tr style="height: 10px;">
                    <th colspan="5" style="text-align:center; font-size: 14px;">Expediente General del Inmueble</th>
                </tr>
                <tr style="height: 10px;">
                    <th class="text-center" style="width: 5%; font-size: 14px;">Ejercicio</th>
                    <th class="text-center" style="width: 30%; font-size: 14px;">Tipo Licencia</th>
                    <th class="text-center" style="width: 30%; font-size: 14px;">No. Licencia</th>
                    <th class="text-center" style="width: 10%; font-size: 14px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($e_detalle ?? [] as $detalle) :
                    $carpeta = 'uploads/inmuebles/' . $folio_carpeta;
                ?>
                    <tr>
                        <td class="text-center" style="font-size: 14px;"><?php echo $detalle['ejercicio'] ?></td>
                        <td style="font-size: 14px;"><?php echo $detalle['tipo_licencia'] ?></td>
                        <td style="font-size: 14px;"><?php echo $detalle['no_licencia'] ?></td>
                        <td style="font-size: 14px;" class="text-center">
                            <a href="ver_info_licencias_funcionamiento.php?id=<?php echo (int) $detalle['id_rel_licencias_funcionamiento']; ?>" class="btn btn-md btn-info"
                                data-toggle="tooltip" style="height: 30px; width: 30px;" title="Ver información">
                                <span class="material-symbols-outlined" style="font-size: 22px; color: white; margin-top: 1px; margin-left: -4px;">
                                    visibility
                                </span>
                            </a>
                            <a href="edit_licencias_funcionamiento.php?id=<?php echo (int)$detalle['id_rel_licencias_funcionamiento']; ?>&idbi=<?php echo $id_inmueble; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip" style="height: 30px; width: 30px;">
                                <span class="material-symbols-rounded" style="font-size: 22px; color: black; margin-top: 1px; margin-left: -3px;">
                                    edit
                                </span>
                            </a>
                            <a href="delete_licencias_funcionamiento.php?id=<?php echo (int)$detalle['id_rel_licencias_funcionamiento']; ?>&idbi=<?php echo $id_inmueble; ?>&anio=<?php echo $detalle['ejercicio'] ?>" class=" btn btn-dark btn-md" title="Eliminar" data-toggle="tooltip" style="height: 30px; width: 30px;"><span class="material-symbols-rounded" style="font-size: 22px; color: white; margin-top: -1.5px; margin-left: -5px;">delete</span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>