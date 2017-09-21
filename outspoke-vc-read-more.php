<?php
/**
 * Plugin Name:       Outspoke VC Read More
 * Plugin URI:        https://outspoke.co
 * Description:       Custom Visual Composer element for clipping bits of text.
 * Version:           1.0.0
 * Author:            Jay Nielsen
 * Author URI:        https://outspoke.co
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Set up the VC Element
add_action( 'vc_before_init', function() {
    vc_map([
        "name" => "Outspoke Read More",
        "base" => "outspoke_read_more",
        "icon" => plugins_url('/assets/img/vc-icon.svg', __file__),
        "content_element" => true,
        "show_settings_on_create" => false,
        "is_container" => true,
        "params" => [
            [
                'type' => 'textfield',
                'heading' => 'Max Height',
                'description' => 'Do not include unit',
                'param_name' => 'height',
                'value' => 0,
            ],
        ],
        "js_view" => 'VcColumnView'
    ]);
});

/**
 * Nested VC elemenst must ineherit WPBakery Short Codes Container
 * https://wpbakery.atlassian.net/wiki/spaces/VC/pages/524362
 */

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Outspoke_Read_More extends WPBakeryShortCodesContainer {
    }
}

// Enqueue our frontend styles when the shortcode is used
add_action('wp_enqueue_scripts', function(){
    global $post;
    if ( has_shortcode( $post->post_content, 'outspoke_read_more') ) {
        wp_register_script(
            'readmore',
            'https://cdn.jsdelivr.net/npm/readmore.js@2/readmore.min.js',
            [],
            false,
            true
        );
        wp_enqueue_script(
            'outspoke-read-more',
            plugins_url('/assets/js/main.js', __file__),
            ['jquery', 'readmore'],
            false,
            true
        );

        wp_enqueue_style(
            'outspoke-read-more',
            plugins_url('/assets/css/main.css', __file__)
        );
    }
});


add_shortcode( 'outspoke_read_more', function( $atts, $content = "" ) {
	$atts = shortcode_atts([
		'height' => 0,
	], $atts, 'readmore' );
	extract($atts);

    ob_start();
    ?>
        <div class='outspoke-readmore' data-height='<?= $height; ?>'>
            <?php echo do_shortcode( $content ); ?>
        </div>
    <?php
	return ob_get_clean();
});
