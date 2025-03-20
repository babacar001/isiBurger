document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("darkModeToggle");
    const body = document.body;

    // Vérifier si l'élément existe pour éviter les erreurs
    if (!toggleButton) {
        console.error("Erreur : le bouton de mode sombre n'a pas été trouvé !");
        return;
    }

    // Vérifier si le mode sombre est activé dans localStorage
    if (localStorage.getItem("darkMode") === "enabled") {
        body.classList.add("dark-mode");
        toggleButton.textContent = "☀️ Mode clair";
    }

    // Ajouter un écouteur d'événement au bouton
    toggleButton.addEventListener("click", function () {
        if (body.classList.contains("dark-mode")) {
            body.classList.remove("dark-mode");
            localStorage.setItem("darkMode", "disabled");
            toggleButton.textContent = "🌙 Mode sombre";
        } else {
            body.classList.add("dark-mode");
            localStorage.setItem("darkMode", "enabled");
            toggleButton.textContent = "☀️ Mode clair";
        }
    });

});
