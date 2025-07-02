<?php
require_once('includes/load.php');
if (isset($_GET['id'])) {
    $user = current_user();
	$nivel_user = $user['user_level'];
	$id_rel_expediente_inm = $_GET['id'];
	$id_inmueble = $_GET['idbi'];
	$anio = $_GET['anio'];
	$licencias_funcionamiento = find_by_id('rel_licencias_funcionamiento', (int)$_GET['id'], 'id_rel_licencias_funcionamiento');
	$comprobante_pago = $licencias_funcionamiento['comprobante_pago'];	
	$documento_licencia = $licencias_funcionamiento['documento_licencia'];	
    $bien_inmueble = find_by_id('bienes_inmuebles', $id_inmueble, 'id_bien_inmueble');	
    $resultado = str_replace("/", "-", $bien_inmueble['folio']);
	$filepath = 'uploads/inmuebles/' . $resultado . "/" . $anio . "/" . $comprobante_pago;
	$filepath2 = 'uploads/inmuebles/' . $resultado . "/" . $anio . "/" . $documento_licencia;


	if ($comprobante_pago != '' || $documento_licencia != '') {
		// Verifica si el archivo existe
		if (file_exists($filepath) || file_exists($filepath2)) {
			// Intenta eliminar el archivo
			if (unlink($filepath) && unlink($filepath2)) {
				echo "El registro y los archivos se han eliminado exitosamente.";
				$delete_id = delete_by_id('rel_licencias_funcionamiento', (int)$id_rel_expediente_inm, 'id_rel_licencias_funcionamiento');
				if ($delete_id) {
					$session->msg("s", "Registro y archivos eliminados correctamente.");
					insertAccion($user['id_user'], '"' . $user['username'] . '" eliminó ' . $comprobante_pago. ' y ' . $documento_licencia .', del inmueble con Folio: ' . $bien_inmueble['folio'] . '.', 3);
					redirect('licencias_funcionamiento.php?id=' . $bien_inmueble['id_bien_inmueble'], false);
				} else {
					$session->msg("d", "La eliminación falló.");
					redirect('licencias_funcionamiento.php?id=' . $bien_inmueble['id_bien_inmueble'], false);
				}
			} else {
				echo "No se pudo eliminar el archivo.";
				redirect('licencias_funcionamiento.php?id=' . $bien_inmueble['id_bien_inmueble'], false);
			}
		} else {
			echo "El archivo no existe.";
			redirect('licencias_funcionamiento.php?id=' . $bien_inmueble['id_bien_inmueble'], false);
		}
	}
} else {
	echo "No se especificó ningún archivo.";
	redirect($ur_origen, false);
}
