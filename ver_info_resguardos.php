<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Histórico de Resguardos';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];
$historico = find_all_hist_resguardos((int)$_GET['id']);
$id3 = (int)$_GET['id'];

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
?>

<?php include_once('layouts/header.php'); ?>
<a href="resguardos_inventario.php" class="btn btn-success">Regresar</a><br><br>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>HISTÓRICO DE RESGUARDOS DEL INVENTARIO: <?php echo $historico[0][10] . ' - ' . $historico[0][9]?></span>
                </strong>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th class="text-center" style="width: 1%;">#</th>
                            <th class="text-center" style="width: 5%;">Folio</th>
                            <th class="text-center" style="width: 5%;">Categoría</th>
                            <th class="text-center" style="width: 5%;">Subcategoría</th>
                            <th class="text-center" style="width: 5%;">Total</th>
                            <th class="text-center" style="width: 5%;">Fecha de Corte</th>
                            <th class="text-center" style="width: 1%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historico as $hist) : ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td class="text-center">
                                    <?php echo $hist['folio']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $hist['desc_padre']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $hist['categoria']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $hist['total_articulo']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $hist['fecha_corte']; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_resguardos.php?id=<?php echo (int) $hist['id_rel_resguardos_inv']; ?>&id2=<?php echo (int) $hist['id_padre'];?>&id3=<?php echo $id3; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" style="height: 30px; width: 30px;" title="Editar">
                                            <span class="material-symbols-outlined" style="font-size: 22px; color: black !important; margin-left: -5px;">
                                                edit
                                            </span>
                                        </a>
                                        <a href="delete_resguardo.php?id=<?php echo (int) $hist['id_rel_resguardos_inv']; ?>&id3=<?php echo $id3; ?>" class="btn btn-delete btn-md" title="Eliminar" data-toggle="tooltip" onclick="return confirm('¿Seguro(a) que deseas eliminar el Resguardo?');">
                                            <span class="glyphicon glyphicon-trash"></span><?php insertAccion($user['id_user'], '"' . $user['username'] . '" eliminó el resguardo de inventario, Folio: ' . $hist['folio'] . '.', 4); ?>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>