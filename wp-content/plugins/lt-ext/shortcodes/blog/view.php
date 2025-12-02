<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Testimonials Shortcode
 */

$args = get_query_var('like_sc_blog');

$query_args = array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => $args['limit'],
);

if ( !empty($args['ids']) ) $query_args['post__in'] = explode(',', esc_attr($args['ids']));
	else
if ( !empty($args['cat']) ) $query_args['category__and'] = esc_attr($args['cat']);

$query = new WP_Query( $query_args );

if ( $query->have_posts() ) {

	set_query_var( 'ltx_display_excerpt', false );
	if ( $args['excerpt_display'] == 'visible' ) {

		set_query_var( 'ltx_display_excerpt', true );
	}	

	set_query_var( 'ltx_sc_excerpt_size', false );
	if ( !empty( $args['excerpt'] ) ) {

		set_query_var( 'ltx_sc_excerpt_size', $args['excerpt'] );
	}	

	$cols = '';
	if ( $args['columns'] == 1) {

		$cols = 'col-xs-12';
	}
		else
	if ( $args['columns'] == 2) {

		$cols = 'col-lg-6 col-md-6 col-sm-6 col-ms-12 col-xs-12';
	}
		else
	if ( $args['columns'] == 3) {

		$cols = 'col-lg-4 col-md-4 col-sm-6 col-ms-12 col-xs-12';
	}
		else
	if ( $args['columns'] == 4) {

		$cols = 'col-lg-3 col-md-4 col-sm-6 col-ms-12 col-xs-12';
	}


	$class = array();
	$class[] = 'layout-'.$atts['layout'];
	$class[] = 'size-'.$atts['size'];

	echo '<div class="blog blog-sc row centered '.esc_attr(implode(' ', $class)).'">';

	$x = 0;
	while ( $query->have_posts() ) {

		$query->the_post();	
		$x++;

		if ( $args['layout'] == 'featured-short' ) {

			$class = '';
			if ( $x <= 2 ) {

				echo '<div class="col-lg-push-4 col-lg-4 col-md-6 col-md-push-0 col-sm-6 col-ms-12 col-xs-12">';
				echo get_template_part( 'tmpl/post-formats/list-featured' );
				echo '</div>';
			}
				else {
		
				if ( $x == 3 ) echo '<div class="col-lg-pull-8 col-lg-4 col-md-pull-0 col-md-12 col-sm-12 col-ms-12 col-xs-12 ltx-col-simple-blog">';
					if ( $x == 5 ) echo '<div class="visible-xs visible-ms visible-sm visible-md visible-xl">';
					get_template_part( 'tmpl/post-formats/list-simple' );
					if ( $x == 5 ) echo '</div>';
				if ( $x == $query->post_count ) echo '</div>';
			}
		}
			else
		if ( $args['layout'] == 'list' ) {

			echo '<div class="'.esc_attr($cols).'">';
			echo get_template_part( 'tmpl/post-formats/list-inline' );
			echo '</div>';				
		}
			else {

				echo '<div class="items '.esc_attr($cols).'">';
				echo get_template_part( 'tmpl/post-formats/list' );
				echo '</div>';
		}

	}

	echo '</div>';
	echo '<div class="clear"></div>';

	wp_reset_postdata();
	set_query_var( 'ltx_display_excerpt', false );
	set_query_var( 'ltx_sc_excerpt_size', false );
}

