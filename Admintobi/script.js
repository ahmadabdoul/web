function showSection(sectionName) {
    // Hide all sections first
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
      section.classList.remove('active');
    });
  
    // Show the selected section
    const selectedSection = document.querySelector(`.${sectionName}`);
    if (selectedSection) {
      selectedSection.classList.add('active');
    }
  }
  
  function logout() {
    // Implement logout functionality here
    // For demo purposes, we can simply redirect to the login page
    window.location.href = 'login.html';
  }
  