<?php

/**
 * Plugin Name: Idea Pro Contact Form Ajax
 * Description: This form submits through an ajax call
 **/

function roelof_add_custom_shortcode()
{
	function roelof_contact_form($atts, $content, $shortcode_tag)
	{
		ob_start();
		load_template(__DIR__ . '/templates/form.php', false, [
			'atts' => $atts,
			'content' => $content,
			'shortcode_tag' => $shortcode_tag,
		]);
		return ob_end_flush();
	}

	add_shortcode('contact_form', 'roelof_contact_form');
}

add_action('init', 'roelof_add_custom_shortcode');

function load_assets()
{

	wp_register_style( 'get-style', plugins_url( '/css/mycustomForm.css', __FILE__ ), array(), '1.0.0', 'all' );
}

add_action('wp_enqueue_scripts', 'load_assets');
