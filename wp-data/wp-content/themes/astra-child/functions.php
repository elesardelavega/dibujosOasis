<?php
add_action('wp_enqueue_scripts', 'astra_child_enqueue_styles');
function astra_child_enqueue_styles()
{
    wp_enqueue_style('astra-parent-style', get_template_directory_uri() . '/style.css');

    wp_enqueue_style('astra-child-style', get_stylesheet_directory_uri() . '/style.css', array('astra-parent-style'));
}

// Desactiva el título y fuerza el layout de ancho completo para productos individuales
add_filter('astra_the_title_enabled', 'dibujosoasis_disable_single_product_title');

function dibujosoasis_disable_single_product_title($enabled)
{
    if (is_product()) {
        return false; // Desactiva el título nativo del producto
    }
    return $enabled;
}

// Opcional: Forzar layout de ancho completo si el Hero no se extiende
// Nota: La configuración del Customizer de Astra > Layout > WooCommerce suele ser más fácil.
// Pero si necesita código:
add_filter('astra_page_layout', 'dibujosoasis_full_width_product_layout');

function dibujosoasis_full_width_product_layout($layout)
{
    if (is_product()) {
        // 'full-width' es el ID de Astra para el diseño sin contenedor
        $layout = 'full-width';
    }
    return $layout;
}

// --- MOVER PESTAÑAS (TABS) DENTRO DEL RESUMEN DEL PRODUCTO ---

/**
 * Mueve la función de pestañas de woocommerce_after_single_product_summary 
 * a woocommerce_single_product_summary.
 */
function dibujosoasis_move_product_tabs_to_summary()
{
    // 1. Desconectar la función de su hook original (después del resumen)
    // El hook original tiene prioridad 10 por defecto
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

    // 2. Conectar la función al hook del resumen (dentro de la columna derecha)
    // Usamos una prioridad alta (ej. 55) para que vaya después del botón y metadatos (30, 40)
    add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 55);
}

add_action('wp_loaded', 'dibujosoasis_move_product_tabs_to_summary');