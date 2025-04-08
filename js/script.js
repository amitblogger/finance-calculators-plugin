document.addEventListener('DOMContentLoaded', function () {
  const toggleBtn = document.getElementById('fcp-theme-toggle');
  if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
      document.body.classList.toggle('fcp-dark-mode');
    });
  }
});

