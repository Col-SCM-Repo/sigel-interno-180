import Vue from 'vue';
var pagos = new Vue({
    el: '#aulas',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/alumnos',
        anios: [],
        anio_id: '',
        nivel_id: '',
        secciones: [],
        alumnos: [],
        conceptos: [],
        total_monto: 0,
    },
    methods: {
        obtenerAnios:function(){
            let url = this.url_principal +'/anios/obtener_anios';
            axios.get(url).then((response) => {
                this.anios = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerSecciones:function(){
            if (this.nivel_id!='') {
                let url = this.url_principal +'/vacantes/cant_alumno_nivel_anio';
                let data ={
                    'anio_id': this.anio_id,
                    'nivel_id': this.nivel_id,
                };
                axios.post(url,data).then((response) => {
                    this.secciones = response.data;
                }).catch((error) => {
                }).finally((response) => {
                    this.obtenerConceptos();
                });
            } else {
                this.secciones = [];
            }
        },
        obtenerConceptos:function () {
            if (this.nivel_id!='') {
                let url = this.url_principal +'/conceptos/obtener_conceptos_anio_nivel';
                let data ={
                    'anio_id': this.anio_id,
                    'nivel_id': this.nivel_id,
                };
                axios.post(url,data).then((response) => {
                    this.conceptos = response.data;
                }).catch((error) => {
                }).finally((response) => {
                });
            } else {
            }
        },
        obtenerAlumnosMorosos:function () {

        },
        descargarPDF:function(){

        }
    },
    created: function(){
        this.obtenerAnios();
    }
});
