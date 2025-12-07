<?php
/**
 * The default template for displaying standard post format
 */

$post_class = 'ltx-simple-post';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( esc_attr($post_class) ); ?>>
	<?php 
		sana_get_the_cats_archive();
	?>
    <div class="description">
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