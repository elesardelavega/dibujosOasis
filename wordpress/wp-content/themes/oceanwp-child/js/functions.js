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

    // Verifica si el contenedor .woocommerce div.product existe
    const productContainer = document.querySelector('.woocommerce div.product');

    const titleDescription = document.querySelector('.summary.entry-summary');

    if (productContainer) {
        // Encuentra el bloque de pestañas de descripción e información adicional
        const tabsWrapper = document.querySelector('.woocommerce-tabs.wc-tabs-wrapper');

        if (tabsWrapper) {
            // Mueve el bloque de pestañas dentro del contenedor del producto
            titleDescription.appendChild(tabsWrapper);
        }
    }

});
