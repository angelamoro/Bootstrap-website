document.addEventListener("DOMContentLoaded", function () {
    // Tu código aquí
    document.querySelector("#show-form").addEventListener("click", function () {
        document.querySelector(".popup").classList.add("active");
    });
    document.querySelector(".popup .close-btn").addEventListener("click", function () {
        document.querySelector(".popup").classList.remove("active");
    }); 
});