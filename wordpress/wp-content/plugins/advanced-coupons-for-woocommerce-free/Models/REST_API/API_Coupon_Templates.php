<?php
namespace ACFWF\Models\REST_API;

use ACFWF\Abstracts\Abstract_Main_Plugin_Class;
use ACFWF\Helpers\Helper_Functions;
use ACFWF\Helpers\Plugin_Constants;
use ACFWF\Abstracts\Base_Model;
use ACFWF\Interfaces\Model_Interface;
use ACFWF\Models\Objects\Advanced_Coupon;
use ACFWF\Models\Coupon_Templates;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Model that houses the Settings module logic.
 * Public Model.
 *
 * @since 4.5.9
 */
class API_Coupon_Templates extends Base_Model implements Model_Interface {
    /*
    |--------------------------------------------------------------------------
    | Class Properties
    |--------------------------------------------------------------------------
     */

    /**
     * Custom REST API base.
     *
     * @since 4.5.9
     * @access private
     * @var string
     */
    private $_base = 'templates';

    /*
    |--------------------------------------------------------------------------
    | Class Methods
    |--------------------------------------------------------------------------
     */

    /**
     * Class constructor.
     *
     * @since 4.5.9
     * @access public
     *
     * @param Abstract_Main_Plugin_Class $main_plugin      Main plugin object.
     * @param Plugin_Constants           $constants        Plugin constants object.
     * @param Helper_Functions           $helper_functions Helper functions object.
     */
    public function __construct( Abstract_Main_Plugin_Class $main_plugin, Plugin_Constants $constants, Helper_Functions $helper_functions ) {
        parent::__construct( $main_plugin, $constants, $helper_functions );

        $main_plugin->add_to_all_plugin_models( $this );
        $main_plugin->add_to_public_models( $this );
    }

    /*
    |--------------------------------------------------------------------------
    | Routes.
    |--------------------------------------------------------------------------
     */

