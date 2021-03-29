import Vue from 'vue';
var cronograma = new Vue({
    el: '#cronograma',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/cronograma',
        matricula_id: $("#matricula_id").val(),
        cronogramas:[],
        alumno:'',
        mes_seleccionado:'',
        pagos:[],
        pagar_crono:[]
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
                console.log(this.cronogramas);
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
        cerrarModalPagos:function(){
            $('#exampleModal').modal('hide');
            this.pago_seleccionado = '';
        },
        pagarCronograma:function(cronograma){
            this.pagar_crono = cronograma;
            console.log(this.pagar_crono);
            $('#pagarModal').modal({backdrop: 'static', keyboard: false});
            $('#pagarModal').modal('show');
        },
        cerrarModalPagar:function(){
            $('#pagarModal').modal('hide');
            this.pagar_crono = '';
        }
    },
    beforeMount: function(){
        this.obtenerDatos();
    }
});
