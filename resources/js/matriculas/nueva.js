import axios from 'axios';
import Vue from 'vue';
var matricula = new Vue({
    el: '#nueva',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'matriculas',
        alumno_id: $("#alumno_id").val(),
        matricula_id: $("#matricula_id").val(),
        alumno: [],
        matricula: [],
        apoderados: [],
        secciones:[],
        instituciones_educativas:[],
        validaciones:[],
        error :false,
        institucion_modelo:[],
        tipos:[],
        paises:[],
        distritos:[]
    },
    methods: {
        obtenerModeloMatricula:function(){
            let url = this.baseUrl +'/obtener_modelos';
            let data ={
                'matricula_id' : this.matricula_id,
                'alumno_id' : this.alumno_id
            }
            axios.post(url,data).then((response) => {
                this.alumno = response.data.alumno;
                this.instituciones_educativas = response.data.instituciones_educativas;
                this.apoderados = this.alumno.apoderados;
                this.matricula = response.data.matricula;
            }).catch((error) => {
            }).finally((response) => {
                if(this.matricula.nivel!=''&&this.matricula.grado!=''){
                    this.obtenerSecciones();
                }
            });
        },
        buscarAlumnoPorDNI:function(){
            if (this.alumno.dni.length ==8) {
                let url = this.url_principal +'alumnos/buscar_por_dni';
                let data={
                    'alumno_dni':this.alumno.dni,
                }
                axios.post(url,data).then((response) => {
                    if (response.data.hasOwnProperty('valor')) {
                        showToastr('AVISO',response.data.mensaje, 'warning');
                    } else {
                        this.alumno = response.data;
                        this.alumno_id = this.alumno.id;
                        showToastr('CORRECTO','ALUMNO ENCONTRADO', 'success');
                    }

                }).catch((error) => {
                }).finally((response) => {
                    this.obtenerApoderados();
                });
            }
        },
        obtenerApoderados:function(){
            if (this.alumno_id!=0) {
                let url = this.url_principal +'apoderados/obtener_por_alumno';
                let data={
                    'alumno_id':this.alumno.id,
                }
                axios.post(url,data).then((response) => {
                    this.apoderados = response.data;
                }).catch((error) => {
                }).finally((response) => {
                });
            }
        },
        obtenerSecciones:function(){
            let url = this.url_principal +'vacantes/obtener_por_anio_nivel_grado';
            let data={
                'nivel_id':this.matricula.nivel,
                'grado_id':this.matricula.grado,
            }
            axios.post(url,data).then((response) => {
                this.secciones = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerInstituciones:function(){
            let url = this.url_principal +'ie_procedencia/obtener_instituciones';
            axios.get(url).then((response) => {
                this.instituciones_educativas = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        guardar:function(){
            if (this.matricula.estado==4) {
                swal.fire({
                    title: '<strong>Retirar Alumno</strong>',
                    icon: 'warning',
                    html:
                      'El alumno se retirará con fecha <br/>, ' +
                      '<input type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="matricula-fecha_fin"> <br/>'+
                      '<b>¿Está seguro de retirar al alumno?</b>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText:
                      'Retirar',
                    cancelButtonText:
                      'Cancelar',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        let fecha_fin = $('#matricula-fecha_fin').val();
                        if (fecha_fin!='') {
                            this.matricula.fecha_fin = fecha_fin;
                            this.guardarMatricula();
                        }else{
                            showToastr('AVISO','No seleccionó fecha de retiro.', 'warning');
                        }
                    } else if (result.isDenied) {
                        return;
                    }
                })
                return
            }
            this.guardarMatricula();
        },
        guardarMatricula:function(){
            cargando('show');
            this.error = false;
            this.validaciones = [];
            this.matricula.alumno_id = this.alumno_id;
            let url = this.baseUrl +'/guardar';
            let data = {
                matricula:this.matricula
            }
            axios.post(url,data).then((response) => {
                if (typeof response.data.con_deuda !== 'undefined') {
                    Swal.fire('No puede ser matriculado porque tiene una deuda pendiente por S/ '+response.data.monto);
                }else{
                    location.href = this.url_principal + 'cronograma/'+response.data;
                }
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.validaciones = error.response.data.errors;
                    this.error = true;
                }
            }).finally(() => {
                cargando('hide');
            });
        },
        abrirAlumnoModal:function(){
            $('#alumnoModal').modal({backdrop: 'static', keyboard: false});
            $('#alumnoModal').modal('show');
        },
        abrirInsEducativaModal:function(){
            $('#insEducativaModal').modal({backdrop: 'static', keyboard: false});
            $('#insEducativaModal').modal('show');
            this.obtenerDatosInstitucionEducativa();
        },
        cerrarInsEducativaModal:function(){
            $('#insEducativaModal').modal('hide');
        },
        obtenerDatosInstitucionEducativa:function(){
            cargando('show');
            let url = this.url_principal +'ie_procedencia/datos';

            axios.get(url).then((response) => {
                this.institucion_modelo = response.data.modelo;
                this.paises = response.data.paises;
                this.tipos = response.data.tipos;
                this.distritos = response.data.distritos;
            }).catch((error) => {
            }).finally(() => {
                cargando('hide');
            });
        },
        guardarInstitucionEducativa:function(){
            cargando('show');
            let url = this.url_principal +'ie_procedencia/guardar';
            let data = {
                'institucion': this.institucion_modelo
            }
            axios.post(url,data).then((response) => {
                this.obtenerInstituciones();
                this.matricula.institucion_educativa_procedencia_id = response.data;
            }).catch((error) => {
                showToastr('Error', 'Ocurrio un error inesperado.','error')
            }).finally(() => {
                this.cerrarInsEducativaModal();
                cargando('hide');
            });
        }
    },
    created: function(){
        this.obtenerModeloMatricula();
    },
    mounted:function(){
        let self = this;
        $('#matricula_ie_procedencia')
        .select2()
        .on('select2:select', function () {
            let value = $("#matricula_ie_procedencia").select2('data');
            self.matricula.institucion_educativa_procedencia_id = value[0].id
        });
        $('#institucion_distrito')
        .select2()
        .on('select2:select', function () {
            let value = $("#institucion_distrito").select2('data');
            self.institucion_modelo.distrito_id = value[0].id
        });
    }
});

$("#buscar_alumno").keyup(function(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if(code == 13){
        matricula.buscarAlumnoPorDNI();
    }
});

$("#cerrarAlumnoModalbtn1").on('click', function(e) {
    $('#alumnoModal').modal('hide');
    matricula.obtenerApoderados();
});

$("#cerrarAlumnoModalbtn2").on('click', function(e) {
    $('#alumnoModal').modal('hide');
    matricula.obtenerApoderados();
});
