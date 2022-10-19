<?php

use Carbon\Exceptions\NotACarbonClassException;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('probandoooooooo ', function () {
    return 'all';
});

Auth::routes(['register' => false]);
//principal
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@Dashboard')->name('dashboard');
//Routes pagos
Route::prefix('alumnos')->middleware('auth', 'accesos_control')->group(function () {
    #pagos
    Route::get('/', ['uses' => 'AlumnosController@index', 'as' => 'index.alumnos']);
    Route::post('/obtener_alumnos', ['uses' => 'AlumnosController@ObtenerAlumnos', 'as' => 'obtener.alumnos']);
    #editar
    Route::get('/editar/{alumno_id}', ['uses' => 'AlumnosController@Editar', 'as' => 'editar.alumno.alumnos']);
    Route::post('/obtener_datos', ['uses' => 'AlumnosController@ObtenerDatos', 'as' => 'obtener.datos.alumnos']);
    Route::post('/guardar', ['uses' => 'AlumnosController@Guardar', 'as' => 'guardar.alumnos']);
    Route::post('/guardar_imagen', ['uses' => 'AlumnosController@GuardarImagen', 'as' => 'guardar.imagen.alumnos']);
    #
    Route::post('/buscar_por_dni', ['uses' => 'AlumnosController@ObtenerAlumnoPorDNI', 'as' => 'buscar.alumno.por.dni.alumnos']);
    #morosos
    Route::get('/deudores', ['uses' => 'AlumnosController@VistaMorosos', 'as' => 'vista.morosos.alumnos']);
});
//Routes Matriculas
Route::prefix('matriculas')->middleware('auth', 'accesos_control')->group(function () {
    Route::post('/obtener_matriculas_por_alumno', ['uses' => 'MatriculasController@ObtenerMatriculasPorAlumno', 'as' => 'obtener.alumnos.matriculas']);
    #nueva
    Route::get('/nueva/{alumno_id}/{matricula_id}', ['uses' => 'MatriculasController@NuevaVista', 'as' => 'nueva.matriculas']);
    Route::post('/obtener_modelos', ['uses' => 'MatriculasController@ObtenerModelos', 'as' => 'modelo.matriculas']);
    Route::post('/guardar', ['uses' => 'MatriculasController@Guardar', 'as' => 'guardar.matriculas']);
    #
    Route::post('/obtener_por_aula', ['uses' => 'MatriculasController@ObtenerMatriculasPorAula', 'as' => 'obtener.por.aula.matriculas']);

});
//Routes pagos
Route::prefix('pagos')->middleware('auth', 'accesos_control')->group(function () {
    Route::get('/obtener_modelo/{cronograma_id}', ['uses' => 'PagosController@ObtenerModelo', 'as' => 'obtener.modelo.pagos']);
    #pagos
    Route::post('/obtener_pagos', ['uses' => 'PagosController@ObtenerPagosPorCronogramaId', 'as' => 'obtener.por.cronograma.pagos']);
    Route::post('/guardar_pago', ['uses' => 'PagosController@GuardarPago', 'as' => 'guardar.pago.pagos']);
    Route::post('/guardar_nota_credito', ['uses' => 'PagosController@GuardarNotaCredito', 'as' => 'guardar.nota.credito.pagos']);
    Route::post('/otros_pagos_por_matricula', ['uses' => 'PagosController@PagosPorOtrosConceptosPorMatriula', 'as' => 'pagos.por.otrosconcepto.por.matricula.pagos']);
    #pagos del dia
    Route::get('/por_fecha', ['uses' => 'PagosController@PagosPorFechaUsuarioActual', 'as' => 'pagos.por.fecha.usuario.actual.pagos']);
    Route::post('/obtener_pago_por_fecha_usuario_actual', ['uses' => 'PagosController@ObtenerPagosPorFechaUsuarioActual', 'as' => 'obtener.pagos.del.dia.pagos']);
    #Alumnos Morosos
    Route::post('/obtener_alumnos_morosos', ['uses' => 'PagosController@ObtenerAlumnosMorosos', 'as' => 'obtener.alumnos.morosos.pagos']);
    #pagos entre fechas
    Route::get('/pagos_entre_fechas', ['uses' => 'PagosController@PagosEntreFechasView', 'as' => 'vista.pagos.entre.fechas.pagos']);
    Route::post('/obtener_entre_fechas', ['uses' => 'PagosController@ObtenerPagosEntreFechas', 'as' => 'obtener.pagos.entre.fechas.pagos']);
    Route::post('/validar_pago', ['uses' => 'PagosController@ValidarPago', 'as' => 'validar.pago.pagos']);
});
//Routes Cronograma Pagos
Route::prefix('cronograma')->middleware('auth', 'accesos_control')->group(function () {
    #Dashboard
    Route::get('/{matricula_id}', ['uses' => 'CronogramaController@Index', 'as' => 'index.cronograma']);
    Route::post('/obtener_cronogramas_matricula', ['uses' => 'CronogramaController@ObtenerCronogramasPorMatricula', 'as' => 'obtener.por.matricula.cronograma']);
    Route::post('/actualizar_monto', ['uses' => 'CronogramaController@ActualizarMonto', 'as' => 'actualizar.monto.cronograma']);
});

