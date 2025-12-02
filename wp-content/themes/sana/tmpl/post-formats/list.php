<?php
/**
 * The default template for displaying standard post format
 */

$post_class = '';
$featured = get_query_var( 'sana_featured_disabled' );
if ( function_exists( 'FW' ) AND empty ( $featured ) ) {

	$featured_post = fw_get_db_post_option(get_The_ID(), 'featured');
	if ( !empty($featured_post) ) {

		$post_class = 'ltx-featured-post-none';
	}
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( esc_attr($post_class) ); ?>>
	<?php 

		if ( has_post_thumbnail() ) {

			$sana_photo_class = 'photo';
        	$sana_layout = get_query_var( 'sana_layout' );

			$sana_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_The_ID()), 'full' );

			if ($sana_image_src[2] > $sana_image_src[1]) $sana_photo_class .= ' vertical';
			
		    echo '<a href="'.esc_url(get_the_permalink()).'" class="'.esc_attr($sana_photo_class).'">';

			echo '<span class="ltx-border-top"></span><span class="ltx-border-bottom"></span>';

	    	if ( empty($sana_layout) OR $sana_layout == 'classic'  ) {

	    		the_post_thumbnail();
	    	}
	    		else
	    	if ( $sana_layout == 'two-cols'  ) {	    	

	    		the_post_thumbnail();
	    	}
	    		else {


				$sizes_hooks = array( 'sana-blog', 'sana-blog-full' );
				$sizes_media = array( '1199px' => 'sana-blog' );

				sana_the_img_srcset( get_post_thumbnail_id(), $sizes_hooks, $sizes_media );
    		}

		    echo '</a>';

		}

		sana_get_the_cats_archive();

	?>
    <div class="description">
    	<?php

    	echo '<div class="blog-info blog-info-post-top"><ul>';
    		sana_the_blog_date(array('wrap' => 'li', 'cat_show' => true));
    	echo '</ul></div>';
    	?>
        <a href="<?php esc_url( the_permalink() ); ?>" class="header"><h3><?php the_title(); ?></h3></a>
        <?php
			$sana_display_excerpt = get_query_var( 'ltx_display_excerpt' );

        	if ( !function_exists('FW') AND !has_post_thumbnail() )  {

        		$sana_display_excerpt = true;
        	}

        	if ( (!has_post_thumbnail() OR empty($sana_layout)) OR !empty( $sana_display_excerpt ) ):

        		if ( !empty( $sana_display_excerpt ) AND $sana_display_excerpt == 'visible' ):
        ?>
        <div class="text text-page">
			<?php
				add_filter( 'the_content', 'sana_excerpt' );
			    if( strpos( $post->post_content, '<!--more-->' ) ) {

			        the_content( esc_html__( 'Read more', 'sana' ) );
			    }
			    	else  {

			    	the_excerpt();			    	
			    }	
			?>
        </div>            
    	<?php 
    			else :

	    			echo '<a href="'.esc_url( get_the_permalink() ).'" class="more-link">'.esc_html__( 'Read more', 'sana' ).'</a>';

    			endif;
   			else:
		    	echo '<a href="'.esc_url( get_the_permalink() ).'" class="more-link">'.esc_html__( 'Read more', 'sana' ).'</a>';
    		endif;
    	?>
    </div>    
</article>