<?php
/**
 * The default template for displaying inline posts
 */

?>
<article id="post-<?php the_ID(); ?>">
	<?php 
		if ( has_post_thumbnail() ) {

			$sana_photo_class = 'photo';
        	$sana_layout = get_query_var( 'sana_layout' );

			$sana_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_The_ID()), 'full' );

			if ($sana_image_src[2] > $sana_image_src[1]) $sana_photo_class .= ' vertical';
			
		    echo '<a href="'.esc_url(get_the_permalink()).'" class="'.esc_attr($sana_photo_class).'">';

	    		the_post_thumbnail();

		    echo '</a>';
		}
	?>
    <div class="description">
   		<?php

   			sana_get_the_cats_archive();
   			
   		?>
        <a href="<?php esc_url( the_permalink() ); ?>" class="header"><h3><?php the_title(); ?></h3></a>
        <?php if ( !has_post_thumbnail() ): ?>
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
    	<?php endif; ?>
    	<div class="blog-info">
    	<?php
			sana_the_post_info();
    	?>
    	</div>
    </div>  
</article>