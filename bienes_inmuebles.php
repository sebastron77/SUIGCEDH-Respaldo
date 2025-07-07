<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Lista de Inmuebles';
require_once('includes/load.php');
?>
<?php

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
$all_inmuebles = find_all_inmuebles();
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
                    <span>Lista de Inmuebles</span>
                </strong>
                <?php if ($nivel_user <= 2 || $nivel_user == 28) : ?>
                    <a href="add_bien_inmueble.php" class="btn btn-info pull-right">Agregar Inmueble</a>
                <?php endif; ?>
            </div>
            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th class="text-center" style="width: 1%;">#</th>
                            <th class="text-center" style="width: 3%;">Vig. Lic. Func.</th>
                            <th class="text-center" style="width: 7%;">Denominación</th>
                            <th class="text-center" style="width: 7%;">Municipio</th>
                            <th th class="text-center" style="width: 7%;">Tipo Inmueble</th>
                            <th class="text-center" style="width: 7%;">Origen Propiedad</th>
                            <th class="text-center" style="width: 15%;">Área Responsable</th>
                            <?php if ($nivel_user == 1 || $nivel_user == 28) : ?>
                                <th style="width: 1%;" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_inmuebles as $a_inmueble):
                            $anio_actual = date('Y');
                            $anio_inicio = 2021;
                            $fecha_actual = (int) date('md'); // Ej. 0625 = 06/25 - 25 de junio
                            $tiene_todo = true;

                            // Recorremos desde 2021 hasta el año actual
                            for ($anio = $anio_inicio; $anio <= $anio_actual; $anio++) {
                                $licencia = buscar_licencia_funcionamiento('rel_licencias_funcionamiento', 'id_bien_inmueble', 'ejercicio', $anio, $a_inmueble['id_bien_inmueble']);
                                if ($licencia['total'] == 0) {
                                    //Si el año actual en el que va el for no esta cargado arroja false y se rompe el ciclo.
                                    //Si ya esta todo cargado y la consulta da 1, entonces arroja true.
                                    $tiene_todo = false;
                                    break;
                                }
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td class="text-center">
                                    <?php if ($tiene_todo): ?>
                                        <span class="material-symbols-outlined semaforo verde" title="Licencias completas">check</span>
                                    <?php elseif ($fecha_actual <= 815): ?>
                                        <span class="material-symbols-outlined semaforo amarillo" title="Aún en tiempo">timer</span>
                                    <?php else: ?>
                                        <span class="material-symbols-outlined semaforo rojo" title="Licencias incompletas">exclamation</span>
                                    <?php endif; ?>
                                </td>
                                <!-- resto de columnas -->

                                <td class="text-center">
                                    <?php echo ucwords($a_inmueble['denominacion']) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo ucwords($a_inmueble['municipio']) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo ucwords($a_inmueble['tipo_inmueble']) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo ucwords($a_inmueble['origen_propiedad']) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo ucwords($a_inmueble['area_responsable']) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($nivel_user == 1 || $nivel_user == 28) : ?>
                                        <div class="btn-group">
                                            <a href="ver_info_inmueble.php?id=<?php echo (int) $a_inmueble['id_bien_inmueble']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información" style="height: 35px; width: 35px;">
                                                <span class="material-symbols-rounded">
                                                    visibility
                                                </span>
                                            </a>
                                            <a href="edit_bien_inmueble.php?id=<?php echo (int) $a_inmueble['id_bien_inmueble']; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" title="Editar" style="height: 35px; width: 35px;">
                                                <span class="material-symbols-rounded" style="color: black">
                                                    edit
                                                </span>
                                            </a>
                                            <a href="licencias_funcionamiento.php?id=<?php echo (int) $a_inmueble['id_bien_inmueble']; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" title="Licencias" style="background-color: #ff4574; border-color: #ff4574;">
                                                <span class="material-symbols-outlined" style="color: white; margin-top: 1px; margin-left: -3px;">
                                                    build
                                                </span>
                                            </a>
                                            <a href="expediente_inmuebles.php?id=<?php echo (int) $a_inmueble['id_bien_inmueble']; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" title="Expediente" style="background-color:#3096e9; border-color: #3096e9;">
                                                <span class="material-symbols-outlined" style="color: white;  margin-top: 3px; margin-left: -1px;">
                                                    home_storage
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