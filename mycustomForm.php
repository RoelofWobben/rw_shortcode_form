<?php

/**
 * Plugin Name: RW_custom_form 
 * Description: my solution to a challenge of wpchallenges 
 **/

if (!defined('ABSPATH')) die();

function roelof_add_custom_shortcode()
{
	function roelof_contact_form($atts, $content, $shortcode_tag)
	{
		static $counter = 0;
		$counter++;
		wp_enqueue_style('rw-custom-form-style');
		wp_enqueue_script('rw-custom-form-script');
		ob_start();
		load_template(__DIR__ . '/templates/form.php', false, [
			'atts' => $atts,
			'content' => $content,
			'shortcode' => $shortcode_tag,
			'prefix' => $shortcode_tag . $counter,
		]);
		return ob_get_clean();
	}

	add_shortcode('contact_form', 'roelof_contact_form');
}

add_action('init', 'roelof_add_custom_shortcode');

function load_assets()
{

	wp_register_style('rw-custom-form-style', plugins_url('/css/mycustomForm.css', __FILE__), array(), '1.0.0', 'all');
	wp_register_script('rw-custom-form-script', plugins_url('/js/myCustomForm.js', __FILE__), array(), '1.0.0', 'all');

	$translation_array = array (
		"success message" => __('Email has been send', 'mycustomForm')
	); 

	wp_localize_script('rw-custom-form-script', 'success_message', $translation_array); 

	wp_enqueue_script('success_message'); 
}

add_action('wp_enqueue_scripts', 'load_assets');
