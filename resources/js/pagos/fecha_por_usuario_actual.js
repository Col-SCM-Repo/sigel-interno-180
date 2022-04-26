import Vue from 'vue';
var pagos = new Vue({
    el: '#pagos',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'pagos',
        pagos: [],
        fecha: '',
        total:0
    },
    methods: {
        obtenerPagos:function(){
            let url = this.baseUrl +'/obtener_pago_por_fecha_usuario_actual';
            this.total =0;
            let data={
                'fecha':this.fecha
            }
            axios.post(url,data).then((response) => {
                this.pagos = response.data;
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
        descargarPagos:function(){
            var url = this.url_principal + 'reportes/descargar_resumen' ;
            let nombre_archivo = 'Pagos del '+this.fecha + '.pdf';
            let data= {
                'pagos': this.pagos,
                'fecha': this.fecha
            }
            axios.post(url,data, { responseType: 'blob' }).then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', nombre_archivo);
                document.body.appendChild(link);
                link.click();
            }).catch((error) => {
            });
        },
        verBoleta:function(pago){
            window.open(this.url_principal+'reportes/boleta/'+pago.pago_id);
        },
    },
    created: function(){
        $('#pagos-nav').addClass('active');
    }
});
