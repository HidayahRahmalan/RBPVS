// Add event listener to the dropdown toggle button
document.addEventListener("DOMContentLoaded", function () {
    const dropdownToggle = document.querySelector(".dropdown-toggle");
    dropdownToggle.addEventListener("click", function () {
      // Toggle the dropdown menu
      const dropdownMenu = document.querySelector(".dropdown-menu");
      dropdownMenu.classList.toggle("show");
    });
  });
  
  // Add event listener to the navbar toggler button
  document.addEventListener("DOMContentLoaded", function () {
    const navbarToggler = document.querySelector(".navbar-toggler");
    navbarToggler.addEventListener("click", function () {
      // Toggle the navbar collapse
      const navbarCollapse = document.querySelector(".collapse.navbar-collapse");
      navbarCollapse.classList.toggle("show");
    });
  });