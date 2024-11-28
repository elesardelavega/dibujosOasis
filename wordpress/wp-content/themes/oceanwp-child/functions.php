<?php
// Cargar estilos del tema padre y del tema hijo
function oceanwp_child_enqueue_styles() {
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
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
