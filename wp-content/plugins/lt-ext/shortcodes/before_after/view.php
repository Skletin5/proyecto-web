<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode
 */

$args = get_query_var('like_sc_before_after');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

echo '<div class="ltx-before-after '.esc_attr($class).'" '.$id.'>';

	if ( !empty ($args['items']) ) {

		echo '<ul class="cats tabs-cats ltx-ba-filter">';
		foreach ($args['items'] as $key => $item) {

			echo '<li><span class="cat" data-filter="'.esc_attr($key).'">'.esc_html($item['header']).'</span></li>';
		}
		echo '</ul>';

		echo '<div class="ltx-wrap">';
			echo '<div class="container">';
				echo '<div class="row">';
					echo '<div class="col-lg-2 hidden-md hidden-sm hidden-ms hidden-xs">';
					if ( !empty($args['header-before'] ) ) {

						echo '<h6 class="header">'.wp_kses_post( ltx_header_parse( $args['header-before'] ) ).'</h6>';
					}
					echo '</div>';

					echo '<div class="col-lg-8">';

						foreach ($args['items'] as $key => $item) {

							echo '<div class="ltx-ba-wrap ltx-ba-filter-'.esc_attr($key).'">';

								$image_before = ltx_get_attachment_img_url($item['image-before']);
								$image_after = ltx_get_attachment_img_url($item['image-after']);
								echo '<div class="after item"style="background-image: url(' . esc_attr($image_after[0]) . ')"></div>';
								echo '<div class="before item" style="background-image: url(' . esc_attr($image_before[0]) . ')"></div>';
								echo '<img src="' . $image_before[0] . '" class="ltx-ba-before" alt="'.esc_attr($item['header']).'">';
								echo '<div class="handle"></div>';

							echo '</div>';
						}

					echo '</div>';

					echo '<div class="col-lg-2 hidden-md hidden-sm hidden-ms hidden-xs">';
					if ( !empty($args['header-after'] ) ) {

						echo '<h6 class="header">'.wp_kses_post( ltx_header_parse( $args['header-after'] ) ).'</h6>';
					}
					echo '</div>';

				echo '</div>';
			echo '</div>';
		echo '</div>';
	}

echo '</div>';


