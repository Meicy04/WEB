document.querySelectorAll('.accordion').forEach(button => {
    button.addEventListener('click', () => {
      const panel = button.nextElementSibling;
  
      // Cerrar todos los paneles
      document.querySelectorAll('.panel').forEach(p => {
        if (p !== panel) {
          p.classList.remove('show');
        }
      });
  
      // Alternar el panel actual
      panel.classList.toggle('show');
    });
  });
  