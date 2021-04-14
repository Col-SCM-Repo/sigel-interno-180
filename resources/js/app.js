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
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "50000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
};

