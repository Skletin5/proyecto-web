<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Tariff Shortcode
 */

$args = get_query_var('like_sc_tariff');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

if ( !empty($args['layout']) ) $class .= ' layout-'.$args['layout'];
if ( $args['layout'] == 'default' ) $class .= ' ';
if ( !empty($args['vip']) ) $class .= ' vip';


echo '<div data-mh="ltx-tariff-item" class="tariff-item item '.esc_attr($class).'" '.$id.'>';

	$btn_color = ' btn-main';
	if ( !empty($args['vip']) ) {

		echo '<span class="label-vip">'. esc_html($args['vip_text']) .'</span>';
//		if ( $args['layout'] == 'default' ) $btn_color = ' btn-second color-hover-black'; else $btn_color = '  btn-second color-hover-white';
	}

	if ( !empty($args['header']) ) {

		echo '<h4 class="header">'. wp_kses_post($args['header']) .'</h4>';
	}

	if ( !empty($args['icon']) ) {

		echo '<div class="image"><span class="heading-icon-fa '.esc_attr($args['icon']).' "></span></div>';
	}
		else
	if ( !empty($args['image'])) {

		$image = ltx_get_attachment_img_url( $args['image'] );
		if ( !empty($image[0])) {
		
			echo '<div class="image"><img src="' . $image[0] . '" class="full-width" alt="'. esc_attr($args['header']) .'"></div>';
		}
	}

	if ( !empty($args['price']) ) echo '<div class="price">' . wp_kses_post($args['price']) . '</div>';

	if ( !empty($args['descr']) ) echo '<div class="descr">'.wp_kses_post($args['descr']).'</div>';

	if ( !empty($args['text']) ) echo '<ul><li>'. implode('</li><li>', explode(',', wp_kses_post($args['text']))) .'</li></ul>';

	if ( !empty($args['btn_header']) ) {

		echo '<div><a href="'.esc_url($args['btn_href']).'" class="btn '.esc_attr($btn_color).'">'. esc_html($args['btn_header']) .'</a></div>';
	}

echo '</div>';


