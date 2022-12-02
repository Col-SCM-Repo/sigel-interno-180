import axios from 'axios';
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
        pago_model : [],

        // Modal descuentos
        listaDescuentosDisponibles : [],
        listaCronogramasDescuentos: [],
        descuentoSeleccionado_id : null,
        descuentoEditar_id : '',

        // Modal Documentos
        listaDocumentos : [],

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
                this.descuentoSeleccionado_id = (!this.matricula.descuento_id || this.matricula.descuento_id == '')? '': this.matricula.descuento_id;
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
            let url = this.url_principal +'pagos/obtener_modelo/'+cronograma_id+'/'+this.alumno.id;
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
                    this.pago_model.observacion=`ANULA TICKET Nº ${this.pago_seleccionado.serie}-${this.pago_seleccionado.numero}, POR \n`
                    /* this.pago_model.numero = this.pago_seleccionado.numero; */
                }
            });
        },
        onEditarDescuento:function( descuento_id , event ){
            event.preventDefault();
            const $formularioDescuentos = document.getElementById('form-nuevo-descuento');
            const url = $formularioDescuentos.getAttribute('action')+'/'+descuento_id;
            axios(url).then(response=>{
                const descuentoTemp = response.data;
                console.log( descuentoTemp );

                $formularioDescuentos.nombreDescuento.value = descuentoTemp.MP_NOMBRE.toUpperCase() ;
                $formularioDescuentos.descripcionDescuento.value = descuentoTemp.DESCRIPCION.toUpperCase() ;
                $formularioDescuentos.tipoDescuento.value = descuentoTemp.MP_TIPO_BECA ;
                $formularioDescuentos.valorDescuento.value = descuentoTemp.VALOR ;

                this.descuentoEditar_id = descuento_id;
            }).catch(err=>{
                console.error(err);
                showToastr('Error', 'Ocurrio un error al buscar descuento', 'error');
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
        abrirModalOtrosDocumentosModal:function(url){
            axios(url).then(response => {
                this.listaDocumentos = response.data;
            }).catch(err=>{
                showToastr('Error', 'Ocurrio un error al obtener los documentos disponibles. ', 'error');
            });

            $('#otrosDocumentosModal').modal({backdrop: 'static', keyboard: false});
            $('#otrosDocumentosModal').modal('show');
        },
        cerrarModalOtrosDocumentosModal:function(){
            $('#otrosDocumentosModal').modal('hide');
        },
        aplicarTodo : function ($event){
            this.listaCronogramasDescuentos.forEach(cron=>cron.check=$event.target.checked);
        },
        onUpdateCronograma : function ($event){
            const aplicarTodoCronograma = document.getElementById('aplicar-todo-cronograma');
            if(!$event.target.checked)
                aplicarTodoCronograma.checked=false;
            else{
                const seleccionados = this.listaCronogramasDescuentos.filter(cro => cro.check);
                aplicarTodoCronograma.checked = seleccionados.length == this.listaCronogramasDescuentos.length;
            }
        },
        aplicarDescuentosBecar:function( ){
            const cronogramasAplicar = this.listaCronogramasDescuentos.filter(cron=>cron.check).map(cron=>cron.id);

            if(  this.descuentoSeleccionado_id && this.descuentoSeleccionado_id != '' && cronogramasAplicar.length>0 ){
                const $formularioAplicar = document.getElementById('formulario-aplicar-descuento');

                const url = $formularioAplicar.getAttribute('action');
                const data = new FormData();
                data.append('matricula_id', this.matricula_id);
                data.append('descuento_id', this.descuentoSeleccionado_id);
                data.append('cronogramas_afectados', JSON.stringify(cronogramasAplicar));

                axios( url, {method:'POST', data} ).then(response=> {
                    this.obtenerDatos();
                    this.cerrarModalDescuentos();
                    showToastr('Actualización', 'La beca fue aplicada satisfactoriamente', 'success');
                }).catch(err=>{
                    showToastr('Error', 'Ocurrio un error al aplicar el Descuento', 'error');
                })
            }
            else
                showToastr('Error','Datos incompletos, asegúrese de seleccionar un descuento y tener activos al menos un cronograma', 'error');
        },

        guardaNotaCredito:function(){
            let url = this.url_principal +'pagos/guardar_nota_credito';
            /* this.pago_model.observacion = this.pago_model.observacion; */
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
        abrirModalDescuentos: function (){
            this.listaCronogramasDescuentos = this.cronogramas.filter( crono => (crono.estado != 'CANCELADO' && crono.estado != 'EXONERADO') ).map(  cronograma => {
                return {    id:     cronograma.id ,
                            nombre: cronograma.concepto.concepto,
                            estado: cronograma.estado,
                            check:  cronograma.monto_descuento?true:false
                        } } );
            const seleccionadosTemp = this.listaCronogramasDescuentos.filter(cron => cron.check);

            document.getElementById('aplicar-todo-cronograma').checked = seleccionadosTemp.length == this.listaCronogramasDescuentos.length ;

            this.cargarDescuentos();

            $('#becasDescuentosModal').modal({backdrop: 'static', keyboard: false});
            $('#becasDescuentosModal').modal('show');
        },
        cerrarModalDescuentos : function (){

            $('#becasDescuentosModal').modal('hide');
        }
        ,
        abrirModalNuevosDescuentos:function(){
            $('#nuevaBecaModal').modal({backdrop: 'static', keyboard: false});
            $('#nuevaBecaModal').modal('show');
        },
        cerrarModalNuevosDescuentos:function(){
            $('#nuevaBecaModal').modal('hide');
        },

        registrarDescuento:function( event ){
            event.preventDefault();
            const $formularioDescuentos = document.getElementById('form-nuevo-descuento');

            const nombreDescuento = $formularioDescuentos.nombreDescuento.value.toUpperCase();
            const descripcionDescuento = $formularioDescuentos.descripcionDescuento.value.toUpperCase();
            const tipoDescuento = $formularioDescuentos.tipoDescuento.value;
            const valorDescuento = $formularioDescuentos.valorDescuento.value;

            if( nombreDescuento != ''/*  && descripcionDescuento != '' */ && tipoDescuento != '' && valorDescuento != '' ){
                const data = new FormData();
                data.append('nombre', nombreDescuento);
                data.append('descripcion', descripcionDescuento);
                data.append('tipo', tipoDescuento);
                data.append('valor', valorDescuento);

                let url = $formularioDescuentos.getAttribute('action');

                if(this.descuentoEditar_id != ''){
                    url = url+'/'+this.descuentoEditar_id;
                }

                axios(url, { method:'POST', data }).then(response=>{
                    $formularioDescuentos.nombreDescuento.value = '';
                    $formularioDescuentos.descripcionDescuento.value = '';
                    $formularioDescuentos.tipoDescuento.value = '';
                    $formularioDescuentos.valorDescuento.value = '';
                    this.descuentoEditar_id = '';
                    this.cargarDescuentos();
                }).catch(err=>{
                    showToastr('Error','Ocurrio un error inesperado', 'error');
                })
            }else{
                showToastr('Alerta','Datos incompletos', 'warning');
            }



        },


        cargarDescuentos:function(){
            const $formularioDescuentos = document.getElementById('form-nuevo-descuento');

            const url = $formularioDescuentos.getAttribute('action');

            axios(url).then(response=>{
                this.listaDescuentosDisponibles = response.data;
            }).catch(err=>{
                showToastr('Error','Ocurrio un error inesperado al cargar los descuentos', 'error');
                console.error(err);
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

            // SI MODIFICA EL MONTO A COBRAR, EL MONTO DE DESCUENTO ES 0

            if( cronograma.monto_cobrar !='' && cronograma.monto_cobrar>=0){
                if(cronograma.monto_cobrar == "0"){
                    cronograma.estado ="EXONERADO";
                }
                else{
                    if(cronograma.estado == "EXONERADO"){
                        cronograma.estado = 'PENDIENTE';
                    }
                }
                cronograma.monto_descuento = 0;

                let data = {
                    'cronograma': cronograma,
                };
                axios.post(url, data).then((response) => {
                    showToastr('Correcto','Se modifico el monto correctamente.', 'success');
                }).catch((error) => {
                    showToastr('Error','Ocurrio un error inesperado. POR FAVOR RECARGUE LA PÁGINA', 'error');
                }).finally((response) => {
                });

            }
            else{
                showToastr('Error', 'El monto a cobrar no puede ser negativo', 'error');
                cronograma.monto_cobrar = parseFloat(cronograma.monto_inicial) - parseFloat(cronograma.monto_descuento);
                return ;
            }
        },
        validarPago:function(){
            let self = this;
            let url = this.url_principal +'pagos/validar_pago';
            let data = {
                'pago': this.pago_model,
            };

            if (this.pago_model.tipo_comprobante_id==4) {
                if(!this.pago_model.ruc || this.pago_model.ruc.length!=11){
                    return  showToastr('AVISO',"Debe ingresar el numero de RUC de 11 digitos.", 'warning');
                }
                if(!this.pago_model.razon_social){
                    return  showToastr('AVISO',"Debe ingresar la razón social.", 'warning');
                }
                /* if(!this.pago_model.numero || parseInt(this.pago_model.numero)> 32767 ){
                    return  showToastr('AVISO',"Debe ingresar un numero menor de 32767.", 'warning');
                } */

            }

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
        },
        generarDocumento : function ( url, documento_id ){

            const documento_seleccionado = this.listaDocumentos.filter(doc => doc.id == documento_id);

            if( documento_seleccionado.length != 1 ){
                showToastr('Alerta', 'Ocurrio un error, actualice la pagina', 'error');
                return ;
            }

            const data = new FormData();
            data.append('matricula_id', this.matricula_id);
            data.append('documento_id', documento_id);
  /*           data.append('directorio_documento', documento_seleccionado[0].directorio );
            data.append('nombre_documento', documento_seleccionado[0].nombre_archivo ); */

            axios(url, {method:'POST', data, responseType: 'blob'}).then( response => {
                console.log(response.data);
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute("download", documento_seleccionado[0].nombre_archivo);
                document.body.appendChild(link);
                link.click();

            } ).catch(err=>{
                showToastr('Error', 'Ocurrio un error al generar el documento.', 'error');
            })
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
