<?php
/**
 * Video Post Format
 */

$post_class = '';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( esc_attr($post_class) ); ?>>	
	<?php
	if ( has_post_thumbnail() ) {

		$sana_photo_class = 'image-video swipebox';

		echo '<div class="ltx-wrapper">';
		    echo '<a href="'.esc_url(sana_find_http(get_the_content())).'" class="'.esc_attr($sana_photo_class).'">';

		    	echo '<span class="ltx-border-top"></span><span class="ltx-border-bottom"></span>';

			    the_post_thumbnail();
			    echo '<span class="ltx-icon-video"></span>';

		    echo '</a>';
		echo '</div>';
	}
		else {

		if ( !empty(wp_oembed_get(sana_find_http(get_the_content()))) ) {

			echo '<div class="ltx-wrapper">';
				echo wp_oembed_get(sana_find_http(get_the_content()));	
			echo '</div>';
		}
	}

	sana_get_the_cats_archive();

	$headline = 'date';

	?>
    <div class="description">  
    	<?php

    	echo '<div class="blog-info blog-info-post-top"><ul>';
    		sana_the_blog_date(array('wrap' => 'li', 'cat_show' => true));
    	echo '</ul></div>';

    	?>    
        <a href="<?php esc_url( the_permalink() ); ?>" class="header"><h3><?php the_title(); ?></h3></a>
    	<?php
			echo '<a href="'.esc_url( get_the_permalink() ).'" class="more-link">'.esc_html__( 'Read more', 'sana' ).'</a>';
    	?>
    </div>  	
</article>