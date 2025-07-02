<?php
require_once('includes/load.php');
if (isset($_GET['id'])) {
    $user = current_user();
	$nivel_user = $user['user_level'];
	$id_rel_expediente_inm = $_GET['id'];
	$id_inmueble = $_GET['idbi'];
	$expediente_inmueble = find_by_id('rel_expedientes_inmuebles', (int)$_GET['id'], 'id_rel_expedientes_inmuebles');
	$documento = $expediente_inmueble['documento'];	
    $bien_inmueble = find_by_id('bienes_inmuebles', $id_inmueble, 'id_bien_inmueble');	
    $resultado = str_replace("/", "-", $bien_inmueble['folio']);
	$filepath = 'uploads/inmuebles/' . $resultado . "/" . $documento;


	if ($documento != '') {
		// Verifica si el archivo existe
		if (file_exists($filepath)) {
			// Intenta eliminar el archivo
			if (unlink($filepath)) {
				echo "El archivo se ha sido eliminado exitosamente.";
				$delete_id = delete_by_id('rel_expedientes_inmuebles', (int)$id_rel_expediente_inm, 'id_rel_expedientes_inmuebles');
				if ($delete_id) {
					$session->msg("s", "Archivo eliminado correctamente.");
					insertAccion($user['id_user'], '"' . $user['username'] . '" eliminó ' . $expediente_inmueble['nombre_documento'] . ', del inmueble con Folio: ' . $bien_inmueble['folio'] . '.', 3);
					redirect('expediente_inmuebles.php?id=' . $bien_inmueble['id_bien_inmueble'], false);
				} else {
					$session->msg("d", "La eliminación falló.");
					redirect('expediente_inmuebles.php?id=' . $bien_inmueble['id_bien_inmueble'], false);
				}
			} else {
				echo "No se pudo eliminar el archivo.";
				redirect('expediente_inmuebles.php?id=' . $bien_inmueble['id_bien_inmueble'], false);
			}
		} else {
			echo "El archivo no existe.";
			redirect('expediente_inmuebles.php?id=' . $bien_inmueble['id_bien_inmueble'], false);
		}
	}
} else {
	echo "No se especificó ningún archivo.";
	redirect($ur_origen, false);
}
