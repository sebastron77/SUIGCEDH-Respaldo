<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL ^ E_NOTICE);
require_once('includes/load.php');
$page_title = 'Agregar Resguardo de Inventario';
$user = current_user();
$nivel_user = $user['user_level'];
$id_user = $user['id_user'];
$categorias_articulos = find_all_order_by('cat_categorias_inv', 'descripcion', 'padre', 0);
$id_folio = last_id_folios();

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
<style>
    .hidden {
        visibility: hidden;
        height: 0;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }
</style>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_resguardo_inv'])) {
    if (empty($errors)) {

        $id_categoria_inv2 = $db->escape($_POST['id_categoria_inv2']);

        $total_articulo = remove_junk($db->escape($_POST['total_articulo']));
        $fecha_corte = remove_junk($db->escape($_POST['fecha_corte']));
        $observaciones = remove_junk($db->escape($_POST['observaciones']));
        date_default_timezone_set('America/Mexico_City');
        $creacion = date('Y-m-d');

        if (count($id_folio) == 0) {
            $nuevo_id_folio = 1;
            $no_folio1 = sprintf('%04d', 1);
        } else {
            foreach ($id_folio as $nuevo) {
                $nuevo_id_folio = (int)$nuevo['contador'] + 1;
                $no_folio1 = sprintf('%04d', (int)$nuevo['contador'] + 1);
            }
        }

        $year = date("Y");
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-RSG';
        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-RSG';
        $carpeta = 'uploads/resguardos/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['archivo_resguardos']['name'];
        $size = $_FILES['archivo_resguardos']['size'];
        $type = $_FILES['archivo_resguardos']['type'];
        $temp = $_FILES['archivo_resguardos']['tmp_name'];

        $move = move_uploaded_file($temp, $carpeta . "/" . $name);

        /*creo archivo index para que no se muestre el Index Of*/
        $source = 'uploads/index.php';
        if (copy($source, $carpeta . '/index.php')) {
            echo "El archivo ha sido copiado exitosamente.";
        } else {
            echo "Ha ocurrido un error al copiar el archivo.";
        }

        $query = "INSERT INTO rel_resguardos_inv (";
        $query .= "folio, id_categoria_inv, total_articulo, fecha_corte, archivo_resguardos, observaciones, user_creador, fecha_creacion";
        $query .= ") VALUES (";
        $query .= " '{$folio}', '{$id_categoria_inv2}', '{$total_articulo}', '{$fecha_corte}', '{$name}', '{$observaciones}', '{$id_user}', '{$creacion}') ";

        $query2 = "INSERT INTO folios (";
        $query2 .= "folio, contador";
        $query2 .= ") VALUES (";
        $query2 .= " '{$folio}','{$no_folio1}'";
        $query2 .= ")";

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', "El resguardo ha sido agregado con éxito.");
            insertAccion($user['id_user'], '"' . $user['username'] . '" agregó resguardo: (subcat: ' . $id_categoria_inv2 . ', cant.: ' . $total_articulo . ', fecha_corte: ' . $fecha_corte . ')', 1);
            redirect('resguardos_inventario.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar el resguardo de inventario.');
            redirect('add_resguardo_inv.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_resguardo_inv.php', false);
    }
}
?>

<?php
header('Content-type: text/html; charset=utf-8');
include_once('layouts/header.php');
?>
<?php echo display_msg($msg); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Agregar Resguardo de Inventario</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_resguardo_inv.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="id_categoria_inv">Categoría del Artículo</label>
                            <select class="form-control" id="id_categoria_inv" name="id_categoria_inv" required>
                                <option value="">Escoge una opción</option>
                                <?php foreach ($categorias_articulos as $c_articulo) : ?>
                                    <option value="<?php echo $c_articulo['id_categoria_inv']; ?>"><?php echo ucwords($c_articulo['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="id_categoria_inv2">Subcategoría del Artículo</label>
                            <select class="form-control" id="id_categoria_inv2" name="id_categoria_inv2" required></select>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_categoria_inv3">Artículo</label>
                            <select class="form-control" id="id_categoria_inv3" name="id_categoria_inv3" ></select>
                        </div>
                    </div> -->
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="total_articulo">Total del Artículo</label>
                            <input type="number" min="1" class="form-control" name="total_articulo" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="archivo_resguardos">Excel de Información</label>
                            <input type="file" accept=".xls, .xlsx" class="form-control" name="archivo_resguardos" id="archivo_resguardos" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_corte">Fecha de Corte</label>
                            <input type="date" class="form-control" name="fecha_corte" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" cols="30" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <script>
                    //CATEGORÍA
                    $(function() {
                        $("#id_categoria_inv").on("change", function() {
                            var variable = $(this).val();
                            $("#selected").html(variable);

                        })
                    });
                    //SUBCATEGORÍA
                    $(function() {
                        $("#id_categoria_inv").on("change", function() {
                            var variable2 = $(this).val();
                            $("#selected2").html(variable2);
                        })
                    });
                </script>
                <div class="form-group clearfix">
                    <a href="resguardos_inventario.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_resguardo_inv" class="btn btn-primary">Guardar</button>
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