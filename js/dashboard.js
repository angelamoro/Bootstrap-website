document.addEventListener("DOMContentLoaded", function () {
   
    document.querySelector("#show-form").addEventListener("click", function () {
        document.querySelector(".popupI").classList.add("active");
    });
    document.querySelector(".popupI .close-btn").addEventListener("click", function () {
        document.querySelector(".popupI").classList.remove("active");
    }); 
});

document.addEventListener("DOMContentLoaded", function () {
   
    document.querySelector("#show-form1").addEventListener("click", function () {
        document.querySelector(".popupE").classList.add("active");
    });
    document.querySelector(".popupE .close-btn").addEventListener("click", function () {
        document.querySelector(".popupE").classList.remove("active");
    }); 
});
