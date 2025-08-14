<?php
require_once('includes/load.php');

// Función para eliminar una carpeta con todo su contenido
function eliminarCarpeta($carpeta) {
    if (!is_dir($carpeta)) return;

    $archivos = scandir($carpeta);
    foreach ($archivos as $archivo) {
        if ($archivo != '.' && $archivo != '..') {
            $ruta_completa = $carpeta . '/' . $archivo;
            if (is_file($ruta_completa)) {
                unlink($ruta_completa);
            } elseif (is_dir($ruta_completa)) {
                eliminarCarpeta($ruta_completa); // Para cuando hay subcarpetas
            }
        }
    }
    rmdir($carpeta);
}

$id_rel_resguardos_inv = $db->escape($_GET['id']);
$id3 = $db->escape($_GET['id3']);
$user = current_user();

$e_resguardo = find_by_id('rel_resguardos_inv', (int)$id_rel_resguardos_inv, 'id_rel_resguardos_inv');

if (!$e_resguardo) {
    $session->msg('d', "No se encontró el resguardo.");
    redirect('resguardos_inventario.php', false);
}

$folio_editar = $e_resguardo['folio'];
$resultado = str_replace("/", "-", $folio_editar);
$carpeta = 'uploads/resguardos/' . $resultado;
$ruta_archivo = $carpeta . '/' . $e_resguardo['archivo_resguardos'];

if (file_exists($ruta_archivo)) {
    unlink($ruta_archivo);
}

// Elimina la carpeta con todos los archivos que contenga
eliminarCarpeta($carpeta);

$sql = "DELETE FROM rel_resguardos_inv WHERE id_rel_resguardos_inv = " . $id_rel_resguardos_inv;
$result = $db->query($sql);

if ($result && $db->affected_rows() === 1) {
    insertAccion($user['id_user'], '"' . $user['username'] . '" eliminó el resguardo con ID: ' . $id_rel_resguardos_inv, 1);
    $session->msg('s', "Resguardo eliminado con éxito.");
    redirect('resguardos_inventario.php', false);
} else {
    $session->msg('d', "No se pudo eliminar el resguardo.");
    redirect('resguardos_inventario.php', false);
}
