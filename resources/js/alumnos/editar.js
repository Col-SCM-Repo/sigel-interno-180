import Vue from 'vue';
var editar = new Vue({
    el: '#editar',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/alumnos',
        alumno_id:$("#alumno_id").val(),
        alumno:[],
        paises:[],
        distritos:[],
        religiones:[],
        familiares:[],
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
        obtenerReligiones:function(){
            let url = this.url_principal +'/religiones/obtener_religiones';
            axios.get(url).then((response) => {
                this.religiones = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerFamiliares:function(){
            let url = this.url_principal +'/apoderados/obtener_por_alumno';
            let data = {
                'alumno_id':this.alumno_id,
            };
            axios.post(url,data).then((response) => {
                this.familiares = response.data;
                console.log(this.familiares);
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        guardarAlumno:function(){
            this.alumno.correo = this.alumno.dni+'@colegiocabrera.edu.pe';
            let url = this.baseUrl +'/guardar';
            let data = {
                'alumno':this.alumno
            };
            axios.post(url,data).then((response) => {
                this.alumno_id = response.data;
            }).catch((error) => {
            }).finally((response) => {
                location.href = this.baseUrl+'/editar/'+this.alumno_id;
            });
        }
    },
    created: function(){
        this.obtenerDistritos();
        this.obtenerPaises();
        this.obtenerReligiones();
        this.obtenerDatosAlumno();
        this.obtenerFamiliares();
    }
});

