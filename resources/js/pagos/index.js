import Vue from 'vue';
var asistencia = new Vue({
    el: '#pagos',
    data: {
        anios: [],
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/pagos',
        anio_id: '',
        alumnos:[],
        cadena:''
    },
    methods: {
        obtenerAnios:function () {
            let url = this.url_principal +'/anios/obtener_anios';
            axios.get(url).then((response) => {
                this.anios = response.data;
                console.log(this.anios);
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerAlumnos:function(){
            if(this.anio_id !== ''){
                let url = this.baseUrl +'/obtener_alumnos';
                let data={
                    'anio_id':this.anio_id,
                    'cadena':this.cadena,
                }
                axios.post(url,data).then((response) => {
                    this.alumnos = response.data;
                    console.log(this.alumnos);
                }).catch((error) => {
                }).finally((response) => {
                });

            }

        }
    },
    created: function(){
        this.obtenerAnios();
    }
});
