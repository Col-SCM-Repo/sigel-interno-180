import Vue from 'vue';
var cronograma = new Vue({
    el: '#cronograma',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'cronograma',
        matricula_id: $("#matricula_id").val(),
        cronogramas:[],
        alumno:'',
        mes_seleccionado:'',
        pagos:[],
        matricula:'',
        pago_seleccionado:[],
        cronograma_seleccionado:[],
        otros_pagos:[],
        editar: false,
        serie_usuario: $("#serie_usuario").val(),
        fecha_deposito:'',
        pago_model : []
    },
    methods: {
        obtenerDatos:function () {
            let url = this.baseUrl +'/obtener_cronogramas_matricula';
            let data = {
                'matricula_id': this.matricula_id
            };
            axios.post(url, data).then((response) => {
                this.matricula = response.data;
                this.alumno = this.matricula.alumno;
                this.cronogramas = this.matricula.cronogramas;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        verPagosPorCronograma:function(cronograma_id, mes){
            this.mes_seleccionado=mes;
            $('#pagosPorCronogramaModal').modal({backdrop: 'static', keyboard: false});
            $('#pagosPorCronogramaModal').modal('show');
            let url = this.url_principal +'pagos/obtener_pagos';
            let data = {
                'cronograma_id': cronograma_id
            };
            axios.post(url, data).then((response) => {
                this.pagos = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        verBoletaFactura:function(pagoId){
            window.open(this.url_principal+'reportes/boleta/'+pagoId);
        },
        cerrarModalPagos:function(){
            $('#pagosPorCronogramaModal').modal('hide');
            this.pago_seleccionado = '';
        },
        pagarCronograma:function(cronograma){
            this.cronograma_seleccionado = cronograma;
            $('#pagarModal').modal({backdrop: 'static', keyboard: false});
            $('#pagarModal').modal('show');
            this.obtenerPagoModel(cronograma.id);
        },
        obtenerPagoModel:function(cronograma_id){
            let url = this.url_principal +'pagos/obtener_modelo/'+cronograma_id;
            axios.get(url).then((response) => {
                this.pago_model = response.data;
            }).catch((error) => {
            }).finally((response) => {
                if (cronograma_id!=0) {
                    this.pago_model.concepto = this.cronograma_seleccionado.concepto.concepto;
                    this.pago_model.matricula_id = this.matricula.id;
                    this.pago_model.cronograma_id = this.cronograma_seleccionado.id;
                }else{
                    this.pago_model.monto = -this.pago_seleccionado.monto;
                }
            });
        },
        cerrarModalPagar:function(){
            $('#pagarModal').modal('hide');
            this.pago_model = [];
        },
        guardarPago:function(){
            let url = this.url_principal +'pagos/guardar_pago';
            let data = {
                'pago': this.pago_model,
            };
            axios.post(url, data).then((response) => {
                if(response.data!='false'){
                    window.open(this.url_principal+'reportes/boleta/'+response.data);
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
            this.obtenerPagoModel(0);
        },
        cerrarModalNota:function(){
            $('#notaModal').modal('hide');
            this.pago_seleccionado = [];
            this.pago_model = [];
        },
        guardaNotaCredito:function(){
            let url = this.url_principal +'pagos/guardar_nota_credito';
            this.pago_model.observacion = 'ANULA TICKET Nº '+this.pago_seleccionado.serie +'-' +this.pago_seleccionado.numero+', POR ' + this.pago_model.observacion;
            this.pago_model.matricula_id = this.matricula.id;
            this.pago_model.cronograma_id = this.pago_seleccionado.cronograma_id;
            this.pago_model.concepto_pago_id = this.pago_seleccionado.concepto_pago_id;
            let data = {
                'pago': this.pago_model,
                'pago_anteror_id': this.pago_seleccionado.id,
            };
            axios.post(url, data).then((response) => {
                if(response.data!='false'){
                    window.open(this.url_principal+'reportes/boleta/'+response.data);
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
            let url = this.url_principal +'pagos/otros_pagos_por_matricula';
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
            window.open(this.url_principal+'reportes/descargar_ficha_matricula/'+this.matricula_id);
        },
        generarCronograma:function(){
            window.open(this.url_principal+'reportes/descargar_cronograma/'+this.matricula_id);
        },
        editarCronograma:function(){
            this.editar = !this.editar;
        },
        modificarMonto:function(cronograma){
            let url = this.url_principal +'cronograma/actualizar_monto';
            if(cronograma.monto =="0")
                cronograma.estado="EXONERADO";
            let data = {
                'cronograma': cronograma,
            };
            axios.post(url, data).then((response) => {
                showToastr('Correcto','Se modifico el monto correctamente.', 'success');
            }).catch((error) => {
                showToastr('Error','Ocurrio un error inesperado. POR FAVOR RECARGUE LA PÁGINA', 'error');
            }).finally((response) => {
            });
        },
        validarPago:function(){
            let self = this;
            let url = this.url_principal +'pagos/validar_pago';
            let data = {
                'pago': this.pago_model,
            };
            if(this.pago_model.modalidad==2){
                if(!this.pago_model.banco){
                   return  showToastr('AVISO',"Debe seleccionar un banco.", 'warning');
                }
                if(!this.pago_model.numero_operacion){
                    return  showToastr('AVISO',"Debe ingresar el número de operación.", 'warning');
                }
                if(!this.pago_model.fecha_emision){
                    return  showToastr('AVISO',"Debe selccioanr la Fecha de Deposito.", 'warning');
                }
                axios.post(url, data).then((response) => {
                    let  auxResponse= response.data;
                    if(auxResponse){
                        Swal.fire({
                            title: '<strong>El número de operación ya está registrado</strong>',
                            icon: 'warning',
                            html:
                              'El pago con número de operación '+ auxResponse.NUMERO_OPERACION + " del banco " +auxResponse.BANCO+ " ya se encuentra registrado. ¿Desea continuar con el proceso de registrar el pago?",
                            showCloseButton: true,
                            showCancelButton: true,
                            focusConfirm: false,
                            confirmButtonText:
                              'Guardar',
                            cancelButtonText:
                              'Cancelar',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                self.guardarPago();
                            } else if (result.isDenied) {
                                return;
                            }
                        })
                    }
                    else{
                        this.guardarPago();
                    }
                }).catch((error) => {})
            }else{
                this.guardarPago();
            }
        }
    },
    created: function(){
        this.obtenerDatos();
        this.obtenerOtrosPagos();
    },
});

$("#nota_observacion").keyup(function(e) {
    cronograma.pago_model.observacion = cronograma.pago_model.observacion.toUpperCase();
});
