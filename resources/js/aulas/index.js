import Vue from 'vue';
var pagos = new Vue({
    el: '#aulas',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/aulas',
        anios: [],
        anio_id: '',
        aulas: [],
        aula_id: '',
        alumnos:[]
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
        obtenerAulas:function(){
            this.aula_id='';
            if(this.anio_id!=''){
                let url = this.baseUrl +'/obtener_aulas';
                let data ={
                    'anio_id': this.anio_id
                };
                axios.post(url, data).then((response) => {
                    this.aulas = response.data;
                    console.log(this.aulas);
                }).catch((error) => {
                }).finally((response) => {
                });
            }else{
                this.aulas = [];
            }
        },
        obtenerAlumnos:function(){
            console.log(this.aula_id);
            if (this.aula_id!='') {
                let url = this.url_principal +'/alumnos/obtener_alumnos_por_aula';
                let data ={
                    'aula_id': this.aula_id
                };
                axios.post(url,data).then((response) => {
                    this.alumnos = response.data;
                    console.log(this.alumnos);
                }).catch((error) => {
                }).finally((response) => {
                });
            } else {
                this.alumnos = [];
            }
        },
    },
    created: function(){
        this.obtenerAnios();
        $('#matriculas-nav').addClass('active');
    }
});
