<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Expediente del Inmueble';
require_once('includes/load.php');

$id_inmueble =  (int)$_GET['id'];
?>
<?php
$user = current_user();
$nivel_user = $user['user_level'];
$id_user = $user['id_user'];
$inmueble = find_by_id('bienes_inmuebles', $id_inmueble, 'id_bien_inmueble');
$e_detalle = find_all_by('rel_expedientes_inmuebles', $id_inmueble, 'id_bien_inmueble');

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
if (isset($_POST['expediente_inmuebles'])) {
    $documentos = array();
    $nombre_documento = $_POST['nombre_documento'];
    $fecha_creacion = date('Y-m-d');

    foreach ($_FILES["documento"]["name"] as $key => $nombreArchivo) {
        if (!empty($nombreArchivo)) {
            $archivoTmp = $_FILES["documento"]["tmp_name"][$key];
            $nombreDoc = $nombre_documento[$key]; // Asegúrate de que coincidan
            $folio_carpeta = str_replace("/", "-", $inmueble['folio']);
            $carpeta = 'uploads/inmuebles/' . $folio_carpeta . '/';

            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $rutaDestino = $carpeta . '/' . $nombreArchivo;

            if (move_uploaded_file($archivoTmp, $rutaDestino)) {
                $documentos[] = [
                    'nombre_documento' => $nombreDoc,
                    'documento' => $nombreArchivo
                ];

                // Copia de seguridad de index.php
                $source = 'uploads/index.php';
                copy($source, $carpeta . '/index.php');
            }
        }
    }

    // Inserta en la base de datos
    foreach ($documentos as $doc) {
        $query = "INSERT INTO rel_expedientes_inmuebles (
            id_bien_inmueble, nombre_documento, documento, user_creador, fecha_creacion
        ) VALUES (
            '{$id_inmueble}', '{$doc['nombre_documento']}', '{$doc['documento']}', '{$id_user}', '{$fecha_creacion}'
        )";
        $db->query($query);
    }

    if (!empty($documentos)) {
        $session->msg('s', "El Expediente del Inmueble ha sido agregado correctamente.");
        insertAccion($user['id_user'], '"' . $user['username'] . '" agregó expediente del inmueble ' . $inmueble['folio'] . '.', 2);
    } else {
        $session->msg('d', 'No se agregó ningún documento.');
    }

    redirect('expediente_inmuebles.php?id=' . $id_inmueble, false);
}
?>

<script type="text/javascript">
    $(document).ready(function() {

        $("#addRow").click(function() {
            var num = (document.getElementsByClassName("puesto").length) + 1;
            var html = '<div id="inputFormRow" style="margin-top: 4%;">';
            html += '   <div style="margin-bottom: 1%; margin-top: -3%">';
            html += '       <hr style="margin-top: -1%; margin-left: 1%; width: 96.5%; border-width: 2px; border-color: #7263f0; opacity: 1"></hr>';
            html += '	    <div class="col-md-5" style="margin-left: -15px; margin-top: 1px;">';
            html += '           <span class="material-symbols-rounded" style="margin-top: 1%; color: #3a3d44;">apartment</span>';
            html += '           <p style="font-size: 15px; font-weight: bold; margin-top: -22px; margin-left: 11%">EXPEDIENTE ACADÉMICO</p>';
            html += '       </div>';
            html += '	    <div class="col-md-2" style="margin-left: -5%; margin-top: -1px;">';
            html += '	        <button type="button" class="btn btn-outline-danger" id="removeRow" style="width: 50px; height: 30px"> ';
            html += '       	    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard2-x-fill" viewBox="0 0 16 16">';
            html += '	    		<path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5  0 0 0-.5-.5.5.5 0 0 1-.5-.5Z"></path>';
            html += '	    		<path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 1 1 .708-.708L8 8.293Z"></path>';
            html += '	    	    </svg>';
            html += '  	        </button>';
            html += '	    </div> <br><br>';
            html += '   </div>';
            html += '    <div class="row">';
            html += '       <div class="col-md-6">';
            html += '           <div class="form-group">';
            html += '               <label for="nombre_documento">Nombre del Documento</label>';
            html += '               <input type="text" class="form-control" name="nombre_documento[]">';
            html += '           </div>';
            html += '       </div>';
            html += '       <div class="col-md-6">';
            html += '           <div class="form-group">';
            html += '               <label for="documento">Documento</label>';
            html += '               <input type="file" accept="application/pdf" class="form-control" name="documento[]">';
            html += '           </div>';
            html += '       </div>';
            html += '   </div>';
            html += '';
            $('#newRow').append(html);
        });

        $(document).on('click', '#removeRow', function() {
            $(this).closest('#inputFormRow').remove();
        });


    });
