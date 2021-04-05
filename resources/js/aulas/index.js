import Vue from 'vue';
var pagos = new Vue({
    el: '#aulas',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/aulas',
        anios: [],
        anio_id: '',
        aulas: [],
        aula_id: '',
        alumnos:[]
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
        obtenerAulas:function(){
            this.aula_id='';
            if(this.anio_id!=''){
                let url = this.baseUrl +'/obtener_aulas';
                let data ={
                    'anio_id': this.anio_id
                };
                axios.post(url, data).then((response) => {
                    this.aulas = response.data;
                }).catch((error) => {
                }).finally((response) => {
                });
            }else{
                this.aulas = [];
            }
        },
        obtenerAlumnos:function(){
            if (this.aula_id!='') {
                let url = this.url_principal +'/alumnos/obtener_alumnos_por_aula';
                let data ={
                    'aula_id': this.aula_id
                };
                axios.post(url,data).then((response) => {
                    this.alumnos = response.data;
                }).catch((error) => {
                }).finally((response) => {
                });
            } else {
                this.alumnos = [];
            }
        },
        verCronograma:function(matricula_id){
            location.href=this.url_principal+'/cronograma/'+matricula_id;
        },
        descargarLista:function(){
            let seccion =  $('#seccion option:selected').text();
            let anio = $('#anios option:selected').text();
            var url = this.url_principal + '/reportes/descargar_lista' ;
            let nombre_archivo = 'Lista de Alumnos de '+seccion +' - '+anio + '.xls';
            let data= {
                'alumnos': this.alumnos,
                'seccion': seccion,
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
        },
        editarAlumno:function(alumno_id){
            location.href=this.url_principal+'/alumnos/editar/'+alumno_id;
        }
    },
    created: function(){
        this.obtenerAnios();
        $('#matriculas-nav').addClass('active');
    }
});
