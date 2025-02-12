<?php
namespace ACFWF\Models\Third_Party_Integrations;

use ACFWF\Abstracts\Abstract_Main_Plugin_Class;
use ACFWF\Abstracts\Base_Model;
use ACFWF\Helpers\Helper_Functions;
use ACFWF\Helpers\Plugin_Constants;
use ACFWF\Interfaces\Model_Interface;
use ACFWF\Models\Objects\Advanced_Coupon;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Model that houses the logic of the PushEngage module.
 *
 * @since 4.6.4
 */
class PushEngage extends Base_Model implements Model_Interface {
    /*
    |--------------------------------------------------------------------------
    | Class Properties
    |--------------------------------------------------------------------------
     */

    /**
     * Custom REST API base.
     *
     * @since 4.6.4
     * @access private
     * @var string
     */
    private $_base = 'sendcoupon/pushengage';

    /*
    |--------------------------------------------------------------------------
    | Class Methods
    |--------------------------------------------------------------------------
     */

    /**
     * Class constructor.
     *
     * @since 4.6.4
     * @access public
     *
     * @param Abstract_Main_Plugin_Class $main_plugin      Main plugin object.
     * @param Plugin_Constants           $constants        Plugin constants object.
     * @param Helper_Functions           $helper_functions Helper functions object.
     */
    public function __construct( Abstract_Main_Plugin_Class $main_plugin, Plugin_Constants $constants, Helper_Functions $helper_functions ) {
        parent::__construct( $main_plugin, $constants, $helper_functions );
        $main_plugin->add_to_all_plugin_models( $this );
    }

    /**
     * Register settings API routes.
     *
     * @since 4.6.4
     * @access public
     */
    public function register_routes() {
        \register_rest_route(
            Plugin_Constants::REST_API_NAMESPACE,
            '/' . $this->_base,
            array(
                array(
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'permission_callback' => array( $this, 'get_admin_permissions_check' ),
                    'callback'            => array( $this, 'send_coupon_pushengage' ),
                ),
            )
        );
    }

    /**
     * Checks if a given request has access to read list of settings options.
     *
     * @since 4.6.4
     * @access public
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function get_admin_permissions_check( $request ) {
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return new \WP_Error( 'rest_forbidden_context', __( 'Sorry, you are not allowed to edit settings options.', 'advanced-coupons-for-woocommerce-free' ), array( 'status' => \rest_authorization_required_code() ) );
        }

        return apply_filters( 'acfw_get_pushengage_admin_permissions_check', true, $request );
    }

    /**
     * Send the coupon pushengage.
     *
     * @since 4.6.4
     * @access public
     *
     * @param WP_REST_Request $request Send coupon pushengage request data.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error on failure.
     */
    public function send_coupon_pushengage( $request ) {

        $params = $this->_helper_functions->api_sanitize_query_parameters( $request->get_params() );

        // Invalidate request when the required parameters are missing.
        if ( ! isset( $params['coupon_id'] ) || ! isset( $params['segment_ids'] ) || ! isset( $params['title'] ) || ! isset( $params['message'] ) || ! isset( $params['url'] ) ) {
            return new \WP_Error(
                'acfw_missing_params',
                __( 'There was an error in the process of sending the pushengage to the customer. Please try again.', 'advanced-coupons-for-woocommerce-free' ),
                array(
                    'status' => 400,
                    'data'   => $params,
                )
            );
        }

        $coupon = isset( $params['coupon_id'] ) ? new Advanced_Coupon( $params['coupon_id'] ) : null;

        // Invalidate request when the coupon is invalid.
        if ( ! $coupon instanceof Advanced_Coupon || ! $coupon->get_id() ) {
            return new \WP_Error(
                'acfw_invalid_coupon',
                __( 'Invalid coupon.', 'advanced-coupons-for-woocommerce-free' ),
                array(
                    'status' => 400,
                    'data'   => $params,
                )
            );
        }

        $pushengage_api = \Pushengage\Includes\Api\PushengageAPI::instance();

        $replacements = array(
            '{storename}'   => get_bloginfo( 'name', 'display' ),
            '{coupon_code}' => $coupon->get_code(),
        );

        // Build the pushengage params.
        $pushengage_params = array(
            'notification_title'   => str_replace( array_keys( $replacements ), array_values( $replacements ), $params['title'] ),
            'notification_message' => str_replace( array_keys( $replacements ), array_values( $replacements ), $params['message'] ),
            'notification_url'     => $params['url'],
        );

        // Add the segments filter to notification criteria.
        if ( is_array( $params['segment_ids'] ) ) {
            $pushengage_params['include_segments']      = array_map( 'strval', $params['segment_ids'] );
            $pushengage_params['notification_criteria'] = array(
                'filter' => array(
                    'value' => array(
                        array(
                            array(
                                'field' => 'segments',
                                'op'    => 'in',
                                'value' => $pushengage_params['include_segments'],
                            ),
                        ),
                    ),
                ),
            );
        }

        $response = $pushengage_api->send_notification( $pushengage_params );

        if ( is_wp_error( $response ) ) {
            return new \WP_Error(
                'acfw_pushengage_error',
                $response->get_error_message(),
                array( 'status' => 400 )
            );
        }

        return \rest_ensure_response(
            array(
                /* Translators: %s: Segment. */
                'message' => sprintf( __( 'The coupon has been successfully sent to %s.', 'advanced-coupons-for-woocommerce-free' ), implode( ', ', (array) $params['segments'] ) ),
            )
        );
    }

