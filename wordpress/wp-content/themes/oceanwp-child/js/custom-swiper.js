document.addEventListener('DOMContentLoaded', function () {
    // Inicializar el slider con Swiper.js
    var swiper = new Swiper('.swiper-container', {
        loop: false,
        navigation: {
            nextEl: false,
            prevEl: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        slidesPerView: 4,
        spaceBetween: 10,
    });

    // Seleccionar la imagen destacada principal
    var featuredImage = document.querySelector('.woocommerce-product-gallery__image img');

    // Seleccionar todas las miniaturas del slider
    var galleryImages = document.querySelectorAll('.swiper-slide img');

    // Añadir evento click a cada miniatura
    galleryImages.forEach(function (image) {
        image.addEventListener('click', function () {
            // Cambiar el src de la imagen destacada al src de la miniatura
            featuredImage.src = this.src;

            // Opcional: Cambiar también el atributo srcset y data-large_image si es necesario
            featuredImage.srcset = this.src;
            featuredImage.dataset.large_image = this.src;
        });
    });
});

document.querySelectorAll('.swiper-button-next, .swiper-button-prev').forEach(function (button) {
    button.remove();
});
