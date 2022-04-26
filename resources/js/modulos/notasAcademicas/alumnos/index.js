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
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        cerrarModalMatricula:function(){
            $('#exampleModal').modal('hide');
            this.alumno_seleccionado = [];
            this.matriculas = [];
        },
        editarAlumno:function(alumno_id){
            location.href=this.baseUrl+'/editar/'+alumno_id;
        },
        verNotas:function(matricula_id){
            location.href=this.url_principal+'modulo_notas/notas/'+matricula_id;
        }
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
