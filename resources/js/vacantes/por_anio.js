import Vue from 'vue';
var pagos = new Vue({
    el: '#aulas',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'vacantes',
        anios: [],
        anio_id: '',
        aulas: [],
        aula_id: '',
        matriculas:[],
        matriculas_seleccionadas:[]
    },
    methods: {
        obtenerAnios:function(){
            let url = this.url_principal +'anios/obtener_anios';
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
        obtenerMatriculas:function(){
            if (this.aula_id!='') {
                cargando('show');
                let url = this.url_principal +'matriculas/obtener_por_aula';
                let data ={
                    'aula_id': this.aula_id
                };
                axios.post(url,data).then((response) => {
                    this.matriculas = response.data;
                }).catch((error) => {
                }).finally((response) => {
                    cargando('hide');
                });
            } else {
                this.matriculas = [];
            }
        },
        verCronograma:function(matricula_id){
            location.href=this.url_principal+'cronograma/'+matricula_id;
        },
        descargarLista:function(){
            cargando('show');
            let seccion =  $('#seccion option:selected').text();
            let anio = $('#anios option:selected').text();
            var url = this.url_principal + 'reportes/descargar_matriculas_por_aula' ;
            let nombre_archivo = 'Lista de Alumnos de '+seccion +' - '+anio + '.xls';
            let data ={
                'aula_id': this.aula_id
            };
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
        editarAlumno:function(alumno_id){
            location.href=this.url_principal+'alumnos/editar/'+alumno_id;
        },
        agregarEliminarAlumno:function(matricula_id, e){
            if (e.target.checked) {
                this.matriculas_seleccionadas.push(matricula_id);
                return
            }
            if (!e.target.checked) {
                this.matriculas_seleccionadas = this.matriculas_seleccionadas.filter(item => item !== matricula_id);
                return
            }
        },
        generarCarnetAlumno: function(matricula_id){
            window.open(this.url_principal+'reportes/carnet_alumno/'+matricula_id);
        },
        generarCarnets: function(){
            window.open(this.url_principal+'reportes/carnets_aula/'+this.aula_id);
        }
    },
    created: function(){
        this.obtenerAnios();
    }
});
