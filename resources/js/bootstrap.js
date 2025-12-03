import "bootstrap";
import toastr from "toastr";

// Configure toastr
toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: "400",
    hideDuration: "500",
    timeOut: "4000",
    extendedTimeOut: "1000",
    showEasing: "easeOutQuad",
    hideEasing: "easeInQuad",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
};

// Make toastr globally available
window.Toast = toastr;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
