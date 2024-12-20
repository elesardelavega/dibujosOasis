<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$attachment_ids = $product->get_gallery_image_ids();

if ( $attachment_ids && $product->get_image_id() ) {
	?>
	<div class="swiper-container product-gallery-slider">
		<div class="swiper-wrapper">
			<?php
			global $product;
			$attachment_ids = $product->get_gallery_image_ids();

			// Agregar las imágenes al slider
			foreach ($attachment_ids as $attachment_id) {
				$image_url = wp_get_attachment_image_url($attachment_id, 'large');
				echo '<div class="swiper-slide"><img src="' . esc_url($image_url) . '" alt="Product Image"></div>';
			}
			?>
		</div>

		<!-- Botones de navegación -->
		<div class="swiper-button-next"></div>
		<div class="swiper-button-prev"></div>

		<!-- Paginación -->
		<div class="swiper-pagination"></div>
	</div>
	<?php
}
