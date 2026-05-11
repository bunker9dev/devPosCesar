// /* ===== CHART ===== */
// export function initCharts() {
//     const canvas = document.getElementById("chart");
//     if (!canvas) return;

//     const ctx = canvas.getContext("2d");

//     let data = [20,30,50,40,60,55,80];

//     ctx.beginPath();
//     ctx.strokeStyle = "#00f7ff";

//     data.forEach((value, i) => {
//         let x = i * 60;
//         let y = canvas.height - value;
//         i === 0 ? ctx.moveTo(x,y) : ctx.lineTo(x,y);
//     });

//     ctx.stroke();
// }

export function initCharts() {

    const canvas = document.getElementById("chart");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");

    let data = [20,30,50,40,60,55,80];

    ctx.beginPath();
    ctx.strokeStyle = "#00f7ff";
    ctx.lineWidth = 3;

    data.forEach((value, i) => {
        let x = i * 60;
        let y = canvas.height - value;

        i === 0 ? ctx.moveTo(x,y) : ctx.lineTo(x,y);
    });

    ctx.stroke();
}