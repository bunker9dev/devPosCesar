// /* ===== SIMULACIÓN TIEMPO REAL ===== */
// export function initRealtime() {

//     const stock = document.getElementById("stock");
//     const moves = document.getElementById("moves");

//     if (!stock || !moves) return;

//     setInterval(() => {
//         stock.innerText = parseInt(stock.innerText) + Math.floor(Math.random()*5);
//         moves.innerText = parseInt(moves.innerText) + 1;
//     }, 3000);
// }

export function initRealtime() {

    const stock = document.getElementById("stock");
    const moves = document.getElementById("moves");

    if (!stock || !moves) return;

    setInterval(() => {
        stock.innerText = parseInt(stock.innerText) + Math.floor(Math.random()*5);
        moves.innerText = parseInt(moves.innerText) + 1;
    }, 3000);
}