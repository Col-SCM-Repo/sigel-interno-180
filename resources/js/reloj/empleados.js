import axios from "axios";
import { event } from "jquery";
import Vue from "vue";
var alumnos = new Vue({
    el: "#empleados",
    data: {
        data: null,
        param: "",
        infoEmpleado: null
    },
    methods: {
        getListaEmpleados: function($event) {
            this.infoEmpleado = null;
            this.data = null;
            $event.preventDefault();
            const url = $event.target.dataset.target;
            axios(url + "/" + this.param, { method: "POST" })
                .then(response => {
                    this.data = response.data;
                })
                .catch(err => {
                    showToastr("Aviso", "Error en el servidor", "error");
                });
        },
        cargarDataAsistencia: function($event) {
            $event.preventDefault();
            this.infoEmpleado = {
                id: $event.target.dataset.id_personal,
                nombre: $event.target.dataset.nombre,
                departamento: $event.target.dataset.departamento
            };
        },
        verReporte: function($event) {
            $event.preventDefault();
            const data = this.validarDatosEmpleado();
            const url = $event.target.dataset.target;
            if (data) {
                axios(url, { method: "POST", data })
                    .then(response => {
                        document.getElementById("info-horarios").innerHTML =
                            response.data;
                    })
                    .catch(err => {
                        showToastr("Aviso", "Error en el servidor", "error");
                    });
            }
        },
        descargarReporte: function($event) {
            $event.preventDefault();
            const data = this.validarDatosEmpleado();
            const url = $event.target.dataset.target;
            if (data) {
                axios(url, { method: "POST", data, responseType: "blob" })
                    .then(response => {
                        const url = window.URL.createObjectURL(
                            new Blob([response.data])
                        );
                        const link = document.createElement("a");
                        link.href = url;
                        link.setAttribute(
                            "download",
                            "REPORTE-" +
                                (this.infoEmpleado?.nombre)
                                    .replace(",", "")
                                    .replace(" ", "-") +
                                ".xls"
                        );
                        document.body.appendChild(link);
                        link.click();
                    })
                    .catch(err => {
                        showToastr("Aviso", "Error en el servidor", "error");
                    });
            }
        },
        validarDatosEmpleado: function() {
            const $formInfoEmpleado = document.getElementById(
                "form-info-empleado"
            );
            if ($formInfoEmpleado) {
                if (
                    $formInfoEmpleado.f_inicio.value.length > 0 &&
                    $formInfoEmpleado.f_fin.value.length > 0
                ) {
                    if (
                        new Date($formInfoEmpleado.f_inicio.value) <=
                        new Date($formInfoEmpleado.f_fin.value)
                    ) {
                        const data = new FormData();
                        data.append("personal_id", this.infoEmpleado.id);
                        data.append(
                            "personal_nombre",
                            this.infoEmpleado.nombre
                        );
                        data.append(
                            "f_inicio",
                            $formInfoEmpleado.f_inicio.value
                        );
                        data.append("f_fin", $formInfoEmpleado.f_fin.value);
                        return data;
                    } else {
                        showToastr(
                            "Aviso",
                            "El rango de fechas esta incorrrecto",
                            "warning"
                        );
                    }
                } else {
                    showToastr("Aviso", "Campos incompletos", "warning");
                }
            } else {
                showToastr(
                    "Aviso",
                    "No se encontro el formulario sobre la informacion - personal",
                    "error"
                );
            }
            return null;
        }
    },
    created: function() {
        const url = document.getElementById("form-busqueda").dataset.target;
        axios(url + "/" + this.param, { method: "POST" })
            .then(response => {
                this.data = response.data;
            })
            .catch(err => {
                showToastr("Aviso", "Error en el servidor", "error");
            });
    }
});
/*
    showToastr("Aviso", "Campos incompletos", "warning");
    showToastr("Aviso", "Campos incompletos", "success");
    showToastr("Aviso", "Campos incompletos", "error");

*/
