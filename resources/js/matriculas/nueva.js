import Vue from 'vue';
var matricula = new Vue({
    el: '#nueva',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/matriculas',
        alumno_id: $("#alumno_id").val(),
        matricula_id: $("#matricula_id").val(),
        alumno: [],
        matricula: [],
        apoderados: [],
        secciones:[],
        instituciones_educativas:[]
    },
    methods: {
        obtenerDatosAlumno:function(){
            let url = this.url_principal +'/alumnos/obtener_datos_alumno';
            let data={
                'alumno_id':this.alumno_id,
            }
            axios.post(url,data).then((response) => {
                this.alumno = response.data;
            }).catch((error) => {
            }).finally((response) => {
                this.obtenerApoderados();
                this.obtenerInstituciones();
            });
        },
        obtenerModeloMatricula:function(){
            let url = this.baseUrl +'/obtener_modelo/'+this.matricula_id;
            axios.get(url).then((response) => {
                this.matricula = response.data;
            }).catch((error) => {
            }).finally((response) => {
                if(this.matricula.nivel!=''&&this.matricula.grado!=''){
                    this.obtenerSecciones();
                }
            });
        },
        buscarAlumnoPorDNI:function(){
            if (this.alumno.dni.length ==8) {
                let url = this.url_principal +'/alumnos/buscar_por_dni';
                let data={
                    'alumno_dni':this.alumno.dni,
                }
                axios.post(url,data).then((response) => {
                    this.alumno = response.data;
                    this.alumno_id = this.alumno.id;
                }).catch((error) => {
                }).finally((response) => {
                    this.obtenerApoderados();
                });
            }
        },
        obtenerApoderados:function(){
            if (this.alumno_id!=0) {
                let url = this.url_principal +'/apoderados/obtener_por_alumno';
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
            let url = this.url_principal +'/vacantes/obtener_por_nivel_grado_anio_actual';
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
            let url = this.url_principal +'/ie_procedencia/obtener_instituciones';
            axios.get(url).then((response) => {
                this.instituciones_educativas = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        guardar:function(){
            this.matricula.alumno_id = this.alumno_id;
            console.log(this.matricula);
            let url = this.baseUrl +'/guardar';
            let data = {
                matricula:this.matricula
            }
            axios.post(url,data).then((response) => {
                location.href = this.url_principal + '/cronograma/'+response.data;
            }).catch((error) => {
            }).finally(() => {
            });
        }
    },
    created: function(){
        this.obtenerDatosAlumno();
        this.obtenerModeloMatricula();
    }
});

$("#buscar_alumno").keyup(function(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if(code == 13){
        matricula.buscarAlumnoPorDNI();
    }
});