//Routes anios
Route::prefix('anios')->middleware('auth', 'accesos_control')->group(function () {
    Route::get('/obtener_anios', ['uses' => 'AnioAcademicoController@ObtenerAnios', 'as' => 'obtener.anios']);
    Route::get('/', ['uses' => 'AnioAcademicoController@IndexVista', 'as' => 'index.vista.anios']);
    Route::get('/obtener_modelo', ['uses' => 'AnioAcademicoController@ObtenerViewModel', 'as' => 'view.model.anios']);
    Route::post('/guardar', ['uses' => 'AnioAcademicoController@Guardar', 'as' => 'guardar.anios']);
    Route::put('/guardar', ['uses' => 'AnioAcademicoController@Guardar', 'as' => 'guardar.anios']);
});
//Routes reportes
Route::prefix('reportes')->middleware('auth', 'accesos_control')->group(function () {
    Route::get('/boleta/{pago_id}', ['uses' => 'ReportesController@VerBoleta', 'as' => 'boleta.reportes']);
    Route::post('/descargar_matriculas_por_aula', ['uses' => 'ReportesController@DescargarMatriculasPorAula', 'as' => 'descargar.lista.matriculas.por.aula.reportes']);
    Route::post('/descargar_resumen', ['uses' => 'ReportesController@DescargarResumen', 'as' => 'obtener.pagos.del.dia.pagos.reprtes']);
    Route::post('/descargar_pagos_entre_fechas', ['uses' => 'ReportesController@DescargarPagosEntreFechas', 'as' => 'obtener.pagos.del.dia.pagos']);
    Route::get('/descargar_ficha_matricula/{matricula_id}', ['uses' => 'ReportesController@DescargarFichaMatricula', 'as' => 'ficha.matricula.reportes']);
    Route::get('/descargar_cronograma/{matricula_id}', ['uses' => 'ReportesController@DescargarCronograma', 'as' => 'cronograma.reportes']);
    Route::post('/descargar_lista_secciones', ['uses' => 'ReportesController@DescargarListaSecciones', 'as' => 'descargar.lista.secciones.reprtes']);
    Route::post('/descargar_lista_alumno_morosos_pdf', ['uses' => 'ReportesController@DescargarListaAlumnosMorososPDF', 'as' => 'descargar.lista.alumnos.morosos.reprtes']);
    Route::post('/descargar_lista_alumno_morosos_excel', ['uses' => 'ReportesController@DescargarListaAlumnosMorososExcel', 'as' => 'descargar.lista.alumnos.morosos.reprtes']);
    Route::post('/descargar_pagos_entre_fechas_pdf', ['uses' => 'ReportesController@DescargarPagosEntreFechasPDF', 'as' => 'descargar.pagos.entre.fechas.pdf.reprtes']);
    Route::post('/descargar_pagos_entre_fechas_excel', ['uses' => 'ReportesController@DescargarPagosEntreFechasExcel', 'as' => 'descargar.pagos.entre.fechas.excel.reprtes']);
    #carnets
    Route::get('/carnet_alumno/{alumno_id}', ['uses' => 'ReportesController@GenerarCarnetAlumno', 'as' => 'carnet.alumno.reportes']);
    Route::get('/carnets_aula/{vacante_id}', ['uses' => 'ReportesController@GenerarCarnetAula', 'as' => 'carnets.aula.reportes']);

});
//Routes anios
Route::prefix('paises')->middleware('auth', 'accesos_control')->group(function () {
    #Dashboard
    Route::get('/obtener_paises', ['uses' => 'PaisesController@ObtenerPaises', 'as' => 'obtener.paises']);
    Route::get('/modelo', ['uses' => 'PaisesController@ObtenerModelo', 'as' => 'obtener.modelo.paises']);
    Route::post('/guardar', ['uses' => 'PaisesController@Guardar', 'as' => 'guardar.paises']);
});
Route::prefix('distritos')->middleware('auth', 'accesos_control')->group(function () {
    #Dashboard
    Route::get('/obtener_distritos', ['uses' => 'DistritosController@ObtenerDistritos', 'as' => 'obtener.distritos']);
    Route::get('/modelo', ['uses' => 'DistritosController@ObtenerModelo', 'as' => 'obtener.modelo.distritos']);
    Route::post('/guardar', ['uses' => 'DistritosController@Guardar', 'as' => 'guardar.distritos']);
});
Route::prefix('apoderados')->middleware('auth', 'accesos_control')->group(function () {
    #Dashboard
    Route::post('/obtener_por_alumno', ['uses' => 'ApoderadosController@ObtenerPorAlumno', 'as' => 'obtener.por.alumno.apoderados']);
    Route::get('/modelo', ['uses' => 'ApoderadosController@ModeloApoderado', 'as' => 'modelo.apoderados']);
    Route::post('/guardar', ['uses' => 'ApoderadosController@GuardarApoderado', 'as' => 'guardar.apoderados']);
});
Route::prefix('vacantes')->middleware('auth', 'accesos_control')->group(function () {
    Route::get('/por_anio', ['uses' => 'VacantesController@PorAnio', 'as' => 'por.anio.vacantes']);
    Route::post('/obtener_aulas', ['uses' => 'VacantesController@ObtenerAulasPorAnio', 'as' => 'obtener.aulas.anios.aula']);
    #
    Route::post('/obtener_por_anio_nivel_grado', ['uses' => 'VacantesController@ObtenerPorNivelGradoAnio', 'as' => 'obtener.por.anio.nivel.grado.vacantes']);
    #
    Route::get('/total_alumno_anio_nivel_view', ['uses' => 'VacantesController@VistaReportePorAnioNivel', 'as' => 'vista.total.alumno.anio.nivel.vacantes']);
    Route::post('/cant_alumno_nivel_anio', ['uses' => 'VacantesController@ObtenerSeccionesPorAnionivel', 'as' => 'obtener.por.nivel.anio_actual.vacantes']);
    Route::get('/obtener_modelo', ['uses' => 'VacantesController@ObtenerViewModel', 'as' => 'obtener.view.model.vacantes']);
    #guardar
    Route::post('/guardar', ['uses' => 'VacantesController@Guardar', 'as' => 'guardar.vacantes']);
    Route::put('/guardar', ['uses' => 'VacantesController@Guardar', 'as' => 'guardar.vacantes']);
});
Route::prefix('religiones')->middleware('auth', 'accesos_control')->group(function () {
    #Dashboard
    Route::get('/obtener_religiones', ['uses' => 'ReligionesController@ObtenerReligiones', 'as' => 'obtener.religiones']);
    Route::get('/modelo', ['uses' => 'ReligionesController@ObtenerModelo', 'as' => 'obtener.modelo.religiones']);
    Route::post('/guardar', ['uses' => 'ReligionesController@Guardar', 'as' => 'guardar.religiones']);
});
Route::prefix('grado_instrucion')->middleware('auth', 'accesos_control')->group(function () {
    #Dashboard
    Route::get('/obtener_grados', ['uses' => 'GradoInstruccionController@ObtenerGrados', 'as' => 'obtener.grados_instruccion']);
});
Route::prefix('centro_laboral')->middleware('auth', 'accesos_control')->group(function () {
    #Dashboard
    Route::get('/obtener_centros', ['uses' => 'CentroLaboralController@ObtenerCentros', 'as' => 'obtener.centro_laboral']);
    Route::get('/modelo', ['uses' => 'CentroLaboralController@ObtenerModelo', 'as' => 'obtener.modelo.centro_laboral']);
    Route::post('/guardar', ['uses' => 'CentroLaboralController@Guardar', 'as' => 'guardar.centro_laboral']);
});
Route::prefix('ocupacion')->middleware('auth', 'accesos_control')->group(function () {
    #Dashboard
    Route::get('/obtener_ocupaciones', ['uses' => 'OcupacionesController@ObtenerOcupaciones', 'as' => 'obtener.ocupacion']);
    Route::get('/modelo', ['uses' => 'OcupacionesController@ObtenerModelo', 'as' => 'obtener.modelo.ocupacion']);
    Route::post('/guardar', ['uses' => 'OcupacionesController@Guardar', 'as' => 'guardar.ocupacion']);
});
Route::prefix('conceptos')->middleware('auth', 'accesos_control')->group(function () {
    #Dashboard
    Route::get('/obtener_conceptos_anio_actual', ['uses' => 'ConceptosController@ObtenerConceptosDelAnioActual', 'as' => 'obtener.por.anio.actual.concepto']);
    Route::post('/obtener_conceptos_anio_nivel', ['uses' => 'ConceptosController@ObtenerConceptosPorAnioIDNivel', 'as' => 'obtener.por.anio.nivel.concepto']);
    Route::post('/obtener_conceptos_por_anio', ['uses' => 'ConceptosController@ObtenerConceptosPorAnio', 'as' => 'obtener.por.anio.concepto']);
    Route::get('/obtener_modelo', ['uses' => 'ConceptosController@ObtenerModelo', 'as' => 'obtener.modelo.concepto']);
    Route::get('/obtener_todos_conceptos', ['uses' => 'ConceptosController@ObtenerTodosConceptos', 'as' => 'obtener.todos.concepto']);
    #guardar
    Route::post('/guardar', ['uses' => 'ConceptosController@Guardar', 'as' => 'guardar.concepto']);
    Route::put('/guardar', ['uses' => 'ConceptosController@Guardar', 'as' => 'guardar.concepto']);
});
Route::prefix('ie_procedencia')->middleware('auth', 'accesos_control')->group(function () {
    #Dashboard
    Route::get('/obtener_instituciones', ['uses' => 'InstitucionEducativaController@ObtenerInstituciones', 'as' => 'obtener.ie_prodecendia']);
    Route::get('/datos', ['uses' => 'InstitucionEducativaController@ObtenerDatos', 'as' => 'datos.ie_prodecendia']);
    Route::post('/guardar', ['uses' => 'InstitucionEducativaController@Guardar', 'as' => 'guradar.ie_prodecendia']);
});
Route::prefix('carnets')->middleware('auth', 'accesos_control')->group(function () {
    #Dashboard
    Route::post('/obtener_carnets_anio', ['uses' => 'CarnetsController@ObtenerCarnetsPorAnio', 'as' => 'obtener.por.anio.carnets']);
    Route::get('/obtener_modelo', ['uses' => 'CarnetsController@ObtenerModelo', 'as' => 'obtener.modelo.carnets']);
    #guardar
    Route::post('/guardar', ['uses' => 'CarnetsController@Guardar', 'as' => 'guardar.concepto']);
    Route::put('/guardar', ['uses' => 'CarnetsController@Guardar', 'as' => 'guardar.concepto']);
    Route::post('/guardar_imagen', ['uses' => 'CarnetsController@GuardarImagen', 'as' => 'guardar.concepto']);
});
Route::prefix('usuarios')->middleware('auth', 'accesos_control')->group(function () {
    Route::get('/', ['uses' => 'UsuariosController@VistaIndex', 'as' => 'index.usuario']);
    Route::get('/obtener_usuarios', ['uses' => 'UsuariosController@ObtenerUsuarios', 'as' => 'obtener.usuarios.usuario']);
    Route::get('/obtener_modelo', ['uses' => 'UsuariosController@ObtenerViewModel', 'as' => 'obtener.modelo.usuario']);
    Route::post('/guardar', ['uses' => 'UsuariosController@Guardar', 'as' => 'guardar.usuario']);
    Route::put('/guardar', ['uses' => 'UsuariosController@Guardar', 'as' => 'guardar.usuario']);
});
Route::prefix('series')->middleware('auth', 'accesos_control')->group(function () {
    Route::get('/obtener_modelo', ['uses' => 'SeriesController@ObtenerViewModel', 'as' => 'obtener.modelo.serie']);
    Route::post('/guardar', ['uses' => 'SeriesController@Guardar', 'as' => 'guardar.serie']);
    Route::put('/guardar', ['uses' => 'SeriesController@Guardar', 'as' => 'guardar.serie']);
});
Route::prefix('modulo_notas')->middleware('auth', 'accesos_control')->group(function () {
    Route::prefix('alumnos')->group(function () {
        Route::get('/', ['uses' => 'ModuloNotasController@AlumnoIndex', 'as' => 'index.alumno.modulo_notas']);
    });
    Route::prefix('notas')->group(function () {
        Route::get('/{matricula_id}', ['uses' => 'ModuloNotasController@NotasIndex', 'as' => 'index.notas.modulo_notas']);
    });
});


