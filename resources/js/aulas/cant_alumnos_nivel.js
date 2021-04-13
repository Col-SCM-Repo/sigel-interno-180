import Vue from 'vue';
var pagos = new Vue({
    el: '#aulas',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/aulas',
        anios: [],
        anio_id: '',
        nivel_id: '',
        secciones:[]
    },
    methods: {
        obtenerAnios:function(){
            let url = this.url_principal +'/anios/obtener_anios';
            axios.get(url).then((response) => {
                this.anios = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerSecciones:function(){
            if (this.aula_id!='') {
                let url = this.url_principal +'/vacantes/cant_alumno_nivel_anio';
                let data ={
                    'anio_id': this.anio_id,
                    'nivel_id': this.nivel_id,
                };
                axios.post(url,data).then((response) => {
                    this.secciones = response.data;
                }).catch((error) => {
                }).finally((response) => {
                });
            } else {
                this.alumnos = [];
            }
        },
        descargarPDF:function(){
            let nivel =  $('#niveles option:selected').text();
            let anio = $('#anios option:selected').text();
            var url = this.url_principal + '/reportes/descargar_lista_secciones' ;
            let nombre_archivo = 'Lista de Secciones de '+nivel +' - '+anio + '.pdf';
            let data= {
                'secciones': this.secciones,
                'nivel': nivel,
                'anio': anio
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
        }
    },
    created: function(){
        this.obtenerAnios();
    }
});
