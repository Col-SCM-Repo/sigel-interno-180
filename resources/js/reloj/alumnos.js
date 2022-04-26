import axios from "axios";
import Vue from "vue";
var alumnos = new Vue({
    el: "#alumnos",
    data: {
        alumnos: null,
        visible_maniana: true,
        ultimaRquest: null
    },
    methods: {
        getData: function($event) {
            const data = this.validar($event.target);
            if (data) {
                const url = $event.target.getAttribute("action");
                axios(url, { method: "POST", data })
                    .then(response => {
                        cargando("show");
                        //console.log(response.data);
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

            /*
            axios(url, { data, method: "POST", responseType: "blob" })
                .then((response) => {
                    console.log(response.data);

                    const blob = new Blob([response.data], {
                        type: "application/pdf",
                    });
                    let objectUrl = URL.createObjectURL(blob);
                    window.open(objectUrl);
                    /**
                    let link = document.createElement("a");
                    let fname = `Reporte especifico`; // El nombre del archivo descargado
                    link.href = objectUrl;
                    link.setAttribute("download", fname);
                    document.body.appendChild(link);
                    link.click();
                    
                })
                .catch((err) => {
                    console.error(err);
                    toastr.error("Error al cargar incidentes", "Incidentes.");
                });
            */
        },
        validar: function($formulario) {
            if (
                $formulario.nivel.value.length > 0 &&
                $formulario.seccion.value.length > 0 &&
                $formulario.grado.value.length > 0 &&
                $formulario.f_inicio.value.length == 10
                //&& $formulario.f_fin.value.length == 10
            ) {
                const dataForm = new FormData();
                dataForm.append("nivel", $formulario.nivel.value);
                dataForm.append("seccion", $formulario.seccion.value);
                dataForm.append("grado", $formulario.grado.value);
                dataForm.append("f_inicio", $formulario.f_inicio.value);
                //dataForm.append("f_fin", $formulario.f_fin.value);
                console.log(dataForm);
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
        console.log("TODO BIEN ..!!!");
    }
}); /*
                if (result.isConfirmed) {
                    let fecha_fin = $("#matricula-fecha_fin").val();
                    if (fecha_fin != "") {
                        matricula.fecha_fin = fecha_fin;
                        cargando("show");
                        let url = this.url_principal + "matriculas/guardar";
                        matricula.estado = 4;
                        let data = {
                            matricula: matricula
                        };
                        axios
                            .post(url, data)
                            .then(response => {
                                showToastr(
                                    "Correcto",
                                    "Se retiró al alumno.",
                                    "success"
                                );
                                this.verCronograma(matricula.id);
                            })
                            .catch(error => {
                                showToastr(
                                    "Error",
                                    "Ocurrio un error inesperado.",
                                    "error"
                                );
                            })
                            .finally(() => {
                                cargando("hide");
                            });
                    } else {
                        showToastr(
                            "AVISO",
                            "No seleccionó fecha de retiro.",
                            "warning"
                        );
                    }
                } else if (result.isDenied) {
                    return;
                }
            });
        },
        matricularAlumno: function(alumno_id) {
            location.href =
                this.url_principal + "matriculas/nueva/" + alumno_id + "/0";
        }


 */

/*
code example.....
 obtenerAlumnos: function() {
            if (this.buscar_string != "") {
                let url = this.baseUrl + "/obtener_alumnos";
                let data = {
                    cadena: this.buscar_string
                };
                axios
                    .post(url, data)
                    .then(response => {
                        this.alumnos = response.data;
                    })
                    .catch(error => {})
                    .finally(response => {});
            }
        },
        abrirModalMatriculas: function(alumno) {
            $("#exampleModal").modal({ backdrop: "static", keyboard: false });
            $("#exampleModal").modal("show");
            this.alumno_seleccionado = alumno;
            this.verMatriculas();
        },
        verMatriculas: function() {
            this.puede_matricularse = true;
            let url =
                this.url_principal + "matriculas/obtener_matriculas_por_alumno";
            let data = {
                alumno_id: this.alumno_seleccionado.id
            };
            axios
                .post(url, data)
                .then(response => {
                    this.matriculas = response.data;
                    this.matriculas.forEach(matricula => {
                        if (matricula.puede_retirarse) {
                            this.puede_matricularse = false;
                        }
                    });
                })
                .catch(error => {})
                .finally(response => {});
        },
        verCronograma: function(matricula_id) {
            location.href = this.url_principal + "cronograma/" + matricula_id;
        },
        cerrarModalMatricula: function() {
            $("#exampleModal").modal("hide");
            this.alumno_seleccionado = [];
            this.matriculas = [];
        },
        editarAlumno: function(alumno_id) {
            location.href = this.baseUrl + "/editar/" + alumno_id;
        },
        abrirModalOtrosPagos: function(matricula) {
            $("#otrosPagosModal").modal({
                backdrop: "static",
                keyboard: false
            });
            $("#otrosPagosModal").modal("show");
            this.matricula_seleccionada = matricula;
            this.obtenerConceptosAnioActual();
        },
        cerrarModalOtrosPagos: function() {
            $("#otrosPagosModal").modal("hide");
            this.matricula_seleccionada = [];
            this.anio_actual = [];
            this.pago_model = [];
            this.conceptos = [];
        },
        obtenerConceptosAnioActual: function() {
            this.conceptos = [];
            let url =
                this.url_principal + "conceptos/obtener_conceptos_anio_actual";
            axios
                .get(url)
                .then(response => {
                    this.anio_actual = response.data.anio;
                    this.pago_model = response.data.pagoModel;
                    this.conceptos = response.data.conceptos;
                })
                .catch(error => {})
                .finally(response => {});
        },
        asignarMonto: function() {
            this.pago_model.monto = $(
                "#conceptos option:selected"
            )[0].attributes["monto"].value;
        },
        guardarPago: function() {
            if (this.pago_model.concepto_pago_id != "") {
                this.pago_model.matricula_id = this.matricula_seleccionada.id;
                let url = this.url_principal + "pagos/guardar_pago";
                let data = {
                    pago: this.pago_model
                };
                axios
                    .post(url, data)
                    .then(response => {
                        window.open(
                            this.url_principal +
                                "reportes/boleta/" +
                                response.data
                        );
                    })
                    .catch(error => {})
                    .finally(response => {
                        this.cerrarModalOtrosPagos();
                    });
            }
        },
        editarMatricula: function(matricula_id) {
            window.open(
                this.url_principal +
                    "matriculas/nueva/" +
                    this.alumno_seleccionado.id +
                    "/" +
                    matricula_id
            );
        },
        generarCarnetAlumno: function(matricula_id) {
            window.open(
                this.url_principal + "reportes/carnet_alumno/" + matricula_id
            );
        },
        retirarAlumno: function(matricula) {
            swal.fire({
                title: "<strong>Retirar Alumno</strong>",
                icon: "warning",
                html:
                    "El alumno se retirará con fecha <br/>, " +
                    '<input type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="matricula-fecha_fin"> <br/>' +
                    "<b>¿Está seguro de retirar al alumno?</b>",
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: "Retirar",
                cancelButtonText: "Cancelar"
            }).then(result => {
                /* Read more about isConfirmed, isDenied below */
/*
showToastr("Aviso", "Campos incompletos", "warning");
            showToastr("Aviso", "Campos incompletos", "success");
            showToastr("Aviso", "Campos incompletos", "error");

*/
