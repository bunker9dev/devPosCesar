function showSection(id) {
    document.querySelectorAll('.section').forEach(sec => {
        sec.classList.remove('active');
    });

    document.getElementById(id).classList.add('active');
}
// #################################################            ################################################# 

// #################################################    NAVBAR  ################################################# 
// Toggle dropdown usuario
document.addEventListener("DOMContentLoaded", () => {

    const user = document.getElementById('nav-user');
    const dropdown = document.getElementById('nav-dropdown');
    const toggle = document.getElementById('nav-toggle');

    if (!user || !dropdown) {
        console.log("Navbar no encontrado");
        return;
    }

    console.log("NAVBAR OK");

    // Toggle dropdown
    user.addEventListener('click', (e) => {
        console.log("CLICK NAVBAR");
        e.stopPropagation();
        dropdown.classList.toggle('active');
    });

    // Cerrar si hace click fuera
    document.addEventListener('click', (e) => {
        if (!user.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });

    // Botón menú
    if (toggle) {
        toggle.addEventListener('click', () => {
            console.log("Toggle sidebar");
        });
    }

});



// #################################################            ################################################# 

// console.log("navbar funcionando");