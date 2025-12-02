<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Zoom Slider Shortcode
 */

$args = get_query_var('like_sc_parallax_slider');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

?>
<div class="ltx-parallax-slider <?php echo esc_attr($class); ?>" id="<?php echo esc_attr($id); ?>">
	<div class="ltx-slider-inner"><?php echo do_shortcode( $content ); ?></div>
	<div class="ltx-layers">
	<?php

		if ( !empty( $args['items'])) {

			$x = sizeof($args['items']) + 1;
			foreach ( $args['items'] as $item) {

				$x--;
				$image = ltx_get_attachment_img_url($item['image']);

				if ( $item['bg_size'] == '100%' ) $item['bg_size'] = ' 100% 100% ';

				echo '<div class="layer" data-factor="'.esc_attr($item['strength']).'" data-direction="'.esc_attr($item['direction']).'" data-type="'.esc_attr($item['type']).'" style="background-image: url('.esc_url($image[0]).'); background-size: '.esc_attr($item['bg_size']).'; z-index: '.esc_attr($x).'; bottom: '.esc_attr(ltx_vc_get_metric($item['pos_bottom'])).';"></div>';
			}
		}

	?>
	</div>
</div>