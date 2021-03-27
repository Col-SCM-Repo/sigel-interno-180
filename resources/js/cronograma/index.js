import Vue from 'vue';
var cronograma = new Vue({
    el: '#cronograma',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/cronograma',
        matricula_id: $("#matricula_id").val(),
        cronogramas:[],
        alumnos:'',
        mes_seleccionado:'',
        pagos:[]
    },
    methods: {
        obtenerDatos:function () {
            let url = this.baseUrl +'/obtener_datos';
            let data = {
                'matricula_id': this.matricula_id
            };
            axios.post(url, data).then((response) => {
                this.cronogramas = response.data.cronogramas;
                this.alumno = response.data.alumno;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        verCronograma:function(cronograma_id, mes){
            this.mes_seleccionado=mes;
            $('#exampleModal').modal({backdrop: 'static', keyboard: false});
            $('#exampleModal').modal('show');
            let url = this.url_principal +'/pagos/obtener_pagos';
            let data = {
                'cronograma_id': cronograma_id
            };
            axios.post(url, data).then((response) => {
                this.pagos = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        descargar:function(pago){
            console.log(pago);
        },
        cerrarModal:function(){
            $('#exampleModal').modal('hide');
            this.pago_seleccionado = '';

        }
    },
    beforeMount: function(){
        this.obtenerDatos();
    }
});
