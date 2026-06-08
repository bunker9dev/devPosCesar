import "../modules/users.js";
import { Events } from "../core/events.js";


document.addEventListener("DOMContentLoaded", () => {
    console.log("EDIT INIT"); // 🔥 debug

    Events.emit("users:edit"); 
});