import Vue from 'vue';
var pagos = new Vue({
    el: '#pagos',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/pagos',
        pagos: [],
        fecha: '',
    },
    methods: {
        obtenerPagos:function(){
            let url = this.baseUrl +'/obtener_pagos_del_dia';
            let data={
                'fecha':this.fecha
            }
            axios.post(url,data).then((response) => {
                this.pagos = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        }
    },
    created: function(){

        $('#pagos-nav').addClass('active');
    }
});
