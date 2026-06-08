// import { initUserToggle, initUserDelete } from '../modules/users.js';

// document.addEventListener("DOMContentLoaded", () => {
//     initUserToggle();
//     initUserDelete();
// });

import { Events } from "../core/events.js";
import "../modules/users.js";
import { initUsersTable } from "../modules/users-table.js";

document.addEventListener("DOMContentLoaded", () => {
    Events.emit("users:index");
    initUsersTable();
});