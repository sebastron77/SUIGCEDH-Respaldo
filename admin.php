<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'SUIGCEDH';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user > 2 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7 && $nivel_user < 21) :
    redirect('home.php');
endif;
if ($nivel_user == 21) :
    page_require_level_exacto(21);
endif;
?>
<?php
$year = date("Y");
$c_user = count_by_id('users', 'id_user');
$c_trabajadores = count_by_trabajadores();
//$c_trabajadores = count_by_id('detalles_usuario', 'id_det_usuario');
$c_areas = count_by_id('area', 'id_area');
$c_cargos = count_by_id('cargos', 'id_cargos');
$c_orientacion = count_by_id_orientacion('orientacion_canalizacion', 'id_or_can', $year);
$c_canalizacion = count_by_id_canalizacion('orientacion_canalizacion', 'id_or_can', $year);
$c_quejas = count_by_id_quejas('quejas_dates', 'id_queja_date', $year);
$c_actuaciones = count_by_id_anio('actuaciones', 'id_actuacion', 'folio_actuacion', $year);
$c_convenios = count_by_id_anio('convenios', 'id_convenio', 'folio_solicitud', $year);
$c_consejo = count_by_id_anio('consejo', 'id_acta_consejo', 'folio', $year);
$c_actividades = count_by_id_anio('eventos_presidencia', 'id_eventos_presidencia', 'folio', $year);
$c_colaboraciones = count_by_id_anio('colaboraciones', 'id_colaboraciones', 'folio', $year);
$c_informe = count_by_id_anio('informe_actividades_areas', 'id_info_act_areas', 'folio', $year);
$c_presupuesto = count_by_id_anio('presupuesto', 'id_presupuesto', 'folio', $year);
$c_auditorias = count_by_id('auditorias', 'id_auditorias');
$c_eventos = count_by_id_anio('eventos', 'id_evento', 'folio', $year);
$c_entregables = count_by_id('entregables', 'id_entregables');
$c_especiales = count_by_id_anio('informes_especiales', 'id_informes_especiales', 'ejercicio', $year);
$c_vehiculos = count_by_id('vehiculos', 'id_vehiculo');
$c_inmuebles = count_by_id('bienes_inmuebles', 'id_bien_inmueble');
$c_competencia = count_by_competencias($year);
$c_mediacion = count_by_mediacion($year);
$c_capacitaciones = count_by_id_anio('capacitaciones', 'id_capacitacion', 'folio', $year);
$c_colecciones_estudios = count_by_id_anio('colecciones_estudios', 'id_colecciones_estudios', 'folio', $year);
$c_cursos_diplomados = count_by_id_anio('cursos_diplomados', 'id_cursos_diplomados', 'folio', $year);
$c_recomendaciones = count_by_id('recomendaciones', 'id_recomendacion');
$c_anvs = count_by_id('acuerdos_no_violacion', 'id_acuerdos_no_violacion');
$c_comunicados = count_by_id_anio('comunicados', 'id_comunicados', 'folio', $year);;
$c_entrevistas = count_by_id_anio('entrevistas', 'id_entrevistas', 'folio', $year);
$c_solicitudes = count_by_anioSol($year);
//$c_solicitudes = count_by_id_anio('solicitudes_informacion', 'id_solicitudes_informacion','fecha_presentacion',$year);
$c_recursos = count_by_procesoUT('Recurso Revisión');
$c_denuncias = count_by_procesoUT('Denuncia');
$c_varios = count_by_id_anio('varios_quejas', 'id_varios_quejas', 'folio', $year);
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="container-fluid">
    <div class="full-box tile-container">

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="areas.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Áreas</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    cases
                </span>
                <p> <?php echo $c_areas['total']; ?> Registradas</p>
            </div>
        </a>

        <?php if ($nivel_user <= 2): ?>

            <a style="text-decoration:none;" <?php if ($nivel_user <= 2): ?> href="detalles_usuario.php" <?php endif; ?> class="tile">
                <div class="tile-tittle">Trabajadores</div>
                <div class="tile-icon">
                    <span class="material-symbols-rounded" style="font-size:55px;">
                        person
                    </span>
                    <i class="fas fa-user-tie"></i>
                    <p><?php echo $c_trabajadores['total']; ?> Activos</p>
                </div>
            </a>

            <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="users.php" <?php endif; ?> class="tile">
                <div class="tile-tittle">Usuarios</div>
                <div class="tile-icon">
                    <span class="material-symbols-rounded" style="font-size:55px;">
                        interactive_space
                    </span>
                    <i class="fas fa-user-tie"></i>
                    <p><?php echo $c_user['total']; ?> Registrados</p>
                </div>
            </a>


            <a style="text-decoration:none;" href="desp_presupuesto.php" class="tile">
                <div class="tile-tittle">Presupuesto</div>
                <div class="tile-icon">
                    <span class="material-symbols-rounded" style="font-size:55px;">
                        currency_exchange
                    </span>
                    <i class="fas fa-user-tie"></i>
                    <p><?php echo $c_presupuesto['total']; ?> Registrados</p>
                </div>
            </a>

            <a style="text-decoration:none;" href="desp_auditorias.php" class="tile">
                <div class="tile-tittle">Auditorias</div>
                <div class="tile-icon">
                    <span class="material-symbols-rounded" style="font-size:55px;">
                        rubric
                    </span>
                    <i class="fas fa-user-tie"></i>
                    <p><?php echo $c_auditorias['total']; ?> Registradas</p>
                </div>
            </a>

            <a style="text-decoration:none;" href="solicitudes_vehiculos.php" class="tile">
                <div class="tile-tittle">Parque Vehícular</div>
                <div class="tile-icon">
                    <span class="material-symbols-rounded" style="font-size:55px;">
                        garage
                    </span>
                    <i class="fas fa-user-tie"></i>
                    <p><?php echo $c_vehiculos['total']; ?> Registrados</p>
                </div>
            </a>

            <a style="text-decoration:none;" href="bienes_inmuebles.php" class="tile">
                <div class="tile-tittle">Bienes Inmuebles</div>
                <div class="tile-icon">
                    <span class="material-symbols-rounded" style="font-size:55px;">
                        apartment </span>
                    <i class="fas fa-user-tie"></i>
                    <p><?php echo $c_inmuebles['total']; ?> Registrados</p>
                </div>
            </a>



            <a style="text-decoration:none;" href="desp_amparos.php" class="tile">
                <div class="tile-tittle">Ámparo</div>
                <div class="tile-icon">
                    <span class="material-symbols-rounded" style="font-size:55px;">
                        balance
                    </span>
                    <i class="fas fa-user-tie"></i>
                    <p><?php echo $c_auditorias['total']; ?> Registradas</p>
                </div>
            </a>

        <?php endif; ?>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="quejas.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Quejas</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    record_voice_over
                </span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_quejas['total']; ?> Registradas</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="orientaciones.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Orientaciones</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">psychology_alt</span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_orientacion['total']; ?> Registradas</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="canalizaciones.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Canalizaciones</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    transfer_within_a_station
                </span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_canalizacion['total']; ?> Registradas</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="varios_quejas.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Varios</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    interests
                </span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_varios['total']; ?> Registrados</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="recomendaciones_antes.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Recomendaciones</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    auto_stories
                </span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_recomendaciones['total']; ?> Registradas</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="acuerdos_nviolacion.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Acuerdos No Violación</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    contract_delete
                </span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_anvs['total']; ?> Registradas</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="mediacion.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Mediación/Conciliación</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    diversity_3
                </span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_mediacion['total']; ?> Registradas</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="actuaciones.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Actuaciones</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    receipt_long
                </span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_actuaciones['total']; ?> Registradas</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="convenios.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Convenios</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    description
                </span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_convenios['total']; ?> Registrados</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="consejo.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Actas de consejo</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    groups_2
                </span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_consejo['total']; ?> Registrados</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="eventos_pres.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Eventos Presidencia</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    event
                </span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_actividades['total']; ?> Registrados</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="colaboraciones_ud.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Colaboraciones</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    handshake
                </span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_colaboraciones['total']; ?> Registrados</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="informes_areas.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Informe Actividades</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    task_alt
                </span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_informe['total']; ?> Registrados</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="eventos.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Eventos Áreas</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    event_available
                </span>
                <i class="fas fa-user-tie"></i>
                <p><?php echo $c_eventos['total']; ?> Registrados</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="competencia.php" <?php endif; ?> class="tile">
            <div class="tile-tittle" style="font-size: 12px;">Conflictos Competenciales</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    find_in_page
                </span>
                <i class="fas fa-user-tie"></i>
                <p> <?php echo $c_competencia['total']; ?> Registradas</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="agenda_entregables.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Entregables</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    photo_album
                </span>
                <i class="fas fa-user-tie"></i>
                <p> <?php echo $c_entregables['total']; ?> Registrados</p>
            </div>
        </a>
        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="agenda_informes.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Informes Especiales</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    folder_special
                </span>
                <i class="fas fa-user-tie"></i>
                <p> <?php echo $c_especiales['total']; ?> Registrados</p>
            </div>
        </a>


        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="capacitaciones.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Capacitaciones</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    person_raised_hand
                </span>
                <i class="fas fa-user-tie"></i>
                <p> <?php echo $c_capacitaciones['total']; ?> Registrados</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="colecciones_estudios.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Colección de Estudios</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    newsstand
                </span>
                <i class="fas fa-user-tie"></i>
                <p> <?php echo $c_colecciones_estudios['total']; ?> Registrados</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="cursos_diplomados.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Cursos/Diplomados</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    school
                </span>
                <i class="fas fa-user-tie"></i>
                <p> <?php echo $c_cursos_diplomados['total']; ?> Registrados</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="comunicados_prensa.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Comunicados Prensa</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    newspaper
                </span>
                <i class="fas fa-user-tie"></i>
                <p> <?php echo $c_comunicados['total']; ?> Registrados</p>
            </div>
        </a>


        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="entrevistas.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Entrevistas</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    frame_person_mic
                </span>
                <i class="fas fa-user-tie"></i>
                <p> <?php echo $c_entrevistas['total']; ?> Registradas</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="solicitudes_ut.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Solicitude Informacion</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    live_help
                </span>
                <i class="fas fa-user-tie"></i>
                <p> <?php echo $c_solicitudes['total']; ?> Registradas</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="recursos_ut.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Recursos Revisión</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    manage_search
                </span>
                <i class="fas fa-user-tie"></i>
                <p> <?php echo $c_recursos['total']; ?> Registradas</p>
            </div>
        </a>


        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="denuncias_ut.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Denuncias</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:55px;">
                    voice_selection
                </span>
                <i class="fas fa-user-tie"></i>
                <p> <?php echo $c_denuncias['total']; ?> Registradas</p>
            </div>
        </a>


    </div>
</div>

<?php include_once('layouts/footer.php'); ?>