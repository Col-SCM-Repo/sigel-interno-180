import axios from 'axios';
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
        ocupaciones:[],
        tipo_persona:'',
        segundo_tipo:'',
        modelo:[]
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
        crearReligion:function(tipo){
            //agregar obtener el modelo
            this.tipo_persona = tipo;
            $('#religionModal').modal({backdrop: 'static', keyboard: false});
            $('#religionModal').modal('show');
        },
        cerraModalReligion:function(){
            $('#religionModal').modal('hide');
            $('#nueva_religion').val('');
        },
        GuardarReligion:function(){
            let url = this.url_principal +'/religiones/guardar';
            let religion_id='';
            let data = {
                'religion':$('#nueva_religion').val()
            };
            axios.post(url, data).then((response) => {
                religion_id = response.data;
            }).catch((error) => {
            }).finally((response) => {
                this.obtenerReligiones();
                this.AsisgnarId(this.tipo_persona, 1,religion_id);
                this.cerraModalReligion();
                $('#nueva_religion').val('');
            });
        },
        crearPais:function(tipo_persona, segundo_tipo){
            //agregar obtener el modelo
            this.tipo_persona = tipo_persona;
            this.segundo_tipo = segundo_tipo;
            $('#paisModal').modal({backdrop: 'static', keyboard: false});
            $('#paisnModal').modal('show');
        },
        cerraModalPais:function(){
            $('#paisModal').modal('hide');
            $('#nuevo_pais').val('');
        },
        GuardarPais:function(){
            let url = this.url_principal +'/paises/guardar';
            let pais_id='';
            let data = {
                'pais':$('#nuevo_pais').val()
            };
            axios.post(url, data).then((response) => {
                pais_id = response.data;
            }).catch((error) => {
            }).finally((response) => {
                this.obtenerPaises();
                this.AsisgnarId(this.tipo_persona, this.segundo_tipo,pais_id);
                this.cerraModalPais();
                $('#nuevo_pais').val('');
            });
        },
        crearDistrito:function(tipo_persona, segundo_tipo){
            this.obtenerModelo(3);
            this.tipo_persona = tipo_persona;
            this.segundo_tipo = segundo_tipo;
            $('#distritoModal').modal({backdrop: 'static', keyboard: false});
            $('#distritoModal').modal('show');
        },
        cerraModalDistrito:function(){
            this.modelo=[]
            $('#distritoModal').modal('hide');
        },
        GuardarDistrito:function(){
            let url = this.url_principal +'/distritos/guardar';
            let distrito_id='';
            let data = {
                'distrito':this.modelo
            };
            axios.post(url, data).then((response) => {
                distrito_id = response.data;
            }).catch((error) => {
            }).finally((response) => {
                this.obtenerDistritos();
                this.AsisgnarId(this.tipo_persona, this.segundo_tipo,distrito_id);
                this.cerraModalDistrito();
                this.modelo=[];
            });
        },
        crearCentroLaboral:function(tipo_persona, segundo_tipo){
            this.obtenerModelo(4);
            this.tipo_persona = tipo_persona;
            this.segundo_tipo = segundo_tipo;
            $('#centroLaboralModal').modal({backdrop: 'static', keyboard: false});
            $('#centroLaboralModal').modal('show');
        },
        cerraCentroLaboral:function(){
            this.modelo=[]
            $('#centroLaboralModal').modal('hide');
        },
        guardarCentroLaboral:function(){
            let url = this.url_principal +'/centro_laboral/guardar';
            let grado_id='';
            let data = {
                'centro_laboral':this.modelo
            };
            axios.post(url, data).then((response) => {
                grado_id = response.data;
            }).catch((error) => {
            }).finally((response) => {
                this.obtenerDistritos();
                this.AsisgnarId(this.tipo_persona, this.segundo_tipo,grado_id);
                this.cerraModalDistrito();
                this.modelo=[];
            });
        },
        obtenerModelo:function(tipo_modelo){
            this.modelo = [];
            let url ;
            switch (tipo_modelo) {
                case 1://se obtiene el modelo de religion
                    url = this.url_principal +'/religiones/modelo';
                    break;
                case 2://se obtiene el modelo de pais
                    url = this.url_principal +'/paises/modelo';
                    break;
                case 3://se obtiene el modelo de distrito
                    url = this.url_principal +'/distritos/modelo';
                    break;
                case 4://se obtiene el modelo de grado de instruccion
                    url = this.url_principal +'/centro_laboral/modelo';
                    break;
                default:
                    break;
            }
            axios.get(url).then((response) => {
                this.modelo = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        AsisgnarId:function(tipo, id_a, id){
            switch (tipo) {
                case 1: //tipo del alumno
                        switch (id_a) {
                            case 1://el id va a la religion
                                    this.alumno.religion_id = id;
                                break;
                            case 2://el id va al pais
                                this.alumno.pais_id = id;
                                break;
                            case 3://el id va al distrito de nacimineto
                                this.alumno.distrito_nacimiento = id;
                                break;
                            case 4://el id va al distrito de residencia
                                this.alumno.distrito_residencia = id;
                                break;
                            default:
                                break;
                        }
                    break;
                case 2://tipo del familiar seleccionado
                    switch (id_a) {
                        case 1://el id va a la religion
                                this.familiar_seleccionado.religion_id = id;
                            break;
                        case 2://el id va al pais de nacimiento
                            this.familiar_seleccionado.pais_nacimiento_id = id;
                            break;
                        case 3://el id va al pais de residencia
                            this.familiar_seleccionado.pais_residencia_id = id;
                            break;
                        case 4://el id va al distrito de nacimineto
                                this.familiar_seleccionado.distrito_nacimiento_id = id;
                            break;
                        case 5://el id va al distrito de residencia
                            this.familiar_seleccionado.distrito_residencia_id = id;
                            break;
                        case 6://el id va al centro laboral
                            this.familiar_seleccionado.centro_laboral_id = id;
                            break;
                        default:
                            break;
                }
                    break;
                default:
                    break;
            }
        },
        obtenerReligiones:function(){
            let url = this.url_principal +'/religiones/obtener_religiones';
            axios.get(url).then((response) => {
                this.religiones = response.data;
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
            cargando('show');
            this.alumno.correo = this.alumno.dni+'@colegiocabrera.edu.pe';
            let url = this.baseUrl +'/guardar';
            let data = {
                'alumno':this.alumno
            };
            axios.post(url,data).then((response) => {
                this.alumno_id = response.data;
            }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
                location.href = this.baseUrl+'/editar/'+this.alumno_id;
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
