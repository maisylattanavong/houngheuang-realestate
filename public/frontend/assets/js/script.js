const toggleButton = document.getElementsByClassName("toggle-button")[0];
const navbarLinks = document.getElementsByClassName("navbar-links")[0];

toggleButton.addEventListener("click", () => {
    navbarLinks.classList.toggle("active");
});

let navlinks = document.querySelectorAll(".nav-links");
navlinks.forEach((a) => {
    a.addEventListener("click", function () {
        navlinks.forEach((a) => a.classList.remove("active"));
        this.classList.add("active");
    });
});
