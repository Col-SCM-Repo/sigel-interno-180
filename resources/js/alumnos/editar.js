import Vue from 'vue';
var editar = new Vue({
    el: '#editar',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/alumnos',
        alumno_id:$("#alumno_id").val(),
        alumno:[],
        paises:[],
        distritos:[]
    },
    methods: {
        obtenerDatosAlumno:function(){
            let url = this.baseUrl +'/obtener_datos_alumno';
            let data={
                'alumno_id':this.alumno_id,
            }
            axios.post(url,data).then((response) => {
                this.alumno = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerPaises:function(){
            let url = this.url_principal +'/paises/obtener_paises';
            axios.get(url).then((response) => {
                this.paises = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerDistritos:function(){
            let url = this.url_principal +'/distritos/obtener_distritos';
            axios.get(url).then((response) => {
                this.distritos = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        guardar:function(){
            this.alumno.correo = this.alumno.dni+'@colegiocabrera.edu.pe';
            let url = this.baseUrl +'/guardar';
            let data = {
                'alumno':this.alumno
            };
            axios.post(url,data).then((response) => {
            }).catch((error) => {
            }).finally((response) => {
            });
        }
    },
    created: function(){
        this.obtenerDistritos();
        this.obtenerPaises();
        this.obtenerDatosAlumno()
    }
});

