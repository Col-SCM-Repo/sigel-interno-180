import axios from 'axios';
import Vue from 'vue';
var pagos = new Vue({
    el: '#pagos',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'pagos',
        pagos: [],
        fecha_inicial: '',
        fecha_final: '',
        total:0,
        usuario_id : ''
    },
    methods: {
        obtenerPagos:function(){
            this.pagos = [];
            if (this.usuario_id=='') {
                showToastr('Aviso', "Debe Seleccionar un USUARIO","warning");
                return;
            }
            cargando('show');
            let url = this.baseUrl +'/obtener_entre_fechas';
            this.total=0;
            let data={
                'fecha_inicial':this.fecha_inicial,
                'fecha_final':this.fecha_final,
                'usuario_id':this.usuario_id
            }
            axios.post(url,data).then((response) => {
                let pagos = response.data;
                this.total = 0;
                for ( let i = 0; i<pagos.length; i++){
                    pagos[i].check = false;
                    this.total+=  parseFloat(pagos[i].monto);
                    // pagos.push({...item, check:false});
                    // total += (double) (item.monto);
                    // console.log(item);
                }

                this.pagos=pagos;

                }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
            });
        },
        cambiarChecks:function(event){
            this.pagos = this.pagos.map( pago => { pago.check= event.target.checked; return pago; } );
        },
        getNumeroSeleccionados: function (){
            const seleccionados = this.pagos.filter( el => el.check ).length;
            return seleccionados > 0 ? '('+seleccionados+ '/'+ ( this.pagos.length )+ ' seleccionados)':'';
        },
        marcarCheck : function ( id_ckech ){
            console.log(id_ckech);
            console.log(this.pagos[id_ckech]);
            this.pagos[id_ckech].check = !this.pagos[id_ckech].check;

            if ( this.pagos[id_ckech].check ){
                const pagosMarcados =this.pagos.filter( el => el.check );
                document.getElementById('cbx_todos').checked = pagosMarcados.length == this.pagos.length;
            }
            else
                document.getElementById('cbx_todos').checked = false;


        },
        descargarArchivosXML:function(){
            const items_marcados = this.pagos.filter( el => el.check );
            if( items_marcados.length > 0 ){
                const url = this.baseUrl+'/generar_archivos_xml';
                const data = new FormData();
                data.append('elementos', JSON.stringify(items_marcados.map(el => el.id)) );
                axios( url, { method:'POST', data, responseType:'blob' } ).then( response => {
                    const archivo = new Blob([response.data]);
                    console.log(archivo);
                    const url = window.URL.createObjectURL( archivo );
                    const a = document.createElement('a');
                    a.setAttribute('download', (new Date()).getTime()+'.zip')
                    a.href = url;
                    a.click();


                }).catch(err=>{
                    showToastr('Error', 'Ocurrio un error al generar los archivos XML.', 'error');
                });

            }
            else showToastr('Alerta', 'No se encontraron pagos seleccionados', 'warning');
        }
    },
    created: function(){
        $('#pagos-nav').addClass('active');
    }
});
