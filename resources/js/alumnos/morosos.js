import axios from 'axios';
import Vue from 'vue';
var aulas = new Vue({
    el: '#aulas',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/alumnos',
        anios: [],
        anio_id: '',
        nivel_id: '',
        seccion_id: '',
        concepto_id: '',
        secciones: [],
        estado: '',
        alumnos: [],
        conceptos: [],
        total_monto: 0,
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
            this.seccion_id = '';
            this.estado ='';
            this.concepto_id ='';
            if (this.nivel_id!='') {
                let url = this.url_principal +'/vacantes/cant_alumno_nivel_anio';
                let data ={
                    'anio_id': this.anio_id,
                    'nivel_id': this.nivel_id,
                };
                axios.post(url,data).then((response) => {
                    this.secciones = response.data;
                }).catch((error) => {
                }).finally((response) => {
                    this.obtenerConceptos();
                });
            } else {
                this.secciones = [];
            }
        },
        obtenerConceptos:function () {
            if (this.nivel_id!='') {
                let url = this.url_principal +'/conceptos/obtener_conceptos_anio_nivel';
                let data ={
                    'anio_id': this.anio_id,
                    'nivel_id': this.nivel_id,
                };
                axios.post(url,data).then((response) => {
                    this.conceptos = response.data;
                }).catch((error) => {
                }).finally((response) => {
                });
            } else {
            }
        },
        obtenerAlumnosMorosos:function () {
            this.total_monto = 0;
            this.alumnos = [];
            if (this.anio_id=='') {
                showToastr('Aviso','Debe seleccionar un AÑO.', 'warning');
                return;
            }
            if (this.nivel_id=='') {
                showToastr('Aviso','Debe seleccionar un NIVEL.', 'warning');
                return;
            }
            if (this.seccion_id=='') {
                showToastr('Aviso','Debe seleccionar una SECCIÒN.', 'warning');
                return;
            }
            if (this.concepto_id=='') {
                showToastr('Aviso','Debe seleccionar un CONCEPTO.', 'warning');
                return;
            }
            if (this.estado=='') {
                showToastr('Aviso','Debe seleccionar un ESTADO.', 'warning');
                return;
            }
            cargando('show');

            let url = this.url_principal+'/pagos/obtener_alumnos_morosos';
            let data = {
                'anio_id':this.anio_id,
                'nivel_id':this.nivel_id,
                'seccion_id':this.seccion_id,
                'concepto_id':this.concepto_id,
                'estado':this.estado,
            };
            axios.post(url,data).then((response) => {
                this.alumnos = response.data;
            }).catch((error) => {
            }).finally((response) => {
                this.alumnos.forEach(alumno => {
                    this.total_monto+= parseFloat(alumno.monto);
                });
                cargando('hide');
            });
        },
        descargarPDF:function(){
            cargando('show');
            var url = this.url_principal + '/reportes/descargar_lista_alumno_morosos' ;
            let nombre_archivo = 'Lista de Alumnos Morosos.pdf';
            let data= {
                'alumnos': this.alumnos,
                'total_monto': this.total_monto,
            }
            axios.post(url,data, { responseType: 'blob' }).then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', nombre_archivo);
                document.body.appendChild(link);
                link.click();
            }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
            });;
        },
        restablecerValores:function () {
            this.nivel_id = '';
            this.seccion_id = '';
            this.concepto_id ='';
            this.estado ='';
        }
    },
    created: function(){
        this.obtenerAnios();
    }
});
