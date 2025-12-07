<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * partners Shortcode
 */

$args = get_query_var('like_sc_partners');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$class .= ' layout-'.esc_attr($args['type']);

echo '<div class="ltx-partners ltx-hover-logos '.esc_attr($class).'"'.$id.'>';
	echo '<div class="row">';

		if ( sizeof($atts['list']) == 6 ) $div_class = ' col-md-2 ';
			else
		if ( sizeof($atts['list']) == 5 ) $div_class = ' col-lg-5ths ';
			else				
		if ( sizeof($atts['list']) == 4 ) $div_class = ' col-md-3 ';
			else
		if ( sizeof($atts['list']) == 3 ) $div_class = ' col-md-4 ';

		foreach ( $atts['list'] as $k => $item ) {

			if ( empty( $item['header'] ) ) $item['header'] = '.';

			echo '
				<div class="'.esc_attr($div_class).' col-sm-4 col-ms-6 col-xs-6  partners-wrap  center-flex" data-mh="ltx-partners">
					<div class="partners-item item center-flex">';

						$image = ltx_get_attachment_img_url( $item['image'], 'sana-partners' );
						if ( !empty($item['href']) ) {

							echo '<a href="'.esc_url( $item['href'] ).'"><img src="' . esc_url($image[0]) . '" class="image" alt="'.esc_attr($item['header']).'"></a>';
						}
							else {

							echo '<div class="photo"><img src="' . esc_url($image[0]) . '" class="image" alt="'.esc_attr($item['header']).'"></div>';
						}

					echo '</div>
				</div>';
		}
	echo '</div>';
echo '</div>';

