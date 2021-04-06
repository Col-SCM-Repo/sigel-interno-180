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
        matriculas:[]
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
