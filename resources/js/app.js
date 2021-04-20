/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 window._ = require('lodash');

 require('./axiosapp');

 require('./vueapp');

 /**
  * Custom Show notification and sniper
  */
  window.showToastr = function(title, message, type) {
    toastr[type](message, title);
    toastr.options = {
        "closeButton": true,
        "newestOnTop": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
};

window.cargando = function(data) {
    if (data !== "show") {
        $("#spiner").hide();
    } else {
        $("#spiner").show();
    }
};

cargando('hide');
