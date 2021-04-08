import Vue from 'vue';
var pagos = new Vue({
    el: '#alumnos',
    data: {
        anios: [],
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/alumnos',
        alumnos:[],
        cadena:'',
        alumno_seleccionado:[],
        matriculas:[],
        matricula_seleccionada:[],
        conceptos:[],
        monto_pago:'',
        observacion_pago:'',
        concepto_pago_id:''
    },
    methods: {
        obtenerAlumnos:function(){
            if(this.cadena!=''){
                let url = this.baseUrl +'/obtener_alumnos';
                let data={
                    'cadena':this.cadena,
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
            let url = this.url_principal +'/matriculas/obtener_matriculas_por_alumno';
            let data={
                'alumno_id':this.alumno_seleccionado.alumno_id,
            }
            axios.post(url,data).then((response) => {
                this.matriculas = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        verCronograma:function(matricula_id){
            location.href=this.url_principal+'/cronograma/'+matricula_id;
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
            this.concepto_pago_id='';
            this.observacion_pago='';
            this.monto_pago='';
        },
        obtenerConceptosAnioActual:function(){
            this.conceptos = [];
            let url = this.url_principal +'/conceptos/obtener_conceptos_anio_actual';
            axios.get(url).then((response) => {
                this.conceptos = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        asignarMonto:function(){
            this.monto_pago = $('#conceptos option:selected')[0].attributes['monto'].value
        },
        guardarPago:function(){
            if (this.concepto_pago_id!='') {
                let url = this.url_principal +'/pagos/guardar_pago';
                let data = {
                    concepto_pago_id: this.concepto_pago_id,
                    monto: this.monto_pago,
                    observacion: this.observacion_pago,
                    matricula_id: this.matricula_seleccionada.matricula_id,
                };
                axios.post(url,data).then((response) => {
                    window.open(this.url_principal+'/reportes/boleta/'+response.data)
                }).catch((error) => {
                }).finally((response) => {
                    this.cerrarModalOtrosPagos();
                });
            }
        },
        editarMatricula:function(matricula_id){
            window.open(this.url_principal+'/matriculas/nueva/'+this.alumno_seleccionado.alumno_id+'/'+matricula_id)
        }
    },
    created: function(){
        $('#alumnos-nav').addClass('active');
    }
});

$("#buscar").keyup(function(e) {
    pagos.cadena = pagos.cadena.toUpperCase();
    var code = (e.keyCode ? e.keyCode : e.which);
    if(code==13){
        pagos.obtenerAlumnos();
    }
});
