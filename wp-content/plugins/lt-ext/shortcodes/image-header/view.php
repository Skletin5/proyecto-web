<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode
 */

$args = get_query_var('like_sc_image_header');

if ( !empty($atts['header_type']) ) $tag = 'h'.$atts['header_type']; else $tag = 'h4';

$class = '';
if ( !empty($atts['class']) ) $class .= ' '. esc_attr($atts['class']);
if ( !empty($atts['id']) ) $id = ' id="'. esc_attr($atts['id']). '"'; else $id = '';

$class .= ' style-'.$atts['style'];


if ($atts['layout'] == 'header') {

	echo '<a href="'.esc_url($atts['href']).'" class="image-header ' . esc_attr( $class ) .'" '.$id.'>';

		if ( empty($atts['header'])) {

			$item['header'] = '';
		}

		if ( !empty($atts['image']) ) {

			$image = ltx_get_attachment_img_url( $atts['image'] );
			$image_tag = '<div class="photo"><img src="' . esc_url($image[0]) . '" class="image" alt="'.esc_attr($atts['header']).'"></div>';
		}

		echo $image_tag . '<'. esc_attr($tag) .' class="header"> ' . esc_html( $atts['header'] )  .  ' </'. esc_attr($tag) .'> ';

	echo '</a>';
}
	else
if ($atts['layout'] == 'scroll') {

	$image = ltx_get_attachment_img_url( $atts['image'] );
	if ( !empty($atts['height']) ) $height = 'max-height: '.ltx_vc_get_metric($atts['height']).'; '; else $height = '';

	if ( empty($atts['href']) ) {

		$class .= ' image-soon';
		$attr['href'] = '#';
	}
		else {

		$class .= '';
	}

	echo '<a href="'.esc_url($atts['href']).'" class="image-preview ' . esc_attr( $class ) .'" '.$id.' style="'.esc_attr($height).' background-image: url('.$image[0].')">';
		if ( empty($atts['href']) ) echo '<span class="btn btn-black btn-xs">'.esc_html__( 'Cooming Soon', 'lt-ext' ).'</span>';
	echo '</a>';
/*

	echo '<a href="'.esc_url($atts['href']).'" target="_blank" class="image-preview ' . esc_attr( $class ) .'" '.$id.' style="'. esc_attr($height) .'">';
	echo '<img src="'.esc_url($image[0]).'" />';
	echo '</a>';
*/	
}
	else
if ($atts['layout'] == 'video') {

	$image = ltx_get_attachment_img_url( $atts['image'] );
	$image2 = ltx_get_attachment_img_url( $atts['image2'] );
	$atts['header'] = str_replace(array('{{', '}}'), array('<span>', '</span>'), $atts['header']);

	echo '<a href="'.esc_url($atts['href']).'" class="swipebox image-video ' . esc_attr( $class ) .'" '.$id.'>';
		echo '<span class="ltx-border-top"></span>
			<span class="ltx-border-bottom"></span>';
		echo '<span class="image">
			<img src="' . esc_url($image[0]) . '" class="image" alt="'.esc_attr($atts['header']).'">';
			echo '<span class="play-wrap"><span class="play"></span>';
				if ( !empty($atts['header']) ) {

					echo '<span class="header">'.wp_kses_post($atts['header']).'</span>';
				}
			echo '</span>';
		echo '</span>';

	echo '</a>';
}

