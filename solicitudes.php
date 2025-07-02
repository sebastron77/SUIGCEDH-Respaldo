<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Áreas';
require_once('includes/load.php');
$user = current_user();
$id_usuario = $user['id_user'];

$busca_area = area_usuario($id_usuario);
$otro = $busca_area['nivel_grupo'];
$nivel = $user['user_level'];

page_require_level(53);
$c_user = count_by_id('users', 'id_user');
$c_trabajadores = count_by_id('detalles_usuario', 'id_det_usuario');
$c_areas = count_by_id('area', 'id_area');
$c_cargos = count_by_id('cargos', 'id_cargos');
?>

<?php include_once('layouts/header.php'); ?>

<!-- <h1 style="color:#3A3D44; text-align: center; font-size: 35px; margin-bottom: 2%;">ÁREAS DE LA CEDH</h1> -->

<div class="row">
	<div class="col-md-12">
		<?php echo display_msg($msg); ?>
	</div>
</div>
<div class="container-fluid">
	<div class="full-box tile-container">


		<div class="organigrama">
			<h1 class="titulo-organigrama">ÁREAS DE LA CEDH</h1>
			<!-- Nivel 1: Consejo -->
			<div class="nivel">
				<div class="nodo">
					<a href="<?php if (($otro <= 3) || ($otro == 7) || ($otro == 21) || ($otro == 53)) echo 'solicitudes_consejo.php'; ?>">
						<div class="icono material-symbols-rounded">groups_2</div>
						Consejo
					</a>
				</div>
			</div>
			<div class="conector-vertical" style="margin-top: -1%;"></div>
			<div class="nivel">
				<div class="nodo" style="margin-top: 5%;">
					<a href="<?php if (($otro <= 1) || ($otro == 16) ) echo 'solicitudes_contraloria.php'; ?>">
						<div class="icono material-symbols-rounded">conditions</div>
						Órgano Interno de Control
					</a>
				</div>
			</div>
			<div class="conector-vertical" style="margin-top: -1%;"></div>
			<!-- Nivel 2: Presidencia -->
			<div class="nivel">
				<div class="nodo" style="margin-top: 5%;">
					<a href="<?php if (($otro <= 2) || ($otro == 7) || ($otro == 52) || ($otro == 53)) echo 'solicitudes_presidencia.php'; ?>">
						<div class="icono material-symbols-rounded">person</div>
						Presidencia
					</a>
				</div>
			</div>
			<div class="conector-vertical" style="margin-top: -1.4%;"></div>
			<div class="linea-hijos-presidencia" style="margin-top: 0%;"></div>
			<!-- Nivel 3 -->
			<div class="nivel" style="margin-top: -1.3%;">
				<!-- Secretaría Ejecutiva -->
				<div class="nodo">
					<a href="<?php if (($otro == 7) || ($otro <= 2) || ($otro == 3) || ($otro == 53)) echo 'solicitudes_ejecutiva.php'; ?>">
						<div class="icono material-symbols-rounded">next_week</div>
						Secretaría Ejecutiva
					</a>
				</div>
				<!-- Secretaría Técnica + submódulos -->
				<div class="nodo-con-sub" style="margin-left: -202px;">
					<div class="nodo">
						<a href="<?php if (($otro == 7) || ($otro <= 2) || ($otro == 21) || ($otro == 51) || ($otro == 53)) echo 'solicitudes_tecnica.php'; ?>">
							<div class="icono material-symbols-rounded">account_box</div>
							Secretaría Técnica
						</a>
					</div>
					<div class="conector-vertical" style="height: 30px; margin-top: 2.3%;"></div>
					<div class="subnivel horizontal" style="margin-top: -0.5%;">
						<div class="linea-horizontal"></div>
						<div class="nodo">
							<a href="<?php if (($otro <= 2) || ($otro == 7) || ($otro == 12) || ($otro == 53)) echo 'solicitudes_desaparecidos.php'; ?>">
								<div class="icono material-symbols-rounded">person_search</div>
								Desaparecidos
							</a>
						</div>
						<div class="nodo">
							<a href="<?php if (($otro <= 2) || ($otro == 7) || ($otro == 10) || ($otro == 53)) echo 'solicitudes_transparencia.php'; ?>">
								<div class="icono material-symbols-rounded">travel_explore</div>
								Transparencia
							</a>
						</div>
						<div class="nodo">
							<a href="<?php if (($otro <= 2) || ($otro == 7) || ($otro == 11) || ($otro == 53)) echo 'solicitudes_archivo.php'; ?>">
								<div class="icono material-symbols-rounded">inventory_2</div>
								Archivo
							</a>
						</div>
						<div class="nodo">
							<a href="<?php if (($otro <= 2) || ($otro == 4) || ($otro == 7) || ($otro == 9) || ($otro == 22) || ($otro == 37) || ($otro == 53)) echo 'solicitudes_servicios_tecnicos.php'; ?>">
								<div class="icono material-symbols-rounded">procedure</div>
								Servicios Técnicos
							</a>
						</div>
					</div>
				</div>

				<!-- Otros nodos -->
				<div class="nodo" style="margin-left: -202px;">
					<a href="<?php if (($otro == 5) || ($otro <= 2) || ($otro == 7) || ($otro == 19) || ($otro == 20) || ($otro == 21) || ($otro == 25) || ($otro == 26) || ($otro == 50) || ($otro == 53)) echo 'solicitudes_quejas.php'; ?>">
						<div class="icono material-symbols-rounded">book</div>
						Quejas y Seguimiento
					</a>
				</div>
				<div class="nodo">
					<a href="<?php if (($otro <= 2) || ($otro == 7) || ($otro == 17) || ($otro == 36) || ($otro == 53)) echo 'solicitudes_agendas.php'; ?>">
						<div class="icono material-symbols-rounded">calendar_view_month</div>
						Mecanismos y Agendas
					</a>
				</div>
				<div class="nodo">
					<a href="<?php if (($otro <= 2) || ($otro == 7) ||($otro == 14) ||($otro == 27) ||($otro == 28) ||($otro == 29) ||($otro == 35)) echo 'solicitudes_gestion.php'; ?>">
						<div class="icono material-symbols-rounded">rebase_edit</div>
						Coord. Administrativa
					</a>
				</div>

				<!-- Centro de Estudios + submódulos -->
				<div class="nodo-con-sub" style="margin-left: -68px;">
					<div class="nodo">
						<a href="<?php if (($otro <= 2) || ($otro == 6) || ($otro == 7) || ($otro == 53)) echo 'solicitudes_centro_estudios.php'; ?>">
							<div class="icono material-symbols-rounded">local_library</div>
							Centro de Estudios
						</a>
					</div>
					<div class="conector-vertical" style="height: 30px; margin-top: 5%;"></div>
					<div class="subnivel horizontal" style="margin-top: -1.2%;">
						<div class="linea-horizontal"></div>
						<div class="nodo">
							<a href="<?php if (($otro <= 2) || ($otro == 6) || ($otro == 7) || ($otro == 23) || ($otro == 53)) echo 'solicitudes_equidad.php'; ?>">
								<div class="icono material-symbols-rounded">diversity_2</div>
								Equidad de Género
							</a>
						</div>
						<div class="nodo">
							<a href="<?php if (($otro <= 2) || ($otro == 6) || ($otro == 7) || ($otro == 24) || ($otro == 53)) echo 'solicitudes_grupo.php'; ?>">
								<div class="icono material-symbols-rounded">groups_3</div>
								Grupos Vulnerables
							</a>
						</div>
					</div>
				</div>

				<div class="nodo" style="margin-left: -68px;">
					<a href="<?php if (($otro <= 2) || ($otro == 7) || ($otro == 15) || ($otro == 53)) echo 'solicitudes_comunicacion_social.php'; ?>">
						<div class="icono material-symbols-rounded">contact_mail</div>
						Comunicación Social
					</a>
				</div>
				<div class="nodo">
					<a href="<?php if (($otro <= 2) || ($otro == 7) || ($otro == 13) || ($otro == 53)) echo 'solicitudes_sistemas.php'; ?>">
						<div class="icono material-symbols-rounded">touchpad_mouse</div>
						Coordinación Sistemas
					</a>
				</div>
				<div class="nodo">
					<a href="<?php if (($otro <= 2) || ($otro == 18) || ($otro == 52) || ($id_usuario == 42)) echo 'oficialia_correspondencia.php'; ?>">
						<div class="icono material-symbols-rounded">outgoing_mail</div>
						Oficios-Oficialía
					</a>
				</div>
			</div>
		</div>

	</div>
</div>
<br>
<br>
<br>

</span>
<?php include_once('layouts/footer.php'); ?>