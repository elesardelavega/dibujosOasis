<?php

/**
 * Single Product template override
 * Tema hijo: Astra Child
 */

defined('ABSPATH') || exit;

get_header(); ?>

<?php
$product_title = get_the_title();
?>

<div class="hero-product" style="background-image: url('http://localhost:8000/wp-content/uploads/2025/12/g3122b6177fa9bc2df9d1f201eae40518e2b15e1e55012520f7618811c727d6fd35751d45c6e520fb4eb5206ac10be403ec2afac98295be5ffa9ab9b9dc188a3f_1280-4748911.jpg');">

    <div class="hero-overlay"></div>

    <div id="hero-name-page" class="wp-block-uagb-container hero-name-page uagb-block-wadawqbb alignfull uagb-is-root-container">
        <div class="uagb-container-inner-blocks-wrap">
            <div data-aos="zoom-in-right" data-aos-duration="400" data-aos-delay="0" data-aos-easing="ease" data-aos-once="true" class="wp-block-uagb-info-box uagb-block-y1flyddo uagb-infobox__content-wrap uagb-infobox-icon-above-title uagb-infobox-image-valign-top aos-init aos-animate">
                <div class="uagb-ifb-content">
                    <div class="uagb-ifb-title-wrap">
                        <p class="uagb-ifb-title-prefix">Add Your Prefix Here</p>
                        <h1 class="uagb-ifb-title"><?php echo esc_html($product_title); ?></h1>
                    </div>
                    <p class="uagb-ifb-desc">In this page header section, you can provide details about the purpose of the page. This helps users quickly understand what to expect from the page content.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="astra-single-product-wrapper" style="max-width:1240px;margin:0 auto;padding:20px;    width: 100%;">
    <?php
    /**
     * Hook antes del producto
     */
    do_action('woocommerce_before_single_product');

    if (post_password_required()) {
        echo get_the_password_form();
        return;
    }
    ?>

    <div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

        <?php
        /**
         * Hook: woocommerce_before_single_product_summary
         * Normalmente contiene la imagen y galería del producto
         */
        do_action('woocommerce_before_single_product_summary');
        ?>

        <div class="summary entry-summary">
            <?php
            /**
             * Hook: woocommerce_single_product_summary
             * Muestra título, precio, descripción corta, botón de añadir al carrito, etc.
             */
            do_action('woocommerce_single_product_summary');
            ?>
        </div>

        <?php
        /**
         * Hook: woocommerce_after_single_product_summary
         * Contenido adicional como tabs, upsells, productos relacionados
         */
        do_action('woocommerce_after_single_product_summary');
        ?>

    </div> <!-- #product -->

    <?php do_action('woocommerce_after_single_product'); ?>

</div> <!-- .astra-single-product-wrapper -->

<?php
get_footer('shop');
?>