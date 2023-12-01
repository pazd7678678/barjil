<?php
/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */


if (!function_exists('twentytwentytwo_support')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * @return void
     * @since Twenty Twenty-Two 1.0
     *
     */
    function twentytwentytwo_support()
    {

        // Add support for block styles.
        add_theme_support('wp-block-styles');

        // Enqueue editor styles.
        add_editor_style('style.css');
    }

endif;

add_action('after_setup_theme', 'twentytwentytwo_support');

if (!function_exists('twentytwentytwo_styles')) :

    /**
     * Enqueue styles.
     *
     * @return void
     * @since Twenty Twenty-Two 1.0
     *
     */
    function twentytwentytwo_styles()
    {
        // Register theme stylesheet.
        $theme_version = wp_get_theme()->get('Version');

        $version_string = is_string($theme_version) ? $theme_version : false;
        wp_register_style(
            'twentytwentytwo-style',
            get_template_directory_uri() . '/style.css',
            array(),
            $version_string
        );

        // Enqueue theme stylesheet.
        wp_enqueue_style('twentytwentytwo-style');
    }

endif;

add_action('wp_enqueue_scripts', 'twentytwentytwo_styles');

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';

// INSERT PRODUCT_ID
//////////////////////////////////////////


add_filter('manage_edit-product_columns', 'add_product_id_column');
function add_product_id_column($columns)
{
    $columns['product_id'] = __('آی دی', 'woocommerce');
    return $columns;
}

add_action('manage_product_posts_custom_column', 'add_product_id_column_content', 10, 2);
function add_product_id_column_content($column, $post_id)
{
    if ('product_id' === $column) {
        echo $post_id;
    }
}

add_filter('manage_edit-product_sortable_columns', 'add_product_id_column_sortable');
function add_product_id_column_sortable($sortable_columns)
{
    $sortable_columns['product_id'] = 'ID';
    return $sortable_columns;
}


add_filter('manage_product_posts_columns', 'add_customization_column');
function add_customization_column($columns)
{
    $columns['customization'] = __('سفارشی سازی', 'woocommerce');
    return $columns;
}

add_action('manage_product_posts_custom_column', 'display_customization_column', 10, 2);
function display_customization_column($column, $post_id)
{
    if ($column == 'customization') {
        $product = wc_get_product($post_id);
        if ($product->get_meta('_product_addons')) {
            echo '<span class="dashicons dashicons-yes"></span>';
        } else {
            echo '<span class="dashicons dashicons-no"></span>';
        }
    }
}

