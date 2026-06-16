// import { initUserToggle, initUserDelete } from '../modules/users.js';

// document.addEventListener("DOMContentLoaded", () => {
//     initUserToggle();
//     initUserDelete();
// });
console.log("INDEX JS CARGADO 🔥");
import { Events } from "../core/events.js";
import { initUserDelete } from "../modules/users.js";
import { initUsersTable } from "../modules/users-table.js";

document.addEventListener("DOMContentLoaded", () => {
    Events.emit("users:index");
    initUsersTable();
    initUserDelete();
});