<?php
// Cargar estilos del tema padre y del tema hijo
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

add_action('woocommerce_before_calculate_totals', 'add_generic_product_to_cart');

function add_generic_product_to_cart($cart) {
	if (is_admin() || did_action('woocommerce_before_calculate_totals') >= 2) {
		return;
	}

	$generic_product_id = 899;

	$has_generic_product = false;
	$cart_has_other_products = false;

	foreach ($cart->get_cart() as $cart_item) {
		if ($cart_item['product_id'] == $generic_product_id) {
			$has_generic_product = true;
		} else {
			$cart_has_other_products = true;
		}
	}

	if ($cart_has_other_products && !$has_generic_product) {
		$cart->add_to_cart($generic_product_id);
	}

	// Elimina el producto genérico si no hay otros productos
	if (!$cart_has_other_products && $has_generic_product) {
		foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
			if ($cart_item['product_id'] == $generic_product_id) {
				$cart->remove_cart_item($cart_item_key);
			}
		}
	}
}

add_action('pre_get_posts', 'hide_generic_product_from_shop');

function hide_generic_product_from_shop($query) {
	if (!is_admin() && $query->is_main_query() && (is_shop() || is_product_category() || is_product_tag())) {
		$generic_product_id = 899; // Cambia 123 por el ID del producto genérico
		$query->set('post__not_in', array($generic_product_id));
	}
}

