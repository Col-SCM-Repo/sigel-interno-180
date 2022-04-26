import axios from 'axios';
import Vue from 'vue';
var anio = new Vue({
    el: '#anios',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'anios',
        anios: [],
        anio_modelo: [],
        editar : false,
        lista_aulas:[],
        aula_modelo:[],
        lista_conceptos_anio:[],
        concepto_modelo:[],
        lista_conceptos:[],
        lista_carnets:[],
        carnet_modelo:[],
        carnet_foto:[],
    },
    methods: {
        obtenerAnios:function(){
            let url = this.baseUrl +'/obtener_anios';
            axios.get(url).then((response) => {
                this.anios = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        editarAnio:function(anio){
            this.anio_modelo = anio;
            this.editar=true;
            this.abrirAnioModal();
        },
        crearAnio:function(){
            cargando('show');
            this.editar=false;
            let url = this.baseUrl +'/obtener_modelo';
            axios.get(url).then((response) => {
                this.anio_modelo = response.data;
                this.abrirAnioModal();
            }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
            });
        },
        abrirAnioModal:function(){
            $('#anioModal').modal({backdrop: 'static', keyboard: false});
            $('#anioModal').modal('show');
        },
        cerrarAnioModal:function(){
            $('#anioModal').modal('hide');
            this.anio_modelo = [];
        },
        guardarAnio:function(){
            cargando('show');
            let url = this.baseUrl +'/guardar';
            let data = {
                'anio':this.anio_modelo
            }
            if (this.editar) {
                axios.put(url,data).then((response) => {
                    this.obtenerAnios();
                    this.cerrarAnioModal();
                }).catch((error) => {
                }).finally((response) => {
                    cargando('hide');
                });
            } else {
                axios.post(url,data).then((response) => {
                    this.obtenerAnios();
                    this.cerrarAnioModal();
                }).catch((error) => {
                }).finally((response) => {
                    cargando('hide');
                });
            }
        },
        abrirAulasModal:function(anio){
            $('#aulasModal').modal('show');
            this.anio_modelo = anio;
            this.obtenerAulas();
        },
        obtenerAulas:function(){
            cargando('show');
            let url = this.url_principal +'vacantes/obtener_aulas';
            let data = {
                'anio_id':this.anio_modelo.id
            }
            axios.post(url,data).then((response) => {
               this.lista_aulas = response.data;
            }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
            });
        },
        cerrarAulasModal:function(){
            $('#aulasModal').modal('hide');
            this.anio_modelo = [];
        },
        editarAula:function(aula){
            this.aula_modelo = aula;
            this.editar = true;
            this.abrirAulaModal();
        },
        crearAula:function(){
            cargando('show');
            this.editar=false;
            let url = this.url_principal +'vacantes/obtener_modelo';
            axios.get(url).then((response) => {
                this.aula_modelo = response.data;
                this.abrirAulaModal();
            }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
            });
        },
        abrirAulaModal:function(){
            $('#aulaModal').modal({backdrop: 'static', keyboard: false});
            $('#aulaModal').modal('show');
        },
        cerrarAulaModal:function(){
            $('#aulaModal').modal('hide');
            this.aula_modelo = [];
        },
        guardarAula:function(){
            cargando('show');
            let url = this.url_principal +'vacantes/guardar';
            this.aula_modelo.anio_id = this.anio_modelo.id;
            let data = {
                'vacante':this.aula_modelo
            }
            if (this.editar) {
                axios.put(url,data).then((response) => {
                    this.obtenerAulas();
                    this.cerrarAulaModal();
                }).catch((error) => {
                }).finally((response) => {
                    cargando('hide');
                });
            } else {
                axios.post(url,data).then((response) => {
                    this.obtenerAulas();
                    this.cerrarAulaModal();
                }).catch((error) => {
                }).finally((response) => {
                    cargando('hide');
                });
            }
        },
        abrirConceptosModal:function(anio){
            $('#conceptosModal').modal('show');
            this.anio_modelo = anio;
            this.obtenerConceptos();
        },
        obtenerConceptos:function(){
            cargando('show');
            let url = this.url_principal +'conceptos/obtener_conceptos_por_anio';
            let data = {
                'anio_id':this.anio_modelo.id
            }
            axios.post(url,data).then((response) => {
               this.lista_conceptos_anio = response.data;
            }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
            });
        },
        cerrarConceptosModal:function(){
            $('#conceptosModal').modal('hide');
            this.anio_modelo = [];
        },
        editarConcepto:function(concepto){
            this.concepto_modelo = concepto;
            this.editar = true;
            this.abrirConceptoModal();
        },
        crearConcepto:function(){
            cargando('show');
            this.editar=false;
            let url = this.url_principal +'conceptos/obtener_modelo';
            axios.get(url).then((response) => {
                this.concepto_modelo = response.data;
                this.abrirConceptoModal();
            }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
            });
        },
        abrirConceptoModal:function(){
            $('#conceptoModal').modal({backdrop: 'static', keyboard: false});
            $('#conceptoModal').modal('show');
            let url = this.url_principal +'conceptos/obtener_todos_conceptos';
            axios.get(url).then((response) => {
                this.lista_conceptos = response.data;
            }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
            });
        },
        cerrarConceptoModal:function(){
            $('#conceptoModal').modal('hide');
            this.concepto_modelo = [];
            this.lista_conceptos = [];
        },
        guardarConcepto:function(){
            cargando('show');
            let url = this.url_principal +'conceptos/guardar';
            this.concepto_modelo.anio_id = this.anio_modelo.id;
            let data = {
                'concepto':this.concepto_modelo
            }
            if (this.editar) {
                axios.put(url,data).then((response) => {
                    this.obtenerConceptos();
                    this.cerrarConceptoModal();
                }).catch((error) => {
                }).finally((response) => {
                    cargando('hide');
                });
            } else {
                axios.post(url,data).then((response) => {
                    this.obtenerConceptos();
                    this.cerrarConceptoModal();
                }).catch((error) => {
                }).finally((response) => {
                    cargando('hide');
                });
            }
        },
        abrirCarnetsModal:function(anio){
            $('#carnetsModal').modal('show');
            this.anio_modelo = anio;
            this.obtenerCarnets();
        },
        obtenerCarnets:function(){
            cargando('show');
            let url = this.url_principal +'carnets/obtener_carnets_anio';
            let data = {
                'anio_id':this.anio_modelo.id
            }
            axios.post(url,data).then((response) => {
               this.lista_carnets = response.data;
            }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
            });
        },
        cerrarCarnetsModal:function(){
            $('#carnetsModal').modal('hide');
            this.anio_modelo = [];
        },
        editarCarnet:function(carnet){
            this.carnet_modelo = carnet;
            this.editar = true;
            this.abrirCarnetModal();
        },
        crearCarnet:function(){
            cargando('show');
            this.editar=false;
            let url = this.url_principal +'carnets/obtener_modelo';
            axios.get(url).then((response) => {
                this.carnet_modelo = response.data;
                this.abrirCarnetModal();
            }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
            });
        },
        abrirCarnetModal:function(){
            $('#carnetModal').modal({backdrop: 'static', keyboard: false});
            $('#carnetModal').modal('show');
        },
        cerrarCarnetModal:function(){
            $('#carnetModal').modal('hide');
            this.carnet_modelo = [];
        },
        precargarImagen:function(event){
            let imagen = event.srcElement;
            if (imagen.files&&imagen.files[0]) {
                var reader = new FileReader();
                this.carnet_foto = imagen.files[0];
                reader.onload = function (e) {
                    var filePreview = document.getElementById('carnet_imagen');
                    filePreview.src = e.target.result;
                }
                reader.readAsDataURL(imagen.files[0]);
            }
        },
        guardarCarnet:function(){
            cargando('show');
            let url = this.url_principal +'carnets/guardar';
            this.carnet_modelo.anio_id = this.anio_modelo.id;
            let data = {
                'carnet':this.carnet_modelo
            }
            let carnet_id ;
            if (this.editar) {
                axios.put(url,data).then((response) => {
                    carnet_id = response.data;
                    this.guardarImagen(carnet_id);
                }).catch((error) => {
                }).finally((response) => {
                    cargando('hide');
                });
            } else {
                axios.post(url,data).then((response) => {
                    carnet_id = response.data;
                    this.guardarImagen(carnet_id);
                }).catch((error) => {
                }).finally((response) => {
                    cargando('hide');
                });
            }
        },
        guardarImagen:function(carnet_id){
            if (this.carnet_foto!='') {
                var url = this.url_principal + 'carnets/guardar_imagen';
                let formData = new FormData();
                formData.append('carnet_foto', this.carnet_foto);
                formData.append('carnet_id', carnet_id);
                axios.post(url, formData, { headers: { 'Content-Type': 'multipart/form-data' } }).then((response) => {
                    showToastr('Correcto','Se actualizó correctamente la foto.', 'success');
                    this.obtenerCarnets();
                    this.cerrarCarnetModal();
                }).catch((error) => {
                }).finally((response) => {
                });
            }else{
                showToastr('Aviso','No ha seleccionado una foto.', 'warning');
            }
        },
    },
    created: function(){
        this.obtenerAnios();
    }
});
