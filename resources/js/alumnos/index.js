import Vue from 'vue';
var pagos = new Vue({
    el: '#pagos',
    data: {
        anios: [],
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/alumnos',
        anio_id: '',
        alumnos:[],
        cadena:''
    },
    methods: {
        obtenerAlumnos:function(){
            if(this.anio_id !== ''){
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
        verCronograma:function(matricula_id){
            location.href=this.url_principal+'/cronograma/'+matricula_id;
        }
    },
    created: function(){

    }
});