</script>

<?php include_once('layouts/header.php'); ?>
<div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
<div class="row">
    <div class="col-md-6">
        <div class="panel login-page5" style="margin-left: 0%;">
            <div class="panel-heading" style=" margin-top: 2%;">
                <strong style="font-size: 16px; font-family: 'Montserrat', sans-serif;">
                    <span class="glyphicon glyphicon-th"></span>
                    INFORMACIÓN DEL INMUEBLE: <?php echo $inmueble['folio']; ?>
                </strong>
            </div>
            <div class="row" style="margin-top: 3%; margin-bottom: 2%; margin-left: 1%;">
                <div class="col-md-1">
                    <button type="button" class="btn btn-success" id="addRow" name="addRow" style="width: 50px">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-clipboard2-plus-fill" viewBox="0 0 16 16">
                            <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z"></path>
                            <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM8.5 6.5V8H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V9H6a.5.5 0 0 1 0-1h1.5V6.5a.5.5 0 0 1 1 0Z"></path>
                        </svg>
                    </button>
                </div>
                <div class="col-md-10">
                    <p style="margin-top: 1%; margin-bottom: 2%; margin-left: 0%; font-weight: bold; color: #157347;">"Agregar más al Expediente"</p>
                </div>
            </div>
            <div class="panel-body">
                <form method="post" action="expediente_inmuebles.php?id=<?php echo (int)$inmueble['id_bien_inmueble']; ?>" enctype="multipart/form-data">
                    <div style="margin-bottom: 1%; margin-top: -3%">
                        <span class="material-symbols-rounded" style="margin-top: 2%; color: #3a3d44;">apartment</span>
                        <p style="font-size: 15px; font-weight: bold; margin-top: -23px; margin-left: 4%">EXPEDIENTE GENERAL DEL INMUEBLE</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_documento">Nombre del Documento</label>
                                <input type="text" class="form-control" name="nombre_documento[]" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="documento">Documento</label>
                                <input type="file" class="form-control" name="documento[]" id="documento[]" required>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="newRow" style="margin-top: 3%;">
                    </div>
                    <div class="form-group clearfix">
                        <a href="bienes_inmuebles.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                            Regresar
                        </a>
                        <?php if ($nivel_user == 1 || $nivel_user == 28): ?>
                            <button type="submit" name="expediente_inmuebles" class="btn btn-info">Agregar</button>
                        <?php endif; ?>
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
                    <th class="text-center" style="width: 45%; font-size: 14px;">Nombre Documento</th>
                    <th class="text-center" style="width: 45%; font-size: 14px;">Documento</th>
                    <?php if ($nivel_user == 1 || $nivel_user == 28): ?>
                        <th class="text-center" style="width: 10%; font-size: 14px;">Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($e_detalle ?? [] as $detalle) :
                    $carpeta = 'uploads/inmuebles/' . $folio_carpeta;
                ?>
                    <tr>
                        <td style="font-size: 14px;"><?php echo $detalle['nombre_documento'] ?></td>
                        <td style="font-size: 14px;">
                            <a target="_blank" href="<?php echo $carpeta ?>/<?php echo $detalle['documento'] ?>">
                                <?php echo $detalle['documento'] ?>
                            </a>
                        </td>
                        <?php if ($nivel_user == 1 || $nivel_user == 28): ?>
                            <td style="font-size: 14px;" class="text-center">
                                <a href="edit_expediente_inmuebles.php?id=<?php echo (int)$detalle['id_rel_expedientes_inmuebles']; ?>&idbi=<?php echo $id_inmueble; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip" style="height: 30px; width: 30px;"><span class="material-symbols-rounded" style="font-size: 18px; color: black; margin-top: 1px; margin-left: -3px;">edit</span>
                                </a>
                                <a href="delete_expediente_inmuebles.php?id=<?php echo (int)$detalle['id_rel_expedientes_inmuebles']; ?>&idbi=<?php echo $id_inmueble; ?>" class=" btn btn-dark btn-md" title="Eliminar" data-toggle="tooltip" style="height: 30px; width: 30px;"><span class="material-symbols-rounded" style="font-size: 22px; color: white; margin-top: -1.5px; margin-left: -5px;">delete</span>
                                </a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>