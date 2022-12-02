import axios from 'axios';
import Vue from 'vue';

var documentos = new Vue({
    el: '#documentos',
    data: {
        modulo_id : $("#modulo_id").val(),
        base_url : $("#base_url").val(),
        lista_documentos : [],
        documento_seleccionado_id : null,
        documento_seleccionado: null,


    },
    methods: {
        obtenerDocumentos: function (){
            const url = this.base_url+'/obtener/'+ (this.modulo_id.length>0 ? this.modulo_id : 0 );
            axios(url).then( response => {
                const data = response.data;
                if(data){
                    const temp = data.map( element => {
                        const partesNombre = element.nombre_archivo.split('.');
                        const extension = partesNombre[1]? partesNombre[1] : 'pdf';
                        element.extension = extension;
                        return element;
                    });
                    this.lista_documentos = temp;
                }
            }).catch(err=>{
                console.error(err);
                showToastr('Error','Ocurrio un error inesperado.', 'error');
            })
        },
        abrirModalNuevoDocumento: function(){
            $('#modal-carga-documentos').modal({backdrop: 'static', keyboard: false});
            $('#modal-carga-documentos').modal('show');
            this.cargarModeloBlanco();
        },
        cerrarModalNuevoDocumento : function(){
            $('#modal-carga-documentos').modal('hide');
            this.documento_seleccionado = [];
            this.documento_seleccionado_id = null;
        },
        cargarModeloBlanco : function (){
            axios(this.base_url+'/view-model').then(response => {
                this.documento_seleccionado = response.data;
                this.documento_seleccionado_id = null;
                this.documento_seleccionado.modulo_sistema_id = (this.modulo_id != 0 && this.modulo_id!='')? this.modulo_id : '';
            }).catch(err => {
                showToastr('Error', 'Error del servidor.', 'error');
            })
        },
        submitSubirArchivo : function($event){
            $event.preventDefault();
            const $formulario = document.getElementById('formulario-modal-documentos');
            const archivos = $formulario.archivo_documento.files;
            if( archivos.length>0 && $formulario.nombre_archivo.value.length>0 && $formulario.modulo_sistema_id?.value != ''  && $formulario.select_tipo_documento.value.length>0 ){
                const data = new FormData();
                let url = $formulario.getAttribute('action');

                if(this.documento_seleccionado_id != 0 && this.documento_seleccionado_id != '' && this.documento_seleccionado_id!=null)
                    url += '/'+this.documento_seleccionado_id;

                for (const index in this.documento_seleccionado)
                    data.append(index, this.documento_seleccionado[index] );
                data.append('archivo', archivos[0] );

                axios(url, { method:'POST', data, headers: { 'Content-Type': 'multipart/form-data' }}).
                then(response => {
                    this.cerrarModalNuevoDocumento();
                    this.obtenerDocumentos();
                }).catch(err => {
                    showToastr('Error', 'Error al guardar el documento', 'error');
                })
            }
            else
                showToastr('Alerta', 'Campos incompletos', 'warning')
        },
        mensajeConfirmacionArchivo : function ( documento_id, documento_nombre ){
            Swal.fire({
                title: 'Estas seguro?',
                text: `Se eliminara el archivo ${documento_nombre} definitivamente.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
              }).then((result) => {
                if (result.isConfirmed) {
                    const url = `${this.base_url}/eliminar/${documento_id}`;
                    axios(url, {method:'DELETE'}).then(response => {
                        this.obtenerDocumentos();
                        Swal.fire(
                            'Eliminado!',
                            'El archivo se elimino correctamente.',
                            'success'
                          )
                    }).catch(err=>{
                        showToastr('Error', 'Ocurrio un error al eliminar archivo. ', 'error');
                    })
                }
              })
        },
        /* abrirModalInformacion : function(){
            $('#modal-documentos-informacion').modal('show');
        },
        cerrarModalInformacion : function (){
            $('#modal-documentos-informacion').modal('hide');
        } */
    },
    created: function(){
        this.obtenerDocumentos();
    }
});
/*
$("#buscar").keyup(function(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if(code==13){
        pagos.obtenerAlumnos();
    }
}); */

/*

$('#exampleModal').modal({backdrop: 'static', keyboard: false});
$('#exampleModal').modal('show');



                            showToastr('Correcto','Se retiró al alumno.', 'success');
                            this.verCronograma(matricula.id);
                        }).catch((error) => {
                            showToastr('Error','Ocurrio un error inesperado.', 'error');
                        }).finally(() => {
                            cargando('hide');
                        });
                    }else{
                        showToastr('AVISO','No seleccionó fecha de retiro.', 'warning');

 */
