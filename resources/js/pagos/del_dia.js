import Vue from 'vue';
var pagos = new Vue({
    el: '#pagos',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/pagos',
        pagos: [],
        fecha: '',
        total:0
    },
    methods: {
        obtenerPagos:function(){
            let url = this.baseUrl +'/obtener_pagos_del_dia';
            this.total =0;
            let data={
                'fecha':this.fecha
            }
            axios.post(url,data).then((response) => {
                this.pagos = response.data;
                console.log(this.pagos);
            }).catch((error) => {
            }).finally((response) => {
                this.calcularTotal();
            });
        },
        calcularTotal:function(){
            this.pagos.forEach(pago => {
                 this.total+=   parseFloat(pago.monto);
            });
        },
        descargarPago:function(pago){
            window.open(this.url_principal+'/reportes/boleta/'+pago.pago_id);
        }
    },
    created: function(){

        $('#pagos-nav').addClass('active');
    }
});