Route::prefix('recursos-humanos')->middleware('auth')->group(function () {
    Route::get('/', ['uses' => 'ModuloRRHHController@index', 'as' => 'rrhh.index'])->middleware('accesos_control');

    Route::prefix('alumnos')->group(function(){
        Route::get('/', ['uses' => 'ModuloRRHHController@alumnos', 'as' => 'rrhh.alumnos']);
        
        /* Api  */
        Route::post('/', ['uses' => 'ModuloRRHHController@getDataReloj'])->name('rrhh.alumnos.data');
        
        /* Libreria PDF  */
        Route::post('/descargar/{type?}', ['uses' => 'ModuloRRHHController@descargarPDF'])->name('rrhh.alumnos.download');

    });
    Route::prefix('empleados')->middleware('accesos_control')->group(function(){
        Route::get('/', ['uses' => 'ModuloRRHHController@empleados', 'as' => 'rrnn.empleados']);
        Route::post('/informacion', ['uses' => 'ModuloRRHHController@verReporteMarcaciones', 'as' => 'rrnn.empleados.ver']);
        Route::post('/download', ['uses' => 'ModuloRRHHController@descargarReportePersonal', 'as' => 'rrnn.empleados.download']);
        
        /*Api*/
        Route::post('/{param?}', ['uses' => 'ModuloRRHHController@empleados_search', 'as' => 'rrnn.empleados.search']);

        /* Libreria PDF  */

    });
});

Route::prefix('notas')->middleware('auth')->group(function () {
    Route::post('/obtener_por_matricula_trimestre', ['uses' => 'NotaController@ObtenerNotasPorMatriculaTrimestre', 'as' => 'obtener.notas.por.matricula.trimestre.notas']);
});
Route::get('/pruebas', 'Pruebas@ObtenerUsuarios')->name('pruebas');
Route::get('/pruebas/empleados', 'EmpleadosController@ObtenerEmpleados')->name('pruebas.empelados');


/************************** TEMP **************************/
Route::get('/control-permisos', 'Pruebas@ControlPermisos')->name('pruebasControlPermisos');
Route::get('/historial-accesos', 'Pruebas@HistorialAcceso')->name('pruebasHistorialAcceso');
Route::get('/control-Backup', 'Pruebas@Backup')->name('pruebasHistorialBackup');
Route::get('/nuevo-usuario', 'Pruebas@NuevoUsuario')->name('pruebasNuevoUsuario');






