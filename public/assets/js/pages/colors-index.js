import { Events } from "../core/events.js";
import "../modules/color.js";

document.addEventListener("DOMContentLoaded", () => {
  Events.emit("colors:index");
});