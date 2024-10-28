<?php
// Cargar estilos del tema padre y del tema hijo
function oceanwp_child_enqueue_styles() {
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('child-style', get_stylesheet_uri(), array('parent-style'));
}
add_action('wp_enqueue_scripts', 'oceanwp_child_enqueue_styles');
