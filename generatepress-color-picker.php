<?php
/**
 * Plugin Name: GeneratePress Color Palette for WP Color Picker
 * Description: Integrates the GeneratePress Global Color Palette into the WordPress admin color picker (Iris).
 * Version: 1.0.4
 * Author: Weave Digital Studio
 * License: GPL-2.0+
 * Text Domain: gp-color-picker
 */

// Prevent direct access to the file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Check if the active theme is GeneratePress or a child theme of GeneratePress.
 *
 * @return bool True if GeneratePress or its child theme is active, false otherwise.
 */
function generatepress_is_active() {
    $theme = wp_get_theme();
    return ( 'GeneratePress' === $theme->get( 'Name' ) || 'generatepress' === $theme->get_template() );
}

/**
 * Fetch GeneratePress global colors for localization.
 *
 * @return array Localized palette colors.
 */
function generatepress_get_palette_colors() {
    if ( ! generatepress_is_active() || ! function_exists( 'generate_get_global_colors' ) ) {
        return [];
    }

    return array_map( function( $color ) {
        return $color['color'];
    }, generate_get_global_colors() );
}

/**
 * Enqueue scripts and localize GeneratePress palette.
 */
function generatepress_enqueue_color_picker_script() {
    $palette = generatepress_get_palette_colors();

    if ( empty( $palette ) ) {
        return;
    }

    wp_enqueue_script(
        'generatepress-color-picker',
        plugin_dir_url( __FILE__ ) . 'js/gp-color-picker.js',
        [ 'wp-color-picker' ],
        '1.0.4',
        true
    );

    wp_localize_script( 'generatepress-color-picker', 'generatePressPalette', $palette );
}
add_action( 'admin_enqueue_scripts', 'generatepress_enqueue_color_picker_script' );
