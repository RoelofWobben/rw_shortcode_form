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
	wp_enqueue_style(
		'mycustomForm',
		plugin_dir_url(__FILE__) . '/css/mycustomForm.css',
		array(),
		1,
		'all'
	);
}

add_action('wp_enqueue_scripts', 'load_assets');
