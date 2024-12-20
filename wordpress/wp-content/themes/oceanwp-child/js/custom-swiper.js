document.addEventListener('DOMContentLoaded', function () {
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

    var featuredImage = document.querySelector('.woocommerce-product-gallery__image img');

    var galleryImages = document.querySelectorAll('.swiper-slide img');

    galleryImages.forEach(function (image) {
        image.addEventListener('click', function () {
            featuredImage.src = this.src;
            featuredImage.srcset = this.src;
            featuredImage.dataset.large_image = this.src;
        });
    });
});

document.querySelectorAll('.swiper-button-next, .swiper-button-prev').forEach(function (button) {
    button.remove();
});
