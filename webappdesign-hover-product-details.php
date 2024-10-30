<?php
/*
Plugin Name: Hover Product Details
Plugin URI: https://github.com/juanmacivico87/hover-product-details
Description: This plugin allow you to see the product details in Woocommerce when you pass the mouse on the product.
Version: 1.1
Author: Juan Manuel Civico Cabrera
Author URI: http://www.juanmacivico87.com
License: GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  hover-product-details
Domain Path:  /languages
*/

if (!defined('ABSPATH'))
	exit;

if (!defined('HOVER_PRODUCTS_TEXTDOMAIN'))
	define('HOVER_PRODUCTS_TEXTDOMAIN', 'hover-product-details');

//Carga el archivo con las funciones de JavaScript.
//Load the file with JavaScript functions.
add_action('wp_enqueue_scripts', 'webappdesign_hover_product_details_js');
function webappdesign_hover_product_details_js()
{
	wp_enqueue_script('webappdesign_hover_product_details_js', plugin_dir_url(__FILE__) . 'js/webappdesign_hover_product_details.js', array('jquery'), '1.0', true);

	wp_enqueue_style('webappdesign_hover_product_details_js', plugin_dir_url(__FILE__) . 'css/webappdesign-hover-product-details.css');
}

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

//WooCommerce Loop Product Thumbs
if (!function_exists('woocommerce_template_loop_product_thumbnail'))
{
	function woocommerce_template_loop_product_thumbnail()
	{
		echo woocommerce_get_product_thumbnail();
	} 
}

//WooCommerce Product Thumbnail
if (!function_exists('woocommerce_get_product_thumbnail'))
{
	function woocommerce_get_product_thumbnail($size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0)
	{
		global $post;
		global $wp_query;
		global $woocommerce;
		global $attributes;

		$output = '<div class="webappdesign-product-' . $post -> ID . '">';

		$output .= '<div class="webappdesign-img-' . $post -> ID . '">';
		if (has_post_thumbnail())
			$output .= get_the_post_thumbnail($post -> ID, $size);
		else
		{
			$output .= '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" />';
		}
		$output .= '</div>';

		$output .= '<div class="webappdesign-details-' . $post -> ID . '" style="display: none; min-height: ' . $placeholder_height . '; min-width: ' . $placeholder_width . ';"><table><tr><td colspan="2">' . __('ADDITIONAL INFORMATION', HOVER_PRODUCTS_TEXTDOMAIN) . '</td></tr>';

		if (get_post_meta($post -> ID, '_weight', true) != '')
			$output .=  '<tr><td>' . __('Weight: ', HOVER_PRODUCTS_TEXTDOMAIN) . '</td><td>' . get_post_meta($post -> ID, '_weight', true) . '</td></tr>';
		if ((get_post_meta($post -> ID, '_length', true) != '') && (get_post_meta($post -> ID, '_width', true) != '') && (get_post_meta($post -> ID, '_height', true) != ''))
			$output .=  '<tr><td>' . __('Dimensions: ', HOVER_PRODUCTS_TEXTDOMAIN) . '</td><td>' . get_post_meta($post -> ID, '_length', true) . ' x ' . get_post_meta($post -> ID, '_width', true) . ' x ' . get_post_meta($post -> ID, '_height', true) . '</td></tr>';
		if (get_post_meta($post -> ID, '_product_attributes', true) != '')
		{
			$productAttributes = get_post_meta($post -> ID, '_product_attributes', true);
			foreach($productAttributes as $productAttribute)
			{
				if (($productAttribute['value'] != '') && ($productAttribute['is_visible'] == 1))
					$output .=  '<tr><td>' . $productAttribute['name'] . ': </td><td>' . $productAttribute['value'] . '</td></tr>';
			}
		}
		
		$output .= '</table></div><div class="webappdesign-hover-buttons-' . $post -> ID . '" style="display: none;">';
		$output .= '<a href="' . get_permalink($post -> ID) . '" class=" utton product_type_simple" data-product_id="' . $post -> ID . '" data-product_sku rel="nofollow">' . __('More info', HOVER_PRODUCTS_TEXTDOMAIN) . '</a><br><br>';
		$output .= '<a href="?add-to-cart=' . $post -> ID . '" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="' . $post -> ID . '" data-product_sku rel="nofollow">' . __('Add to cart', HOVER_PRODUCTS_TEXTDOMAIN) . '</a>';
		$output .= '</div></div>';

		return $output;
	}
}