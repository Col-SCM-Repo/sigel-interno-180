import Vue from 'vue';
var pagos = new Vue({
    el: '#pagos',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/pagos',
        pagos: [],
        fecha_inicial: '',
        fecha_final: '',
        total:0,
        usuario_id : ''
    },
    methods: {
        obtenerPagos:function(){
            this.pago = [];
            if (this.usuario_id=='') {
                showToastr('Aviso', "Debe Seleccionar un USUARIO","warning");
                return;
            }
            cargando('show');

            let url = this.baseUrl +'/obtener_entre_fechas';
            this.total =0;
            let data={
                'fecha_inicial':this.fecha_inicial,
                'fecha_final':this.fecha_final,
                'usuario_id':this.usuario_id
            }
            console.log(data);
            axios.post(url,data).then((response) => {
                this.pagos = response.data;
            }).catch((error) => {
            }).finally((response) => {                cargando('hide');

            });
        },
        verBoleta:function(pago_id){
            window.open(this.url_principal+'/reportes/boleta/'+pago_id);
        },
        descargarPDF:function(){
            cargando('show');

            var url = this.url_principal + '/reportes/descargar_pagos_entre_fechas_pdf' ;
            let nombre_archivo = 'Pagos de las fechas '+this.fecha_inicial +' - '+this.fecha_final + '.pdf';
            let data= {
                'pagos': this.pagos,
                'fecha_inicial': this.fecha_inicial,
                'fecha_final': this.fecha_final
            }
            axios.post(url,data, { responseType: 'blob' }).then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', nombre_archivo);
                document.body.appendChild(link);
                link.click();
            }).catch((error) => {
            }).finally(()=>{
                cargando('hide');

            });
        },
        descargarExcel:function(){
            cargando('show');

            var url = this.url_principal + '/reportes/descargar_pagos_entre_fechas_excel' ;
            let nombre_archivo = 'Pagos de las fechas '+this.fecha_inicial +' - '+this.fecha_final + '.xls';
            let data= {
                'pagos': this.pagos,
                'fecha_inicial': this.fecha_inicial,
                'fecha_final': this.fecha_final
            }
            axios.post(url,data, { responseType: 'blob' }).then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', nombre_archivo);
                document.body.appendChild(link);
                link.click();
            }).catch((error) => {
            }).finally(()=>{
                cargando('hide');
            });;
        },
    },
    created: function(){
        $('#pagos-nav').addClass('active');
    }
});
