document.addEventListener("DOMContentLoaded", function() {
    // Verifica si estás en la URL "/tienda/"
    if (window.location.pathname === "/tienda/") {
        // Selecciona todos los elementos de lista del menú
        const menuItems = document.querySelectorAll("#site-navigation-wrap .dropdown-menu > li");

        // Itera sobre los elementos encontrados
        menuItems.forEach(function(item) {
            // Busca el enlace y el span dentro del elemento de lista
            const link = item.querySelector("a.menu-link > span");
            if (link && link.textContent.trim() === "Tienda") {
                // Agrega la clase "current-menu-item" al <li>
                item.classList.add("current-menu-item");
            }
        });
    }
});
