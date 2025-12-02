<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Testimonials Shortcode
 */

$args = get_query_var('like_sc_testimonials');

$query_args = array(
	'post_type' => 'testimonials',
	'post_status' => 'publish',
	'posts_per_page' => (int)($atts['limit']),
);

$class = 'layout-'.esc_attr($atts['layout']);
if ( !empty($args['background']) ) $class .= ' bg-'.$args['background'];
if ( !empty($args['arrows']) ) $class .= ' arrows-'.$args['arrows'];
if ( !empty($args['font_weight']) ) $class .= ' font-weight-'.$args['font_weight'];

if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$arrow_span_left = $arrow_span_right = '';
if ( !empty($args['arrows']) AND $args['arrows'] == 'text' ) {

	$arrow_span_left = esc_html__('prev', 'lt-ext');
	$arrow_span_right = esc_html__('next', 'lt-ext');
}

if ( !empty($args['ids']) ) $query_args['post__in'] = explode(',', esc_attr($args['ids']));
	else
if ( !empty($args['cat']) ) {

	$query_args['tax_query'] = 	array(
			array(
	            'taxonomy'  => 'testimonials-category',
	            'field'     => 'if', 
	            'terms'     => array(esc_attr($args['cat'])),
			)
    );
}

$query = new WP_Query( $query_args );

if ( $query->have_posts() ) {

	$cols = $args['columns'];

	if ( $args['mode'] == 'slider' ) {

		echo '<div class="swiper-container testimonials-list testimonials-slider testimonials-slider-cols-'.esc_attr($cols).' '.esc_attr($class).'  row" data-cols="'.esc_attr($cols).'" data-autoplay="'.esc_attr($atts['autoplay']).'" '.$id.'>
				<div class="swiper-wrapper">';
	}
		else {

		echo '<div class="testimonials-list">';
	}

	while ( $query->have_posts() ) {

		$query->the_post();
		$subheader = fw_get_db_post_option(get_The_ID(), 'subheader');
		$rate = fw_get_db_post_option(get_The_ID(), 'rate');

		if ( $args['mode'] == 'slider' ) {

			echo '<div class="swiper-slide">';
		}

			echo '<div class="inner matchHeight">';

				echo '<div class="text">';
					echo '<p>'. get_the_content() .'</p>
				</div>';

				echo '<div class="author">';

					if ($atts['photo'] == 'visible' ) {

						echo '<div class="image">';
							the_post_thumbnail('sana-tiny-square');
						echo '</div>';
					}

					if ($atts['name'] == 'visible' ) {

						$by = '';
						if ( !empty($args['author_prefix']) ) {

							$by = $args['author_prefix'].' ';
						}

						echo '<div class="header">'. esc_html($by) . get_the_title() .'</div>';
						if (!empty($subheader)) {

							//echo '<div class="subheader">'. wp_kses_post($subheader) .'</div>';
						}
					}

					if ( $atts['rate'] == 'visible' AND !empty($rate) ) {

						echo '<div class="rate">';
						for ($x = 1; $x<= (int)($rate); $x++) {

							echo '<span class="fa fa-star"></span>';
						}
						echo '</div>';
					}

				echo '</div>';

				echo '					
			</div>';

		if ( $args['mode'] == 'slider' ) {

			echo '</div>';
		}		
	}

	if ( $args['mode'] == 'slider' ) {

		echo '</div>';

		echo '<div class="arrows">
				<a href="#" class="arrow-left fa fa-chevron-left"></a>
				<a href="#" class="arrow-right fa fa-chevron-right"></a>
			</div>';
		//echo '<div class="swiper-pages"></div>';
	}
		
	echo '</div>';

	wp_reset_postdata();
}

