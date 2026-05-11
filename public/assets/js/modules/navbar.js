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
    const dropdown = document.getElementById('nav-dropdown');
    const toggle = document.getElementById('nav-toggle');

    if (!user || !dropdown) return;

    // Toggle dropdown
    user.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('active');
    });

    // Click fuera
    document.addEventListener('click', () => {
        dropdown.classList.remove('active');
    });

    // Botón sidebar (futuro)
    if (toggle) {
        toggle.addEventListener('click', () => {
            console.log("Toggle sidebar");
        });
    }
}