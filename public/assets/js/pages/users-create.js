

import { initUserValidation, initPasswordValidation } from '../modules/users.js';
import { showToast } from '../modules/alerts.js';

document.addEventListener("DOMContentLoaded", () => {

    if (window.APP_FLASH?.success) {
        showToast(window.APP_FLASH.success, "success");
    }

    if (window.APP_FLASH?.error) {
        showToast(window.APP_FLASH.error, "error");
    }

      // validación AJAX
    initUserValidation();
    initPasswordValidation();

    const form = document.querySelector(".form-users");
    const username = document.getElementById("username");
    const password = document.getElementById("password");

    form.addEventListener("submit", (e) => {

        if (username.dataset.exists === "true") {
            e.preventDefault();
            alert("El username ya está en uso");
        }

        if (password.dataset.valid === "false") {
            e.preventDefault();
            alert("Password inválido");
        }

    });

});