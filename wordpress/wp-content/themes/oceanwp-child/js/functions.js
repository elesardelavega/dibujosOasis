document.addEventListener("DOMContentLoaded", function() {
    if (window.location.pathname === "/tienda/") {
        const menuItems = document.querySelectorAll("#site-navigation-wrap .dropdown-menu > li");
        menuItems.forEach(function(item) {
            const link = item.querySelector("a.menu-link > span");
            if (link && link.textContent.trim() === "Tienda") {
                item.classList.add("current-menu-item");
            }
        });
    }

    const productContainer = document.querySelector('.woocommerce div.product');

    const titleDescription = document.querySelector('.summary.entry-summary');

    if (productContainer) {
        const tabsWrapper = document.querySelector('.woocommerce-tabs.wc-tabs-wrapper');
        if (tabsWrapper) {
            titleDescription.appendChild(tabsWrapper);
        }
    }

    const variationsElement = document.querySelector(' .woocommerce-variation.single_variation');
    const productMetaElement = document.querySelector('.woovr-variations.woovr-variations-select2');
    if (variationsElement && productMetaElement) {
        productMetaElement.appendChild(variationsElement);
    }

});
