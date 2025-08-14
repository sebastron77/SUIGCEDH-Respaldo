<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Resguardos del Inventario';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];
$resguardos = find_all_resguardos();

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
if 
($nivel_user > 29) {
    redirect('home.php');
}
if (!$nivel_user) {
    redirect('home.php');
}
?>

<?php include_once('layouts/header.php'); ?>
<a href="solicitudes_gestion.php" class="btn btn-success">Regresar</a><br><br>
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
                    <span>RESGUARDOS DEL INVENTARIO</span>
                </strong>
                <a href="add_resguardo_inv.php" class="btn btn-info pull-right">Agregar Resguardo</a>
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
                            <?php if ($nivel_user == 1 || $nivel_user == 14) : ?>
                                <th style="width: 1%;" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resguardos as $resg) : ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td class="text-center">
                                    <?php echo $resg['folio']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $resg['desc_padre']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $resg['categoria']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $resg['total_articulo']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $resg['fecha_corte']; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($nivel_user == 1 || $nivel_user == 14) : ?>
                                        <div class="btn-group">
                                            <a href="ver_info_resguardos.php?id=<?php echo (int) $resg['id_categoria_inv']; ?>" class="btn btn-md"
                                                data-toggle="tooltip" style="height: 30px; width: 30px; background: #009474ff" title="Ver Histórico de Resguardos">
                                                <span class="material-symbols-outlined" style="font-size: 22px; color: white; margin-top: 1px; margin-left: -5px;">
                                                    calendar_month
                                                </span>
                                            </a>                                            
                                        </div>
                                    <?php endif; ?>
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