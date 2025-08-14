<?php
$page_title = 'Editar Resguardo de Inventario';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];
$id_user = $user['id_user'];

$e_resguardo = find_by_id('rel_resguardos_inv', (int)$_GET['id'], 'id_rel_resguardos_inv');
$categorias_articulos = find_all_order_by('cat_categorias_inv', 'descripcion', 'id_categoria_inv', (int)$_GET['id2']);
$id = (int)$_GET['id'];
$id2 = (int)$_GET['id2'];
$id3 = (int)$_GET['id3'];

if (!$e_resguardo) {
    $session->msg("d", "ID de no encontrado.");
    redirect('resguardos_inventario.php');
}

if ($nivel_user == 1) {
    page_require_level_exacto(1);
}
if ($nivel_user == 2) {
    page_require_level_exacto(2);
}
if ($nivel_user == 27) {
    page_require_level_exacto(27);
}
if ($nivel_user == 29) {
    page_require_level_exacto(29);
}
if ($nivel_user > 2 && $nivel_user < 27) :
    redirect('home.php');
endif;
if ($nivel_user > 27 && $nivel_user < 29) :
    redirect('home.php');
endif;
if ($nivel_user > 29) {
    redirect('home.php');
}
if (!$nivel_user) {
    redirect('home.php');
}

if (isset($_POST['update'])) {
    if (empty($errors)) {
        $id_res = (int)$e_resguardo['id_rel_resguardos_inv'];
        $id_categoria_inv2 = $db->escape($_POST['id_categoria_inv2']);

        $total_articulo = remove_junk($db->escape($_POST['total_articulo']));
        $fecha_corte = remove_junk($db->escape($_POST['fecha_corte']));
        $observaciones = remove_junk($db->escape($_POST['observaciones']));

        $folio_editar = $e_resguardo['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/resguardos/' . $resultado;

        $name = $_FILES['archivo_resguardos']['name'];
        $size = $_FILES['archivo_resguardos']['size'];
        $type = $_FILES['archivo_resguardos']['type'];
        $temp = $_FILES['archivo_resguardos']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        } else {
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '') {
            $sql = "UPDATE rel_resguardos_inv SET id_categoria_inv='{$id_categoria_inv2}', total_articulo='{$total_articulo}', fecha_corte='{$fecha_corte}', 
                    archivo_resguardos='{$name}', observaciones='{$observaciones}' WHERE id_rel_resguardos_inv='{$db->escape($id_res)}'";
        }
        if ($name == '') {
            $sql = "UPDATE rel_resguardos_inv SET id_categoria_inv='{$id_categoria_inv2}', total_articulo='{$total_articulo}', fecha_corte='{$fecha_corte}', 
                    observaciones='{$observaciones}' WHERE id_rel_resguardos_inv='{$db->escape($id_res)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada.");
            insertAccion($user['id_user'], '"' . $user['username'] . '" editó resguardo: (subcat: ' . $id_categoria_inv2 . ', cant.: ' . $total_articulo . ', fecha_corte: ' . $fecha_corte . ')', 2);
            redirect('ver_info_resguardos.php?id=' . (int)$id_categoria_inv2, false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('ver_info_resguardo?id=' . (int)$id3, false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_resguardos.php?id=' . (int)$id . '&id2=' . (int)$id2 . '&id3=' . (int)$id3, false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar Resguardo</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_resguardos.php?id=<?php echo (int)$id; ?>&id2=<?php echo (int)$id2;?>&id3=<?php echo (int)$id3; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="id_categoria_inv">Categoría del Artículo</label>
                            <select class="form-control" id="id_categoria_inv" name="id_categoria_inv">
                                <?php foreach ($categorias_articulos as $c_articulo) : ?>
                                    <option <?php if ($c_articulo['id_categoria_inv'] == $e_resguardo['id_categoria_inv'])
                                                echo 'selected="selected"'; ?> value="<?php echo $c_articulo['id_categoria_inv']; ?>"><?php echo ucwords($c_articulo['descripcion']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="col-md-2">
                        <div class="form-group">
                            <label for="id_categoria_inv2">Subcategoría del Artículo</label>
                            <select class="form-control" id="id_categoria_inv2" name="id_categoria_inv2" required></select>
                        </div>
                    </div> -->
                    <?php $asigna_a = find_all_cat_subcat_id($id2) ?>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="id_categoria_inv2">Subcategoría del Artículo</label>
                            <select class="form-control" id="id_categoria_inv2" name="id_categoria_inv2" required>
                                <?php foreach ($asigna_a as $asigna) : ?>
                                    <option <?php if ($asigna['id_categoria_inv'] === $e_resguardo['id_categoria_inv'])
                                                echo 'selected="selected"'; ?> value="<?php echo $asigna['id_categoria_inv']; ?>">
                                        <?php echo ucwords($asigna['categoria']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <script>
                        $(function() {
                            $("#id_categoria_inv").on("change", function() {
                                var variable = $(this).val();
                                $("#selected").html(variable);
                            })

                        });
                        $(function() {
                            $("#id_categoria_inv2").on("change", function() {
                                var variable2 = $(this).val();
                                $("#selected2").html(variable2);
                            })
                        });
                    </script>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="total_articulo">Total del Artículo</label>
                            <input type="number" min="1" class="form-control" name="total_articulo" value="<?php echo $e_resguardo['total_articulo'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="archivo_resguardos">Excel de Información</label>
                            <input type="file" accept=".xls, .xlsx" class="form-control" name="archivo_resguardos" id="archivo_resguardos" value="<?php echo remove_junk($e_resguardo['archivo_resguardos']); ?>">
                            <label style="font-size: 12px; color: #00a724ff !important;">Archivo Actual:
                                <?php echo remove_junk($e_resguardo['archivo_resguardos']); ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_corte">Fecha de Corte</label>
                            <input type="date" class="form-control" name="fecha_corte" value="<?php echo $e_resguardo['fecha_corte'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" cols="30" rows="2"> <?php echo $e_resguardo['observaciones'] ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="ver_info_resguardos.php?id=<?php echo $id3; ?>" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="update" class="btn btn-info">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Evento que detecta el cambio en el select
    document.getElementById('id_categoria_inv').addEventListener('change', function() {
        mostrarInputs(this.value);
    });
</script>
<?php include_once('layouts/footer.php'); ?>