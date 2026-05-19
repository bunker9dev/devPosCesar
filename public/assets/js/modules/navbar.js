// export function initNavbar() {

//     const user = document.getElementById('nav-user');
//     const dropdown = document.getElementById('nav-dropdown');
//     const toggle = document.getElementById('nav-toggle');

//     if (!user || !dropdown) return;

//     // Toggle dropdown
//     user.addEventListener('click', (e) => {
//         e.stopPropagation();
//         dropdown.classList.toggle('active');
//     });

//     // Click fuera
//     document.addEventListener('click', (e) => {
//         if (!user.contains(e.target)) {
//             dropdown.classList.remove('active');
//         }
//     });

//     // Toggle sidebar
//     if (toggle) {
//         toggle.addEventListener('click', () => {
//             console.log("Toggle sidebar");
//         });
//     }
// }

export function initNavbar() {

    const user = document.getElementById('nav-user'); 
    const trigger = document.querySelector('.nav-user-trigger');
    const dropdown = document.getElementById('nav-dropdown');

    if (!user || !dropdown || !trigger) return;

    // abrir / cerrar
    // trigger.addEventListener('click', (e) => {
    //     e.stopPropagation();
    //     dropdown.classList.toggle('active');
    // });

    trigger.addEventListener('click', (e) => {
    console.log("CLICK NAVBAR"); // 👈 IMPORTANTE
    e.stopPropagation();
    dropdown.classList.toggle('active');
    console.log(dropdown.classList); // 👈 VER ESTO
});

    // evitar cierre al hacer click dentro
    dropdown.addEventListener('click', (e) => {
        e.stopPropagation();
    });

    // cerrar al hacer click fuera
    document.addEventListener('click', (e) => {
        if (!user.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });
}