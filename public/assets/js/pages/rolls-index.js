import { Events } from "../core/events.js";
import "../modules/rolls.js";

document.addEventListener("DOMContentLoaded", () => {
    Events.emit("rolls:index");
});