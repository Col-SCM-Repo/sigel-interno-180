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
        pagar_crono:[],
        saldo:'',
        fecha_pago:'',
        monto_pago: '',
        observacion_pago: '',
        matricula:'',
        pago_seleccionado:[],
        otros_pagos:[],
        editar: false,
        tipo_comprobante:1,
        serie: $("#serie_empleado").val(),
        serie_factura : 'E001'
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
                this.matricula = response.data.matricula;
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
            window.open(this.url_principal+'/reportes/boleta/'+pago.pago_id);
        },
        cerrarModalPagos:function(){
            $('#exampleModal').modal('hide');
            this.pago_seleccionado = '';
        },
        pagarCronograma:function(cronograma){
            this.pagar_crono = cronograma;
            $('#pagarModal').modal({backdrop: 'static', keyboard: false});
            $('#pagarModal').modal('show');
            this.obtenerSaldo();
        },
        cerrarModalPagar:function(){
            $('#pagarModal').modal('hide');
            this.pagar_crono = '';
        },
        obtenerSaldo:function(){
            let url = this.baseUrl +'/obtener_saldo';
            let data = {
                'cronograma_id': this.pagar_crono.cronograma_id
            };
            axios.post(url, data).then((response) => {
                this.saldo = response.data.saldo;
                this.fecha_pago = response.data.fecha_pago;
            }).catch((error) => {
            }).finally((response) => {
                if(this.saldo==this.pagar_crono.monto){
                    this.monto_pago = this.pagar_crono.monto;
                }else{
                    this.monto_pago = this.saldo;
                }
            });
        },
        guardarPago:function(){
            let serie_aux ='' ;
            if (this.tipo_comprobante==1) {
                serie_aux = this.serie;
            }else{
                serie_aux = $('#serie').val();
            }
            let url = this.url_principal +'/pagos/guardar_pago';
            let data = {
                'serie': serie_aux,
                'numeracion': $('#numeracion').val(),
                'cronograma_id': this.pagar_crono.cronograma_id,
                'fecha': this.fecha_pago,
                'observacion': this.observacion_pago,
                'monto': this.monto_pago,
                'saldo': this.saldo,
            };
            axios.post(url, data).then((response) => {
                if(response.data!='false'){
                    window.open(this.url_principal+'/reportes/boleta/'+response.data)
                }else{
                    Swal.fire('Ocurrio un error inespedaro, por favor compruebe si el pago se registro con exito');
                }
            }).catch((error) => {
            }).finally((response) => {
                this.cerrarModalPagar();
                this.obtenerDatos();
            });
        },
        abrirModalNota:function(pago){
            $('#notaModal').modal({backdrop: 'static', keyboard: false});
            $('#notaModal').modal('show');
            this.pago_seleccionado = pago;
        },
        cerrarModalNota:function(){
            $('#notaModal').modal('hide');
            this.pago_seleccionado = [];
        },
        guardaNotaCredito:function(){
            let url = this.url_principal +'/pagos/guardar_nota_credito';
            this.pago_seleccionado.observacion = 'ANULA TICKET Nº '+this.pago_seleccionado.serie +'-' +this.pago_seleccionado.numero+', POR ' + this.pago_seleccionado.observacion;
            let data = {
                'pago': this.pago_seleccionado,
            };
            axios.post(url, data).then((response) => {
                if(response.data!='false'){
                    window.open(this.url_principal+'/reportes/boleta/'+response.data)
                }else{
                    Swal.fire('Ocurrio un error inespedaro, por favor compruebe si el pago se registro con exito');
                }
            }).catch((error) => {
            }).finally((response) => {
                this.cerrarModalNota();
                this.cerrarModalPagos();
                this.obtenerDatos();
                this.obtenerOtrosPagos();
            });
        },
        obtenerOtrosPagos:function(){
            let url = this.url_principal +'/pagos/otros_pagos_por_matricula';
            let data = {
                'matricula_id': this.matricula_id,
            };
            axios.post(url, data).then((response) => {
                this.otros_pagos = response.data;
            }).catch((error) => {
            }).finally((response) => {

            });
        },
        generarFichaMatricula:function(){
            window.open(this.url_principal+'/reportes/descargar_ficha_matricula/'+this.matricula_id);
        },
        generarCronograma:function(){
            window.open(this.url_principal+'/reportes/descargar_cronograma/'+this.matricula_id);
        },
        editarCronograma:function(){
            this.editar = !this.editar;
        },
        modificarMonto:function(cronograma_id, monto){
            let url = this.url_principal +'/cronograma/actualizar_monto';
            let data = {
                'cronograma_id': cronograma_id,
                'monto': monto
            };
            axios.post(url, data).then((response) => {
                showToastr('Correcto','Se modifico el monto correctamente.', 'success');
            }).catch((error) => {
                showToastr('Error','Ocurrio un error inesperado. POR FAVOR RECARGUE LA PÁGINA', 'error');

            }).finally((response) => {

            });
        }
    },
    beforeMount: function(){
        this.obtenerDatos();
        this.obtenerOtrosPagos();
    },
});

$("#nota_observacion").keyup(function(e) {
    cronograma.pago_seleccionado.observacion = cronograma.pago_seleccionado.observacion.toUpperCase();
});
