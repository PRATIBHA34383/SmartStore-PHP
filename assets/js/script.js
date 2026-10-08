document.addEventListener("DOMContentLoaded", function () {
    console.log("SmartStore PHP loaded successfully.");

    document.querySelectorAll("button").forEach(function (button) {
        button.addEventListener("click", function () {
            console.log("Button clicked:", button.textContent.trim());
        });
    });
});
