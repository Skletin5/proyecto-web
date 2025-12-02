<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Events Shortcode
 */

$args = get_query_var('like_sc_events_calendar');

$query_args = array(
	'post_type' => 'tribe_events',
	'post_status' => 'publish',
	'posts_per_page' => (int)($atts['limit']),
);

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

if ( !empty($args['cat']) ) {

	$query_args['tax_query'] = 	array(
			array(
	            'taxonomy'  => 'tribe_events_cat',
	            'field'     => 'if', 
	            'terms'     => array(esc_attr($args['cat'])),
			)
    );
}

$query = new WP_Query( $query_args );

if ( $query->have_posts() ) {

	$cols = 1;

	echo '<div class="events-sc '.esc_attr($class).'" '.$id.'>';

	while ( $query->have_posts() ) {

		$query->the_post();
		$subheader = str_replace(array('{{', '}}'), array('<strong>', '</strong>'), fw_get_db_post_option(get_The_ID(), 'subheader'));
		$cut = str_replace(array('{{', '}}'), array('<strong>', '</strong>'), nl2br(get_the_excerpt()));

		$date = array();
		if (function_exists('tribe_get_start_date')) {

			$date['d'] = tribe_get_start_date(get_The_ID(), false, 'd');
			$date['F'] = tribe_get_start_date(get_The_ID(), false, 'F');
			$date['Y'] = tribe_get_start_date(get_The_ID(), false, 'Y');
		}

		echo '<div class="item">';
			echo '<div class="row">';
				echo '<div class="col-md-1"><div class="in img matchHeight">'.get_the_post_thumbnail().'</div></div>';
				echo '<div class="col-md-3">
						<div class="in name matchHeight">
							<div>
								<h5>'. get_the_title() .'</h5>
								<span class="subheader">'.wp_kses_post( $subheader ).'</span>
							</div>
						</div>
					</div>';

				echo '<div class="col-md-2">';
					echo '<div class="in date matchHeight">';
						echo '<div>';					
						echo '<span class="date-day">'.esc_html($date['d']).'</span><span class="date-my">'.esc_html($date['F']).'<br>'.esc_html($date['Y']).'</span>
						</div>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col-md-3">
					<div class="in descr matchHeight">
						<div>';
						if ( !empty($args['image']) ) {

							echo '<span class="ltx-clock">'.wp_get_attachment_image( $args['image'] , 'full' ).'</span>';
						}	
						echo wp_kses_post( $cut ) .'</div>
					</div>
				</div>';
				echo '<div class="col-md-3 div-more"><div class="in matchHeight"><a href="'.get_the_permalink().'" class="btn">'.esc_html($atts['btn_text']).'</a></div></div>';
			echo '</div>';
		echo '</div>';
	}

	echo '</div>';

	wp_reset_postdata();
}

