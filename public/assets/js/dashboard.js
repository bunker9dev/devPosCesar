// 🔹 Animación al hacer scroll
const cards = document.querySelectorAll('.card');

const observer = new IntersectionObserver(entries => {
  entries.forEach((entry, i) => {
    if (entry.isIntersecting) {
      setTimeout(() => {
        entry.target.classList.add('show');
      }, i * 150); // delay en cascada
    }
  });
}, { threshold: 0.2 });

cards.forEach(card => observer.observe(card));


// 🔹 Contador animado
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