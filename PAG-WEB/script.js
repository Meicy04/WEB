document.querySelectorAll('.accordion').forEach(button => {
    button.addEventListener('click', () => {
      const panel = button.nextElementSibling;
  
      document.querySelectorAll('.panel').forEach(p => {
        if (p !== panel) {
          p.classList.remove('show');
        }
      });
  
      panel.classList.toggle('show');
    });
  });
  