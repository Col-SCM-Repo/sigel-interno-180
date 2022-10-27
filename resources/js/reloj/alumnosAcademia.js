import axios from "axios";
import Vue from "vue";
var alumnos = new Vue({
    el: "#alumnos-academia",
    data: {
        baseUrl: $('#baseurl').val() ,
        alumnos: null,
        visible_maniana: true,
        ultimaRquest: null,

        nivelStr: '',
        aulaSeleccionada:'',
        fecha:null,
        aulasDisponibles:[],
    },
    methods: {
        cargarAulas : function ( e ){
            const url = this.baseUrl+'recursos-humanos/aulas/listar-aulas/'+this.nivelStr;

            axios(url).then((response)=>{ this.aulasDisponibles=response.data }).catch(err=>{
                showToastr("Aviso", "Error en el servidor", "error");
            });
            console.log(this.aulasDisponibles);
        },
        getData: function($event) {
            const data = this.validar($event.target);
            if (data) {
                const url = $event.target.getAttribute("action");
                axios(url, { method: "POST", data })
                    .then(response => {
                        cargando("show");
                        this.alumnos = response.data;
                    })
                    .catch(err => {
                        showToastr("Aviso", "Error en el servidor", "error");
                    })
                    .finally(() => {
                        cargando("hide");
                    });
            }
        },
        descargar: function($event) {
            //console.log($event.target);

            //alert($event.target.dataset.target);
            const url = $event.target.dataset.target + "/alumnos";
            const data = this.ultimaRquest;

            showToastr("Aviso", "Generando reporte", "warning");

            axios(url, { method: "POST", data, responseType: "blob" })
                .then(response => {
                    const blob = new Blob([response.data], {
                        type: "application/pdf"
                    });
                    let objectUrl = URL.createObjectURL(blob);
                    window.open(objectUrl);
                    //console.log(response.data);
                })
                .catch(err => {
                    showToastr("Aviso", "Error en el servidor", "error");
                });

        },
        validar: function($formulario) {
            if (
                $formulario.nivel.value.length > 0 &&
                $formulario.aulas.value.length > 0 &&
                $formulario.fecha_busqueda.value.length == 10
            ) {
                const dataForm = new FormData();
                dataForm.append("nivel", $formulario.nivel.value);
                dataForm.append("seccion", $formulario.aulas.value);
                dataForm.append("grado", "");
                dataForm.append("f_inicio", $formulario.fecha_busqueda.value);
                //dataForm.append("f_fin", $formulario.f_fin.value);
                /* console.log(dataForm); */
                this.ultimaRquest = dataForm;
                return dataForm;
            }
            showToastr("Aviso", "Campos incompletos", "warning");
            return null;
        },
        toggleTurn: function(manana) {
            this.visible_maniana = manana;
        }
    },
    created: function() {
    }
});
