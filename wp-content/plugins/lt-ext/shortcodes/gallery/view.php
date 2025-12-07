<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Gallery Shortcode
 */

$args = get_query_var('like_sc_gallery');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$list = fw_get_db_post_option( $args['cat'], 'photos' );

if ( !empty($list) ) {

	echo '<div class="gallery-sc '.esc_attr($class).'">';

	echo '<div class="items">';
		echo '<div class="row centered">';
	$item_class = '';

	$keys = array(

		1	=>	'col-lg-6',
		1	=>	'col-lg-6',
		2	=>	'col-lg-6',
		3	=>	'col-lg-6',
		4	=>	'col-lg-6',
	);

	$reverse = false;
	$key = 0;

?>
	<?php foreach ( $list as $item ) : ?>
	<?php
		$key++;

		if ( $args['layout'] == 'masonry' ) {

			$class = 'col-lg-6';

			if ( (empty($reverse) AND $key == 2) OR (!empty($reverse) AND $key == 1) ) {

				echo '<div class="col-lg-6"><div class="row">';
			}
		}
			else {

			$class = 'col-md-3';
		}
	?>
	<div class="<?php echo esc_attr($class); ?>">

		<div class="item">
			<a href="<?php echo esc_url( $item['url'] ); ?>" class="swipebox photo">
				<span class="ltx-border-top"></span>
				<span class="ltx-border-bottom"></span>
				<?php

					echo wp_get_attachment_image( $item['attachment_id'], 'sana-gallery-grid' );

				?>
			</a>
		</div>	
	</div>
	<?php

		if ( $args['layout'] == 'masonry' ) {

			if ( (empty($reverse) AND $key == 5) OR (!empty($reverse) AND $key == 4) ) {

				echo '</div></div>';
			}

			if ( $key == 5) {

				$key = 0;
				if ( empty($reverse) ) $reverse = true; else $reverse = false;
			}		
		}
	?>	
	<?php endforeach; ?>

<?php

	echo '</div></div></div>';
}

