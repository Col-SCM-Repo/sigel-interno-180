import axios from 'axios';
import Vue from 'vue';
var usuarios = new Vue({
    el: '#usuarios',
    data: {
        url_principal: $("#baseUrl").val(),
        baseUrl: $("#baseUrl").val()+'usuarios',
        usuarios: [],
        usuario_modelo:[],
        editar: false,
        serie_modelo:[]
    },
    methods: {
        obtenerUsuarios:function(){
            let url = this.baseUrl +'/obtener_usuarios';
            axios.get(url).then((response) => {
                this.usuarios = response.data;
            }).catch((error) => {
            }).finally((response) => {
            });
        },
        editarUsuario:function(usuario){
            this.usuario_modelo = usuario;
            this.editar=true;
            this.abrirUsuarioModal();
        },
        crearUsuario:function(){
            cargando('show');
            this.editar=false;
            let url = this.baseUrl +'/obtener_modelo';
            axios.get(url).then((response) => {
                this.usuario_modelo = response.data;
                this.abrirUsuarioModal();
            }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
            });
        },
        abrirUsuarioModal:function(){
            $('#usuarioModal').modal({backdrop: 'static', keyboard: false});
            $('#usuarioModal').modal('show');
        },
        cerrarUsuarioModal:function(){
            $('#usuarioModal').modal('hide');
            this.usuario_modelo = [];
        },
        guardarUsuario:function(){
            cargando('show');
            let url = this.baseUrl +'/guardar';
            let data = {
                'usuario':this.usuario_modelo
            }
            if (this.editar) {
                axios.put(url,data).then((response) => {
                    this.obtenerUsuarios();
                    this.cerrarUsuarioModal();
                }).catch((error) => {
                }).finally((response) => {
                    cargando('hide');
                });
            } else {
                axios.post(url,data).then((response) => {
                    this.obtenerUsuarios();
                    this.cerrarUsuarioModal();
                }).catch((error) => {
                }).finally((response) => {
                    cargando('hide');
                });
            }
        },
        editarSerie:function(usuario){
            this.usuario_modelo = usuario;
            this.serie_modelo = usuario.serie;
            this.editar=true;
            this.abrirSerieModal();
        },
        crearSerie:function(usuario){
            cargando('show');
            this.usuario_modelo = usuario;
            this.editar=false;
            let url = this.url_principal +'series/obtener_modelo';
            axios.get(url).then((response) => {
                this.serie_modelo = response.data;
                this.abrirSerieModal();
            }).catch((error) => {
            }).finally((response) => {
                cargando('hide');
            });
        },
        abrirSerieModal:function(){
            $('#serieModal').modal({backdrop: 'static', keyboard: false});
            $('#serieModal').modal('show');
        },
        cerrarSerieModal:function(){
            $('#serieModal').modal('hide');
            this.serie_modelo = [];
        },
        guardarSerie:function(){
            cargando('show');
            let url = this.url_principal +'series/guardar';
            this.serie_modelo.usuario_id = this.usuario_modelo.id;
            let data = {
                'serie':this.serie_modelo
            }
            if (this.editar) {
                axios.put(url,data).then((response) => {
                    this.cerrarSerieModal();
                    this.obtenerUsuarios();
                }).catch((error) => {
                }).finally((response) => {
                    cargando('hide');
                });
            } else {
                axios.post(url,data).then((response) => {
                    this.cerrarSerieModal();
                    this.obtenerUsuarios();
                }).catch((error) => {
                }).finally((response) => {
                    cargando('hide');
                });
            }
        }
    },
    created: function(){
        this.obtenerUsuarios();
    }
});
