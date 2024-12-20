<?php
function oceanwp_child_enqueue_styles() {
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style('child-style', get_stylesheet_uri(), array('parent-style'));
}
add_action('wp_enqueue_scripts', 'oceanwp_child_enqueue_styles');

add_filter('woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby');

function custom_woocommerce_catalog_orderby($sortby) {
	$sortby = array(
		'popularity' => __('Ordenar por popularidad', 'woocommerce'),
		'date'       => __('Ordenar por los más recientes', 'woocommerce'),
		'date-desc'  => __('Ordenar por los más antiguos', 'woocommerce'),
		'price'      => __('Ordenar por precio: bajo a alto', 'woocommerce'),
		'price-desc' => __('Ordenar por precio: alto a bajo', 'woocommerce'),
		'title_asc' => __('Ordenar alfabéticamente: A-Z', 'woocommerce'),
	);

	return $sortby;
}

function agregar_functions_js() {
	wp_enqueue_script(
		'mi-functions-js',
		'/wp-content/themes/oceanwp-child/js/functions.js',
		array(),
		'1.0.0',
		false
	);
}
add_action('wp_enqueue_scripts', 'agregar_functions_js');

add_action('woocommerce_product_additional_information', 'add_line_below_additional_info_table', 20);

function add_line_below_additional_info_table() {
	echo '<p class="custom-additional-info">Todos los pedidos incluyen un obsequio.</p>';
}

function enqueue_swiper_slider() {
	wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css', array(), null);

	wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array('jquery'), null, true);

	wp_enqueue_script('custom-swiper-init', get_stylesheet_directory_uri() . '/js/custom-swiper.js', array('swiper-js'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_swiper_slider');

add_action( 'wp_enqueue_scripts', function() {
	remove_theme_support( 'wc-product-gallery-zoom' );
}, 99 );

add_filter('woocommerce_get_availability_text', 'custom_out_of_stock_text', 10, 2);

function custom_out_of_stock_text($text, $product) {
	if (!$product->is_in_stock()) {
		$text = 'No disponible';
	}
	return $text;
}