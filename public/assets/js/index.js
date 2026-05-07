/* ===== CHART ===== */
const canvas = document.getElementById("chart");
const ctx = canvas.getContext("2d");

let data = [20,30,50,40,60,55,80];

function drawChart(){
    ctx.clearRect(0,0,canvas.width,canvas.height);

    ctx.beginPath();
    ctx.strokeStyle = "#00f7ff";
    ctx.lineWidth = 3;

    data.forEach((value, index) => {
        let x = index * 60;
        let y = canvas.height - value;

        if(index === 0){
            ctx.moveTo(x,y);
        } else {
            ctx.lineTo(x,y);
        }
    });

    ctx.stroke();
}

drawChart();

/* ===== ALERTAS DINÁMICAS ===== */
const alertsData = [
    "12 productos con stock crítico",
    "8 productos por vencer",
    "3 pedidos pendientes"
];

const alertsContainer = document.getElementById("alerts");

alertsData.forEach(alert => {
    let div = document.createElement("div");
    div.classList.add("alert");
    div.innerText = alert;
    alertsContainer.appendChild(div);
});

/* ===== SIMULACIÓN TIEMPO REAL ===== */
setInterval(() => {
    let stock = document.getElementById("stock");
    let moves = document.getElementById("moves");

    stock.innerText = parseInt(stock.innerText) + Math.floor(Math.random()*5);
    moves.innerText = parseInt(moves.innerText) + 1;

}, 3000);