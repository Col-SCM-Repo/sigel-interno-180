import Vue from 'vue';
var pagos = new Vue({
    el: '#alumnos',
    data: {
        anios: [],
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'alumnos',
        alumnos:[],
        buscar_string:'',
        alumno_seleccionado:[],
        matriculas:[],
        matricula_seleccionada:[],
        conceptos:[],
        pago_model:[],
        anio_actual:[],
        monto_pago:'',
        observacion_pago:'',
        concepto_pago_id:'',
        puede_matricularse:true,
        serie_usuario: $("#serie_usuario").val(),

    },
    methods: {
        obtenerAlumnos:function(){
            if(this.buscar_string!=''){
                let url = this.baseUrl +'/obtener_alumnos';
                let data={
                    'cadena':this.buscar_string,
                }
                axios.post(url,data).then((response) => {
                    this.alumnos = response.data;
                }).catch((error) => {
                }).finally((response) => {
                });
            }
        },
        abrirModalMatriculas:function(alumno){
            $('#exampleModal').modal({backdrop: 'static', keyboard: false});
            $('#exampleModal').modal('show');
            this.alumno_seleccionado = alumno;
            this.verMatriculas();
        },
        verMatriculas:function(){
            this.puede_matricularse = true;
            let url = this.url_principal +'matriculas/obtener_matriculas_por_alumno';
            let data={
                'alumno_id':this.alumno_seleccionado.id,
            }
            axios.post(url,data).then((response) => {
                this.matriculas = response.data;
                this.matriculas.forEach(matricula => {
                    if(matricula.puede_retirarse){
                        this.puede_matricularse = false;
                    }
                });
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        verCronograma:function(matricula_id){
            location.href=this.url_principal+'cronograma/'+matricula_id;
        },
        cerrarModalMatricula:function(){
            $('#exampleModal').modal('hide');
            this.alumno_seleccionado = [];
            this.matriculas = [];
        },
        editarAlumno:function(alumno_id){
            location.href=this.baseUrl+'/editar/'+alumno_id;
        },
        abrirModalOtrosPagos:function(matricula){
            $('#otrosPagosModal').modal({backdrop: 'static', keyboard: false});
            $('#otrosPagosModal').modal('show');
            this.matricula_seleccionada = matricula;
            this.obtenerConceptosAnioActual();
        },
        cerrarModalOtrosPagos:function(){
            $('#otrosPagosModal').modal('hide');
            this.matricula_seleccionada = [];
            this.anio_actual=[]
            this.pago_model=[]
            this.conceptos=[]
        },
        obtenerConceptosAnioActual:function(){
            this.conceptos = [];
            let url = this.url_principal +'conceptos/obtener_conceptos_anio_actual';
            axios.get(url).then((response) => {
                this.anio_actual=response.data.anio;
                this.pago_model=response.data.pagoModel;
                this.conceptos=response.data.conceptos;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        asignarMonto:function(){
            this.pago_model.monto = $('#conceptos option:selected')[0].attributes['monto'].value;
        },
        guardarPago:function(){
            if (this.pago_model.concepto_pago_id!='') {
                this.pago_model.matricula_id = this.matricula_seleccionada.id;
                let url = this.url_principal +'pagos/guardar_pago';
                let data = {
                    'pago': this.pago_model
                };
                axios.post(url,data).then((response) => {
                    window.open(this.url_principal+'reportes/boleta/'+response.data)
                }).catch((error) => {
                }).finally((response) => {
                    this.cerrarModalOtrosPagos();
                });
            }
        },
        editarMatricula:function(matricula_id){
            window.open(this.url_principal+'matriculas/nueva/'+this.alumno_seleccionado.id+'/'+matricula_id)
        },
        generarCarnetAlumno: function(matricula_id){
            window.open(this.url_principal+'reportes/carnet_alumno/'+matricula_id);
        },
        retirarAlumno:function(matricula){
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
                        matricula.fecha_fin = fecha_fin;
                        cargando('show');
                        let url = this.url_principal +'matriculas/guardar';
                        matricula.estado = 4;
                        let data = {
                            matricula:matricula
                        }
                        axios.post(url,data).then((response) => {
                            showToastr('Correcto','Se retiró al alumno.', 'success');
                            this.verCronograma(matricula.id);
                        }).catch((error) => {
                            showToastr('Error','Ocurrio un error inesperado.', 'error');
                        }).finally(() => {
                            cargando('hide');
                        });
                    }else{
                        showToastr('AVISO','No seleccionó fecha de retiro.', 'warning');
                    }
                } else if (result.isDenied) {
                    return;
                }
            })

        },
        matricularAlumno:function(alumno_id){
            location.href=this.url_principal+'matriculas/nueva/'+alumno_id+'/0';
        },

    },
    created: function(){
        $('#alumnos-nav').addClass('active');
    }
});

$("#buscar").keyup(function(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if(code==13){
        pagos.obtenerAlumnos();
    }
});
