<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * @var string $before_widget
 * @var string $after_widget
 */
echo wp_kses_post( $before_widget );

if ( !empty($params['title']) )  {

	echo wp_kses_post( $before_title ) . esc_html( $params['title'] ) . wp_kses_post( $after_title );
}

if ( empty($params['num']) ) $params['num'] = 3;

$wp_query = new WP_Query( array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => (int)($params['num']),
) );

echo '<div class="items">';

if ( $wp_query->have_posts() ) :
	while ( $wp_query->have_posts() ) : $wp_query->the_post();

		echo '<div class="post">';

			if ( empty( $params['style'] ) OR $params['style'] == 'image-top' ) {

				if ( !empty( $params['photo'] ) AND has_post_thumbnail() ) {

					echo '<a href="'.get_the_permalink().'" class="photo">';
		   			the_post_thumbnail('sana-blog-300');
		   			echo '</a>';
		   		}

				echo '<a href="'.get_the_permalink().'">';
					echo '<h6>'.get_the_title().'</h6>';
				echo '</a>';

				if ( function_exists('sana_the_post_info') ) {

					echo '<div class="blog-info">';
						sana_the_post_info(false);
				    echo '</div>';
				}
			}
				else {

				if ( !empty( $params['photo'] ) AND has_post_thumbnail() ) {

					echo '<a href="'.get_the_permalink().'" class="photo photo-left">';
		   			the_post_thumbnail('sana-blog-tiny');
		   			echo '</a>';
		   		}

		   		echo '<div class="descr-right">';

			   		if ( function_exists('sana_the_blog_date') ) {

				    	echo '<div class="blog-info blog-info-post-top"><ul>';
				    		sana_the_blog_date(array('wrap' => 'li'));
				    	echo '</ul></div>';
				    }

					echo '<a href="'.get_the_permalink().'">';
						echo '<h6>'.get_the_title().'</h6>';
					echo '</a>';

					if ( function_exists('sana_the_post_info') ) {

						echo '<div class="blog-info">';
							sana_the_post_info( true );
					    echo '</div>';
					}

			    echo '</div>';
			}
		echo '</div>';

	endwhile;
endif;

echo '</div>';

if ( !empty( $params['readmore_text'] ) ) {

	echo '<p class="btn-wrapper"><a href="'.esc_url($params['readmore_link']).'" class="btn btn-xs">'.esc_html($params['readmore_text']).'</a></p>';

}	

echo wp_kses_post( $after_widget ) ?>
