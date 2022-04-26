import Vue from 'vue';
var cronograma = new Vue({
    el: '#notas',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'notas',
        matricula_id: $("#matricula_id").val(),
        cronogramas:[],
        alumno:'',
        matricula:'',
        trimestre:1,
        notas:[]
    },
    methods: {
        obtenerDatos:function () {
            let url = this.url_principal +'cronograma/obtener_cronogramas_matricula';
            let data = {
                'matricula_id': this.matricula_id
            };
            axios.post(url, data).then((response) => {
                this.matricula = response.data;
                this.alumno = this.matricula.alumno;
                this.cronogramas = this.matricula.cronogramas;
                this.obtenerNotas(this.trimestre);
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        generarFichaMatricula:function(){
            window.open(this.url_principal+'reportes/descargar_ficha_matricula/'+this.matricula_id);
        },
        obtenerNotas:function (trimestre){
            cargando('show');
            this.trimestre = trimestre;
            let url = this.baseUrl +'/obtener_por_matricula_trimestre';
            let data = {
                'matricula_id': this.matricula_id,
                'trimestre': this.trimestre,
            };
            axios.post(url, data).then((response) => {
                this.notas = response.data;
            }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
            });
        },
        obtenerPromedioAnual:function (){

        }
    },
    created: function(){
        this.obtenerDatos();
    },
});
