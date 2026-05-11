
// export function initDashboard() {

// // // 🔹 Animación al hacer scroll
//     const cards = document.querySelectorAll('.card');
//     if (!cards.length) return;

//     const observer = new IntersectionObserver(entries => {
//         entries.forEach((entry, i) => {
//             if (entry.isIntersecting) {
//                 setTimeout(() => {
//                     entry.target.classList.add('show');
//                 }, i * 150);
//             }
//         });
//     }, { threshold: 0.2 });

//     cards.forEach(card => observer.observe(card));

//     const counters = document.querySelectorAll('.card h1');



//     //  Contador animado
//     counters.forEach(counter => {
//         const update = () => {
//             const target = +counter.innerText;
//             const current = +counter.getAttribute('data-value') || 0;

//             const increment = target / 40;

//             if (current < target) {
//                 const value = Math.ceil(current + increment);
//                 counter.setAttribute('data-value', value);
//                 counter.innerText = value;
//                 requestAnimationFrame(update);
//             } else {
//                 counter.innerText = target;
//             }
//         };

//         update();
//     });
// }

// // 🔹 export global para HTML
// window.showSection = function(id) {
//     document.querySelectorAll('.section').forEach(sec => {
//         sec.classList.remove('active');
//     });

//     const target = document.getElementById(id);
//     if (target) target.classList.add('active');
// };



import { Events } from '../core/events.js';

Events.on("dashboard:init", async () => {

    // 🔥 Lazy loading módulos
    const charts = await import('../modules/charts.js');
    const realtime = await import('../modules/realtime.js');

    charts.initCharts();
    realtime.initRealtime();

    // ===============================
    // 🔹 Animación cards
    // ===============================

    const cards = document.querySelectorAll('.card');
    if (!cards.length) return;

    const observer = new IntersectionObserver(entries => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('show');
                }, i * 150);
            }
        });
    }, { threshold: 0.2 });

    cards.forEach(card => observer.observe(card));

    // ===============================
    // 🔹 Contadores animados
    // ===============================

    const counters = document.querySelectorAll('.card h1');

    counters.forEach(counter => {
        const update = () => {
            const target = +counter.innerText;
            const current = +counter.getAttribute('data-value') || 0;

            const increment = target / 40;

            if (current < target) {
                const value = Math.ceil(current + increment);
                counter.setAttribute('data-value', value);
                counter.innerText = value;
                requestAnimationFrame(update);
            } else {
                counter.innerText = target;
            }
        };

        update();
    });

});

// 🔹 Para usar en HTML
window.showSection = function(id) {
    document.querySelectorAll('.section').forEach(sec => {
        sec.classList.remove('active');
    });

    const target = document.getElementById(id);
    if (target) target.classList.add('active');
};