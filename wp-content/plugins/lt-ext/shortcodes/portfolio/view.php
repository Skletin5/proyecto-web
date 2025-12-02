<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Portfolio Shortcode
 */

$args = get_query_var('like_sc_portfolio');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$class .= ' layout-'.$args['layout'];

$query_args = array(
	'post_type' => 'portfolio',
	'post_status' => 'publish',
	'posts_per_page' => (int)($args['limit']),
);

if ( !empty($args['ids']) ) $query_args['post__in'] = explode(',', esc_attr($args['ids']));
	else
if ( !empty($args['cat']) ) {

	$query_args['tax_query'] = 	array(
		array(
            'taxonomy'  => 'portfolio-category',
            'field'     => 'if', 
            'terms'     => array(esc_attr($args['cat'])),
		)
    );
}

$query = new WP_Query( $query_args );

if ( $query->have_posts() ) {

	$cols = 1;

	echo '<div class="portfolio-sc">';
	echo '<div class="swiper-container portfolio-list portfolio-slider '.esc_attr($class).'  row" data-cols="'.esc_attr($cols).'" data-autoplay="'.esc_attr($atts['autoplay']).'" '.$id.'>
			<div class="swiper-wrapper">';

	$x = 1;
	while ( $query->have_posts() ) {

		$query->the_post();

		$taxonomy = 'portfolio-category';
		$terms = get_terms($taxonomy);

		if ( !empty($terms) ) {

			foreach ($terms as $term) {

				$category = $term->name;
			}
		}

		echo '
		<div class="swiper-slide">
			<div class="row">
				<div class="col-lg-6">
					<div class="ltx-wrapper matchHeight" data-mh="ltx-portfolio-list">';
					the_post_thumbnail('full');
					echo '<span class="header">0'.esc_html($x).'</span>';
				echo '
					</div>
				</div>
				<div class="col-lg-6">
					<div class="ltx-wrapper matchHeight" data-mh="ltx-portfolio-list">';
						echo '<div class="heading subcolor-white align-left heading-xl">';
						if ( !empty($category) ) echo '<h6 class="subheader">'.esc_html($category).'</h6>';
						echo '<h2 class="header">'. get_the_title() .'</h2></div>';
						echo '<div class="text">';
							echo do_shortcode(get_the_content());
						echo '</div>
					</div>
				</div>
			</div>
		</div>';
		$x++;
	}

	echo '</div>';
	echo '<div class="swiper-pages-wrapper"><div class="swiper-pages"></div></div>';
	echo '</div>';	
	echo '<span class="triangle"></span></div>';
}

