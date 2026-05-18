function showSection(id) {
    document.querySelectorAll('.section').forEach(sec => {
        sec.classList.remove('active');
    });

    document.getElementById(id).classList.add('active');
}
// #################################################            ################################################# 

// #################################################    NAVBAR  ################################################# 
// Toggle dropdown usuario
const user = document.getElementById('nav-user');
const dropdown = document.getElementById('nav-dropdown');

user.addEventListener('click', () => {
    dropdown.classList.toggle('active');
});

// Cerrar si hace click fuera
document.addEventListener('click', (e) => {
    if (!user.contains(e.target)) {
        dropdown.classList.remove('active');
    }
});

// Botón menú (para sidebar futuro)
const toggle = document.getElementById('nav-toggle');

toggle.addEventListener('click', () => {
    console.log("Toggle sidebar"); // luego conectas tu sidebar aquí
});



// #################################################            ################################################# 

// console.log("navbar funcionando");