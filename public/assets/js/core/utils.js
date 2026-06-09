export function showMsg(el, text, type) {
  if (!el) return;

  el.textContent = text;
  el.className = "input-msg";

  if (type === "error") el.classList.add("error");
  if (type === "success") el.classList.add("success");
  if (type === "loading") el.classList.add("loading");
}

