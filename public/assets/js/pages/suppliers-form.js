import { Events } from "../core/events.js";
import "../modules/suppliers.js";

document.addEventListener("DOMContentLoaded", () => {
    Events.emit("suppliers:form");
});