    /**
     * Update pushengage affiliate after install and activate plugin.
     *
     * @since 4.6.4
     * @access public
     *
     * @param string         $plugin_slug Filtered plugin slug.
     * @param bool|\WP_Error $result Filtered result install activate plugin.
     */
    public function update_pushengage_promote_after_install_activate_plugin( $plugin_slug, $result ) {

        // If plugin is not pushengage, then return.
        if ( 'pushengage' !== $plugin_slug ) {
            return;
        }

        // Set pushengage_installed_by if the result is true.
        if ( ! is_wp_error( $result ) ) {
            update_option( 'pushengage_installed_by', 'acfw' );
        }
    }

    /**
     * Register send coupon localized data.
     *
     * @since 4.6.4
     * @access public
     *
     * @param array $data Localized data.
     * @return array Filtered localized data.
     */
    public function register_pushengage_localized_data( $data ) {
        global $post;

        $pushengage_api = null;
        $segments       = array();

        // Check if the PushEngage plugin is active.
        if ( $this->_helper_functions->is_plugin_active( Plugin_Constants::PUSHENGAGE_PLUGIN ) ) {
            $pushengage_api = \Pushengage\Includes\Api\PushengageAPI::instance();
            $segments       = $pushengage_api->is_site_connected() && ! is_wp_error( $pushengage_api->get_segments() ) ? $pushengage_api->get_segments()['data'] : array();
        }

        $data['send_coupon']['pushengage'] = array(
            'segments'        => $segments,
            'storename'       => get_bloginfo( 'name', 'display' ),
            'coupon_code'     => $post->post_title,
            'default_content' => array(
                /* Translators: %s: storename. */
                'title'   => sprintf( __( 'You have received a coupon from %s', 'advanced-coupons-for-woocommerce-free' ), '{storename}' ),
                /* Translators: %s: coupon code. */
                'message' => sprintf( __( 'Get a discount with your next order using the coupon %s', 'advanced-coupons-for-woocommerce-free' ), '{coupon_code}' ),
                'url'     => get_permalink( wc_get_page_id( 'shop' ) ),
            ),
        );

        if ( $pushengage_api && is_wp_error( $pushengage_api->get_segments() ) ) {
            $error         = $pushengage_api->get_segments();
            $error_message = $error->get_error_message();

            $pushengage_site_url = admin_url( 'admin.php?page=pushengage' );

            $data['send_coupon']['is_pushengage_error'] = true;

            $data['send_coupon']['labels']['description']['pushengage_error'] = sprintf(
                '<div class="pushengage-logo"><img src="%s"/></div> %s <a href="%s" class="button button-primary acfw-button-pushengage-connect">%s</a>',
                $this->_constants->IMAGES_ROOT_URL . 'pushengage-logo.svg',
                $error_message,
                esc_url( $pushengage_site_url ),
                __( 'Click Here to Check PushEngage Connection', 'advanced-coupons-for-woocommerce-free' ),
            );
        }

        return $data;
    }

    /**
     * Execute PushEngage class.
     *
     * @since 4.6.4
     * @access public
     * @inherit ACFWF\Interfaces\Model_Interface
     */
    public function run() {
        if ( $this->_helper_functions->is_plugin_active( Plugin_Constants::PUSHENGAGE_PLUGIN ) ) {
            add_action( 'rest_api_init', array( $this, 'register_routes' ) );
        }

        add_action( 'acfw_after_install_activate_plugin', array( $this, 'update_pushengage_promote_after_install_activate_plugin' ), 10, 2 );
        add_filter( 'acfw_edit_advanced_coupon_localize', array( $this, 'register_pushengage_localized_data' ), 11, 1 );
    }
}
