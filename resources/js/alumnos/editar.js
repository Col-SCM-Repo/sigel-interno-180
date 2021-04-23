import Vue from 'vue';
var editar = new Vue({
    el: '#editar',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'/alumnos',
        alumno_id:$("#alumno_id").val(),
        alumno:[],
        paises:[],
        distritos:[],
        religiones:[],
        familiares:[],
        familiar_seleccionado:[],
        editar_familiar: false,
        tipo_documentos:[],
        tipo_parentescos:[],
        grados_intruccion:[],
        centro_laborales:[],
        ocupaciones:[]
    },
    methods: {
        obtenerDatos:function(){
            let url = this.baseUrl +'/obtener_datos';
            let data={
                'alumno_id':this.alumno_id,
            }
            axios.post(url,data).then((response) => {
                this.paises = response.data.paises;
                this.distritos = response.data.distritos;
                this.religiones = response.data.religiones;
                this.tipo_documentos = response.data.tipo_documentos;
                this.tipo_parentescos = response.data.tipo_parentescos;
                this.grados_intruccion = response.data.grados_intruccion;
                this.centro_laborales = response.data.centro_laborales;
                this.ocupaciones = response.data.ocupaciones;
                this.alumno = response.data.alumno;
                this.familiares = this.alumno.apoderados;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerPaises:function(){
            let url = this.url_principal +'/paises/obtener_paises';
            axios.get(url).then((response) => {
                this.paises = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerDistritos:function(){
            let url = this.url_principal +'/distritos/obtener_distritos';
            axios.get(url).then((response) => {
                this.distritos = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerReligiones:function(){
            let url = this.url_principal +'/religiones/obtener_religiones';
            axios.get(url).then((response) => {
                this.religiones = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerFamiliares:function(){
            let url = this.url_principal +'/apoderados/obtener_por_alumno';
            let data = {
                'alumno_id':this.alumno_id,
            };
            axios.post(url,data).then((response) => {
                this.familiares = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        guardarAlumno:function(){
           // cargando('show');
            this.alumno.correo = this.alumno.dni+'@colegiocabrera.edu.pe';
            let url = this.baseUrl +'/guardar';
            let data = {
                'alumno':this.alumno
            };
            axios.post(url,data).then((response) => {
                this.alumno_id = response.data;
            }).catch((error) => {
            }).finally((response) => {
                location.href = this.baseUrl+'/editar/'+this.alumno_id;
                cargando('hide');
            });
        },
        obtenerTipoDocumentos:function(){
            let url = this.url_principal +'/tipo_documento/obtener_tipos';
            axios.get(url).then((response) => {
                this.tipo_documentos = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerTipoParentescos:function(){
            let url = this.url_principal +'/tipo_parentesco/obtener_tipos';
            axios.get(url).then((response) => {
                this.tipo_parentescos = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerGradosInstruccion:function(){
            let url = this.url_principal +'/grado_instrucion/obtener_grados';
            axios.get(url).then((response) => {
                this.grados_intruccion = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerCentroLaborales:function(){
            let url = this.url_principal +'/centro_laboral/obtener_centros';
            axios.get(url).then((response) => {
                this.centro_laborales = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        obtenerOcupaciones:function(){
            let url = this.url_principal +'/ocupacion/obtener_ocupaciones';
            axios.get(url).then((response) => {
                this.ocupaciones = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        editarFamiliar:function(familiar,editar, nuevo){
            if (nuevo) {
                let url = this.url_principal +'/apoderados/modelo';
                axios.get(url).then((response) => {
                    this.familiar_seleccionado = response.data;
                }).catch((error) => {
                }).finally((response) => {
                });
            } else {
                this.familiar_seleccionado = familiar;
            }
            this.editar_familiar = editar;
        },
        guardaFamiliar:function(){
            cargando('show');
            let url = this.url_principal +'/apoderados/guardar';
            this.familiar_seleccionado.alumno_id = this.alumno_id;
            let data = {
                'familiar':this.familiar_seleccionado
            };
            axios.post(url,data).then((response) => {
                showToastr('Correcto','Se guardó CORRECTAMENTE al FAMILIAR.', 'success');
            }).catch((error) => {
                showToastr('Error','Ocurrio un error inesperado. POR FAVOR RECARGUE LA PÁGINA', 'error');
            }).finally((response) => {
                this.obtenerFamiliares();
                this.familiar_seleccionado = [];
                cargando('hide');
            });
        },
        matricularAlumno:function(){
            location.href=this.url_principal+'/matriculas/nueva/'+this.alumno_id+'/0';
        }
    },
    created: function(){
        this.obtenerDatos();
    }
});
