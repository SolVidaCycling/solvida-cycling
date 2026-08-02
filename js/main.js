
const toggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.main-nav');
if (toggle && nav) {
  toggle.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    toggle.setAttribute('aria-expanded', String(open));
  });
}

const formStatus = document.querySelector('.form-status');
if (formStatus) {
  const status = new URLSearchParams(window.location.search).get('estado');
  if (status === 'enviado') {
    formStatus.textContent = 'Gracias por escribirme. Tu mensaje se ha enviado correctamente.';
    formStatus.classList.add('success');
  } else if (status === 'error') {
    formStatus.textContent = 'No se ha podido enviar el mensaje. Inténtalo de nuevo dentro de unos minutos.';
    formStatus.classList.add('error');
  }
}
