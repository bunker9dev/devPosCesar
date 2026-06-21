import { Events } from "../core/events.js";
import "../modules/purchases.js";

document.addEventListener("DOMContentLoaded", () => {
    Events.emit("purchases:index");
});