    /**
     * Register settings API routes.
     *
     * @since 4.5.9
     * @access public
     */
    public function register_routes() {
        \register_rest_route(
            Plugin_Constants::REST_API_NAMESPACE,
            '/' . $this->_base,
            array(
                array(
                    'methods'             => \WP_REST_Server::READABLE,
                    'permission_callback' => array( $this, 'get_admin_permissions_check' ),
                    'callback'            => array( $this, 'get_coupon_templates' ),
                ),
                array(
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'permission_callback' => array( $this, 'get_admin_permissions_check' ),
                    'callback'            => array( $this, 'create_coupon_from_template' ),
                ),
            )
        );

        \register_rest_route(
            Plugin_Constants::REST_API_NAMESPACE,
            '/' . $this->_base . '/(?P<id>[\d]+)',
            array(
                array(
                    'methods'             => \WP_REST_Server::READABLE,
                    'permission_callback' => array( $this, 'get_admin_permissions_check' ),
                    'callback'            => array( $this, 'get_single_coupon_template' ),
                ),
            )
        );

        \register_rest_route(
            Plugin_Constants::REST_API_NAMESPACE,
            '/' . $this->_base . '/recent',
            array(
                array(
                    'methods'             => \WP_REST_Server::READABLE,
                    'permission_callback' => array( $this, 'get_admin_permissions_check' ),
                    'callback'            => array( $this, 'get_recent_coupon_templates' ),
                ),
            )
        );

        \register_rest_route(
            Plugin_Constants::REST_API_NAMESPACE,
            '/' . $this->_base . '/recent/(?P<id>[\d]+)',
            array(
                array(
                    'methods'             => \WP_REST_Server::DELETABLE,
                    'permission_callback' => array( $this, 'get_admin_permissions_check' ),
                    'callback'            => array( $this, 'delete_recent_coupon_template' ),
                ),
            )
        );

        \register_rest_route(
            Plugin_Constants::REST_API_NAMESPACE,
            '/' . $this->_base . '/categories',
            array(
                array(
                    'methods'             => \WP_REST_Server::READABLE,
                    'permission_callback' => array( $this, 'get_admin_permissions_check' ),
                    'callback'            => array( $this, 'get_coupon_template_categories' ),
                ),
            )
        );

        \register_rest_route(
            Plugin_Constants::REST_API_NAMESPACE,
            '/' . $this->_base . '/categories/(?P<cat_slug>[a-zA-Z0-9-_]+)',
            array(
                array(
                    'methods'             => \WP_REST_Server::READABLE,
                    'permission_callback' => array( $this, 'get_admin_permissions_check' ),
                    'callback'            => array( $this, 'get_single_coupon_template_category' ),
                ),
            )
        );

        \register_rest_route(
            Plugin_Constants::REST_API_NAMESPACE,
            '/' . $this->_base . '/options',
            array(
                array(
                    'methods'             => \WP_REST_Server::READABLE,
                    'permission_callback' => array( $this, 'get_admin_permissions_check' ),
                    'callback'            => array( $this, 'get_coupon_template_field_options' ),
                ),
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Permissions.
    |--------------------------------------------------------------------------
     */

    /**
     * Checks if a given request has access to read list of settings options.
     *
     * @since 4.5.9
     * @access public
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     */
    public function get_admin_permissions_check( $request ) {
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return new \WP_Error( 'rest_forbidden_context', __( 'Sorry, you are not allowed to edit settings options.', 'advanced-coupons-for-woocommerce-free' ), array( 'status' => \rest_authorization_required_code() ) );
        }

        return apply_filters( 'acfw_get_emails_admin_permissions_check', true, $request );
    }

    /*
    |--------------------------------------------------------------------------
    | REST API methods.
    |--------------------------------------------------------------------------
     */

    /**
     * Get coupon templates.
     *
     * @since 4.5.9
     * @access public
     *
     * @param \WP_REST_Request $request Get coupon templates request data.
     * @return \WP_REST_Response Get coupon templates response data.
     */
    public function get_coupon_templates( $request ) {
        $path = $request->get_param( 'is_review' ) ? '/coupon-templates/review/page.json' : '/coupon-templates/page.json';
        $data = wp_remote_get( $this->_get_coupon_templates_server_base() . $path );

        if ( is_wp_error( $data ) ) {
            return $data;
        }

        $templates = json_decode( wp_remote_retrieve_body( $data ) ?? '[]', true );

        return rest_ensure_response( $templates );
    }

    /**
     * Create coupon post based on a given coupon template.
     *
     * @since 4.5.9
     * @access public
     *
     * @param \WP_REST_Request $request Create coupon post based on a given coupon template request data.
     * @return \WP_REST_Response Create coupon post based on a given coupon template response data.
     */
    public function create_coupon_from_template( $request ) {
        $id        = absint( $request->get_param( 'id' ) );
        $is_review = $request->get_param( 'is_review' ) ?? false;
        $fields    = $this->_sanitize_coupon_template_fields_data( $request->get_param( 'fields' ) );
        $coupon    = $this->_create_coupon_from_template( $fields, $id );

        if ( is_wp_error( $coupon ) ) {
            return $coupon;
        }

        // Save cart conditions data.
        $cart_conditions = $request->get_param( 'cart_conditions' );
        if ( ! empty( $cart_conditions ) ) {
            $cart_conditions = \ACFWF()->Cart_Conditions->sanitize_cart_conditions( $cart_conditions );
            \ACFWF()->Cart_Conditions->save_cart_conditions( $coupon, $cart_conditions );
        }

        $fields_response = array();

        foreach ( $fields as $field ) {
            $fixture           = $this->_get_field_fixture_data( $field['key'] );
            $fields_response[] = array(
                'key'   => $field['key'],
                'label' => $fixture['label'] ?? $field['key'],
                'value' => $this->_format_field_response_value( $field['key'], $field['display_value'] ?? $field['value'] ),
            );

            if ( 'coupon_code' === $field['key'] &&
                $coupon->get_advanced_prop( 'disable_url_coupon' ) !== 'yes' &&
                $this->_helper_functions->is_module( Plugin_Constants::URL_COUPONS_MODULE )
            ) {
                $fields_response[] = array(
                    'key'   => 'coupon_url',
                    'label' => __( 'Coupon URL', 'advanced-coupons-for-woocommerce-free' ),
                    'value' => $coupon->get_coupon_url(),
                );
            }
        }

        // Append template data to the recent templates list.
        $this->_set_coupon_template_as_recent( $id, $is_review );

        return rest_ensure_response(
            array(
                'status'          => 'success',
                'message'         => __( 'Coupon was created successfully!', 'advanced-coupons-for-woocommerce-free' ),
                'fields'          => $fields_response,
                'cart_conditions' => ! empty( $cart_conditions ) ? __( 'Can only be applied once the conditions match', 'advanced-coupons-for-woocommerce-free' ) : '',
                'coupon_id'       => $coupon->get_id(),
                'coupon_edit_url' => admin_url( 'post.php?post=' . $coupon->get_id() . '&action=edit' ),
            )
        );
    }

    /**
     * Get single coupon template.
     *
     * @since 4.5.9
     * @access public
     *
     * @param \WP_REST_Request $request Get single coupon template request data.
     * @return \WP_REST_Response Get single coupon template response data.
     */
    public function get_single_coupon_template( $request ) {
        $id        = absint( $request['id'] );
        $is_review = $request->get_param( 'is_review' ) ?? false;
        $template  = $this->_fetch_coupon_template_data( $id, $is_review );

        if ( is_wp_error( $template ) ) {
            return $template;
        }

        // prepend coupon code field.
        $template['fields'] = array(
            array(
                'field'            => 'coupon_code',
                'field_value'      => 'editable',
                'fixtures'         => $this->_get_field_fixture_data( 'coupon_code' ),
                'is_required'      => true,
                'pre_filled_value' => '',
            ),
            array(
                'field'            => 'discount_type',
                'field_value'      => 'editable',
                'fixtures'         => $this->_get_field_fixture_data( 'discount_type' ),
                'is_required'      => true,
                'pre_filled_value' => $template['discount_type'],
            ),
        );

        foreach ( $template['template_data'] as $row ) {
            $row['fixtures']      = $this->_get_field_fixture_data( $row['field'] );
            $template['fields'][] = $row;
        }

        if ( ! empty( $template['cart_conditions'] ) ) {
            $template['cart_conditions'] = $this->_prepare_template_cart_condition_data( $template['cart_conditions'] );
        }

        unset( $template['template_data'] );

        return rest_ensure_response( $template );
    }

    /**
     * Get recent coupon templates.
     *
     * @since 4.5.9
     * @access public
     *
     * @param \WP_REST_Request $request Get recent coupon templates request data.
     * @return \WP_REST_Response Get recent coupon templates response data.
     */
    public function get_recent_coupon_templates( $request ) {
        $recent_templates = get_option( $this->_constants->RECENT_COUPON_TEMPLATES, array() );

        return rest_ensure_response( array_values( $recent_templates ) );
    }

    /**
     * Delete recent coupon template from the list.
     *
     * @since 4.5.9
     * @access public
     *
     * @param \WP_REST_Request $request Delete recent coupon template request data.
     * @return \WP_REST_Response Delete recent coupon template response data.
     */
    public function delete_recent_coupon_template( $request ) {
        $id               = absint( $request['id'] );
        $recent_templates = get_option( $this->_constants->RECENT_COUPON_TEMPLATES, array() );

        // remove matching template from the list.
        $filtered_templates = array_filter(
            $recent_templates,
            function ( $t ) use ( $id ) {
                return $t['id'] !== $id;
            }
        );

        // Skip if there was nothing removed.
        if ( $recent_templates === $filtered_templates ) {
            return new \WP_Error(
                'acfw_invalid_coupon_template',
                __( 'Coupon template is invalid.', 'advanced-coupons-for-woocommerce-free' ),
                array( 'status' => 400 )
            );
        }

        update_option( $this->_constants->RECENT_COUPON_TEMPLATES, $filtered_templates );

        return rest_ensure_response(
            array(
                'status' => 'success',
            )
        );
    }

    /**
     * Get coupon template categories.
     *
     * @since 4.5.9
     * @access public
     *
     * @param \WP_REST_Request $request Get coupon template categories request data.
     * @return \WP_REST_Response Get coupon template categories response data.
     */
    public function get_coupon_template_categories( $request ) {
        $data = wp_remote_get( $this->_get_coupon_templates_server_base() . '/coupon-templates/categories.json' );

        if ( is_wp_error( $data ) ) {
            return $data;
        }

        $categories = json_decode( wp_remote_retrieve_body( $data ) ?? '[]', true );

        return rest_ensure_response( $categories );
    }

    /**
     * Get single coupon template category.
     *
     * @since 4.5.9
     * @access public
     *
     * @param \WP_REST_Request $request Get single coupon template category request data.
     * @return \WP_REST_Response Get single coupon template category response data.
     */
    public function get_single_coupon_template_category( $request ) {
        $slug = $request['cat_slug'];
        $data = wp_remote_get( $this->_get_coupon_templates_server_base() . '/coupon-templates/categories/' . $slug . '.json' );

        if ( is_wp_error( $data ) ) {
            return $data;
        }

        $category = json_decode( wp_remote_retrieve_body( $data ), true );

        if ( empty( $category ) ) {
            return new \WP_Error(
                'acfw_coupon_template_category_not_found',
                __( 'Coupon template category doesn’t exist.', 'advanced-coupons-for-woocommerce-free' ),
                array( 'status' => 400 )
            );
        }

        return rest_ensure_response( $category );
    }

    /**
     * Get the available options for a coupon template field based on the provided type.
     *
     * @since 4.6.0
     * @access public
     *
     * @param \WP_REST_Request $request Get coupon template categories request data.
     * @return \WP_REST_Response Get coupon template categories response data.
     */
    public function get_coupon_template_field_options( $request ) {
        $type   = sanitize_text_field( $request->get_param( 'type' ) );
        $search = sanitize_text_field( $request->get_param( 'search' ) );

        switch ( $type ) {
            case 'user_role':
                $options = $this->_helper_functions->get_default_allowed_user_roles();
                break;
            default:
                $options = array();
                break;
        }

        $response = array_map(
            function ( $label, $key ) {
                return array(
                    'value' => $key,
                    'label' => $label,
                );
            },
            $options,
            array_keys( $options )
        );

        return rest_ensure_response( $response );
    }

    /*
    |--------------------------------------------------------------------------
    | Query methods
    |--------------------------------------------------------------------------
     */

    /**
     * Fetch coupon template data by ID.
     *
     * @since 4.5.9
     * @access private
     *
     * @param int  $id Coupon template ID.
     * @param bool $is_review Flag if a template is on review status or not.
     * @return array Coupon template data.
     */
    private function _fetch_coupon_template_data( $id, $is_review = false ) {
        $path = '/coupon-templates/';

        if ( $is_review ) {
            $path .= 'review/';
        }

        $data = wp_remote_get( $this->_get_coupon_templates_server_base() . $path . 'templates/' . $id . '.json' );

        if ( is_wp_error( $data ) ) {
            return $data;
        }

        $template_data = json_decode( wp_remote_retrieve_body( $data ), true );

        if ( ! $template_data ) {
            return new \WP_Error(
                'acfw_coupon_template_not_found',
                __( 'Coupon template doesn’t exist.', 'advanced-coupons-for-woocommerce-free' ),
                array( 'status' => 404 )
            );
        }

        return $template_data;
    }

    /*
    |--------------------------------------------------------------------------
    | Utilities
    |--------------------------------------------------------------------------
     */

    /**
     * Get coupon templates server base.
     *
     * @since 4.5.9
     * @access private
     *
     * @return string Coupon templates server base.
     */
    private function _get_coupon_templates_server_base() {
        if ( defined( 'ACFW_COUPON_TEMPLATES_SERVER_BASE' ) && ACFW_COUPON_TEMPLATES_SERVER_BASE ) {
            return ACFW_COUPON_TEMPLATES_SERVER_BASE;
        }

        $custom_base = get_option( Coupon_Templates::COUPON_TEMPLATES_SERVER_BASE );
        if ( $custom_base ) {
            return $custom_base;
        }

        return 'https://plugin.advancedcouponsplugin.com';
    }

    /**
     * Get the fixture data (labels, options, description, tooltip, etc.) for a specific field.
     *
     * @since 4.5.9
     * @access public
     *
     * @param string $field_key Field key.
     * @return array Field fixutre data.
     */
    private function _get_field_fixture_data( $field_key ) {
        $field_data = include $this->_constants->DATA_ROOT_PATH . 'coupon-fields-fixture-data.php';

        if ( ! isset( $field_data[ $field_key ] ) ) {
            return array();
        }

        return $field_data[ $field_key ];
    }

    /**
     * Sanitize coupon template fields data.
     *
     * @since 4.6.0
     * @access private
     *
     * @param array $fields Coupon template fields.
     * @return array Sanitized coupon template fields data.
     */
    private function _sanitize_coupon_template_fields_data( $fields ) {
        // Sanitize coupon template form fields data.
        $sanitized = array_map(
            function ( $f ) {
                $value = $f['value'];

                switch ( $f['type'] ) {
                    case 'products':
                    case 'product_categories':
                    case 'coupons':
                    case 'customers':
                        $value              = array_column( (array) $f['value'], 'value' );
                        $f['display_value'] = (array) $f['value'];
                        $type               = 'arrayint';
                        break;

                    case 'user_role':
                        $type = 'array';
                        break;
                    default:
                        $type = $f['type'];
                        break;
                }

                $f['key'] = sanitize_text_field( $f['key'] );

                $f['value'] = $this->_helper_functions->api_sanitize_value( $value, $type );

                return $f;
            },
            $fields
        );

        return $sanitized;
    }

    /**
     * Format field response value.
     *
     * @since 4.6.0
     * @access private
     *
     * @param string $key Field key.
     * @param mixed  $value Field value.
     * @return string Formatted field value.
     */
    private function _format_field_response_value( $key, $value ) {
        if ( is_array( $value ) ) {
            $labels = array_column( $value, 'label' );

            if ( ! empty( $labels ) ) {
                return implode( ', ', $labels );
            }

            return implode( ', ', $value );
        }

        // Format discount type value to readable string.
        if ( 'discount_type' === $key ) {
            $discount_types = wc_get_coupon_types();
            return $discount_types[ $value ] ?? $value;
        }

        return $value;
    }

    /**
     * Create a coupon post based on a given coupon template.
     *
     * @since 4.6.0
     * @access private
     *
     * @param array $fields Coupon template fields.
     * @param int   $template_id Coupon template ID.
     * @return Advanced_Coupon|\WP_Error Advanced Coupon object or WP_Error object.
     */
    private function _create_coupon_from_template( $fields, $template_id ) {
        $coupon               = new \WC_Coupon();
        $global_cache_options = array();

        foreach ( $fields as $field ) {
            $key = $field['key'];
            if ( 'coupon_code' === $key ) {
                $coupon->set_code( $field['value'] );
            } elseif ( 'coupon_amount' === $key ) {
                $coupon->set_amount( $field['value'] );
            } elseif ( '_acfw_enable_coupon_url' === $key ) {
                $this->_add_coupon_meta_data( $coupon, Plugin_Constants::META_PREFIX . 'disable_url_coupon', 'yes' === $field['value'] ? '' : 'yes' );
            } elseif ( is_callable( array( $coupon, 'set_' . $key ) ) ) {
                $coupon->{"set_{$key}"}( $field['value'] );
            } elseif ( in_array( $field['key'], array( '_acfw_auto_apply_coupon', '_acfw_enable_apply_notification' ), true ) ) {
                $global_cache_options[ $field['key'] ] = $field['value'];
            } else {
                $this->_add_coupon_meta_data( $coupon, $key, $field['value'] );
            }
        }

        $check = $coupon->save();

        if ( ! $check ) {
            return new \WP_Error( 'failed_to_create_coupon', __( 'Failed to create coupon.', 'advanced-coupons-for-woocommerce-free' ), array( 'status' => 500 ) );
        }

        // Save a meta key that points back to the coupon template ID whenever a coupon is created via a template.
        $coupon->add_meta_data( '_acfw_coupon_from_template_ID', $template_id, true );

        $coupon->save_meta_data();

        if ( ! empty( $global_cache_options ) ) {
            foreach ( $global_cache_options as $key => $value ) {
                $this->_save_to_global_option_cache( $key, $value, $coupon->get_id() );
            }
        }

        return new Advanced_Coupon( $coupon );
    }

    /**
     * Save a coupon field value to the global option cache.
     * This is for saving the auto apply and apply notification options.
     *
     * @since 4.6.0
     * @access private
     *
     * @param string $key       Field key.
     * @param mixed  $value     Option value.
     * @param int    $coupon_id Coupon ID.
     */
    private function _save_to_global_option_cache( $key, $value, $coupon_id ) {
        $mapping     = array(
            '_acfw_auto_apply_coupon'         => 'acfw_auto_apply_coupons',
            '_acfw_enable_apply_notification' => 'acfw_apply_notifcation_cache',
        );
        $option_name = $mapping[ $key ] ?? false;

        if ( ! $option_name ) {
            return;
        }

        $global_option = $this->_helper_functions->get_option( $option_name, array() );

        if ( $value ) {
            $global_option[] = $coupon_id;
        } else {
            $key = array_search( $coupon_id, $global_option, true );
            if ( false !== $key ) {
                unset( $global_option[ $key ] );
            }
        }

        update_option( $option_name, array_unique( $global_option ) );
    }

    /**
     * Add meta data to a coupon object correctly by making sure it's either unique or not.
     *
     * @since 4.6.0
     * @access private
     *
     * @param \WC_Coupon $coupon Coupon object.
     * @param string     $key    Meta data key.
     * @param mixed      $value  Meta data value.
     */
    private function _add_coupon_meta_data( $coupon, $key, $value ) {
        $not_unique_keys = apply_filters(
            'acfw_coupon_meta_data_not_unique_keys',
            array(
                '_acfw_allowed_customers',
            )
        );

        if ( in_array( $key, $not_unique_keys, true ) ) {
            foreach ( $value as $item_value ) {
                $coupon->add_meta_data( $key, $item_value, false );
            }
        } else {
            $coupon->add_meta_data( $key, $value, true );
        }
    }

    /**
     * Set a coupon template as recently used.
     *
     * @since 4.6.0
     * @access public
     *
     * @param int  $template_id Coupon template ID.
     * @param bool $is_review Flag if a template is on review status or not.
     */
    private function _set_coupon_template_as_recent( $template_id, $is_review = false ) {
        $template_data = $this->_fetch_coupon_template_data( $template_id, $is_review );

        if ( is_wp_error( $template_data ) ) {
            return;
        }

        $recent_templates = get_option( $this->_constants->RECENT_COUPON_TEMPLATES, array() );

        // prepend the template data to the recent templates list.
        array_unshift( $recent_templates, $template_data );

        update_option(
            $this->_constants->RECENT_COUPON_TEMPLATES,
            $this->_helper_functions->array_unique_multidimensional( $recent_templates )
        );
    }

    /**
     * Prepare the cart condition data for the template.
     *
     * @since 4.6.3
     * @access private
     *
     * @param array $cart_conditions Cart conditions data.
     * @return array Prepared cart conditions data.
     */
    private function _prepare_template_cart_condition_data( $cart_conditions ) {
        $prepared    = array();
        $fields_i18n = \ACFWF()->Cart_Conditions->condition_fields_localized_data( array() );

        foreach ( $cart_conditions as $group ) {
            if ( 'group_logic' === $group['type'] ) {
                $prepared[] = $group;
                continue;
            }

            // Append the i18n data to the fields.
            $group['fields'] = array_map(
                function ( $field ) use ( $fields_i18n ) {
                    if ( 'logic' === $field['type'] ) {
                        return $field;
                    }

                    // append the translatable strings data to the condition fields.
                    $field_type    = str_replace( '-', '_', $field['type'] );
                    $field['i18n'] = isset( $fields_i18n['cart_condition_fields'][ $field_type ] ) ? $this->_helper_functions->decode_html_entities_recursive( $fields_i18n['cart_condition_fields'][ $field_type ] ) : array();

                    // Append user role options to the role related cart condition fields.
                    if ( strpos( $field['type'], 'customer-user-role' ) !== false ) {
                        $field['i18n']['options'] = $this->_helper_functions->get_default_allowed_user_roles();
                    }

                    return $field;
                },
                $group['fields']
            );

            $prepared[] = $group;
        }

        return $prepared;
    }

    /*
    |--------------------------------------------------------------------------
    | Fulfill implemented interface contracts
    |--------------------------------------------------------------------------
     */

    /**
     * Execute Settings class.
     *
     * @since 4.5.9
     * @access public
     * @inherit ACFWF\Interfaces\Model_Interface
     */
    public function run() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }
}
