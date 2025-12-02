<?php
/**
 * Full blog post
 */

if ( function_exists( 'FW' ) ) {

	$gallery_files = fw_get_db_post_option(get_The_ID(), 'gallery');
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content clearfix" id="entry-div">
	<?php
		if ( !empty( $gallery_files ) ) {

			echo '
			<div class="swiper-container ltx-post-gallery" data-autoplay="4000">
				<div class="swiper-wrapper">';

			foreach ( $gallery_files as $item ) {

				echo '<a href="'.esc_url(get_the_permalink()).'" class="swiper-slide">';
					echo wp_get_attachment_image( $item['attachment_id'], 'sana-featured' );
				echo '</a>';
			}

			echo '</div>
				<div class="arrows">
					<a href="#" class="arrow-left fa fa-arrow-left"></a>
					<a href="#" class="arrow-right fa fa-arrow-right"></a>
				</div>
				<div class="swiper-pages"></div>
			</div>';
		}
			else	
		if ( has_post_thumbnail() ) {

			echo '<div class="image">';
				
				the_post_thumbnail( 'sana-post' );

			echo '</div>';
		}
	?>
    <div class="blog-info blog-info-post-top">
		<?php

            echo '<div class="blog-info-left">';

            	echo '<ul>';

					echo '<li class="ltx-cats-li">';
		           		sana_get_the_cats_archive();
					echo '</li>';


            		sana_the_blog_date(array('wrap' => 'li', 'cat_show' => true));

   					echo 
   					'<li class="ltx-user-li">
   						<div class="ltx-user"><span class="info">'. esc_html__( 'by', 'sana' ) . ' ' .get_the_author_link().'</span></div>
   					</li>';

   					sana_the_post_info( true, false );

				echo '</ul>';

            echo '</div>';

        ?>
    </div>
    <div class="description">
        <div class="text text-page">
			<?php
				the_content();
				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'sana' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
			?>
			<div class="clear"></div>
        </div>
    </div>	    
    <div class="clearfix"></div>
    <div class="blog-info-post-bottom">
		<?php
			if ( ( has_tag() AND sizeof( wp_get_post_tags( get_The_ID() ) ) <= 5 ) OR shortcode_exists('ltx-share-icons') ) {

				echo '<div class="tags-line">';

					echo '<div class="tags-line-left">';
						if ( has_tag() AND sizeof( wp_get_post_tags( get_The_ID() ) ) <= 5 ) {

							echo '<span class="tags">';
								echo '<span class="tags-header">'.esc_html__( 'Tags:', 'sana' ).'</span>';
								the_tags( '<span class="tags-short">', '', '</span>' );
							echo '</span>';
						}				
					echo '</div>';
					echo '<div class="tags-line-right">';

						if ( shortcode_exists('ltx-share-icons') ) {

							echo do_shortcode( '[ltx-share-icons header="'.esc_html__( 'Share:', 'sana' ).'"]' );
						}

					echo '</div>';

				echo '</div>';
			}

			if ( has_tag() AND sizeof( wp_get_post_tags( get_The_ID() ) ) > 5 ) {
				
				echo '<span class="tags tags-many">';
					the_tags( '<span class="tags-short">', '', '</span>' );
				echo '</span>';
			}				

			if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && sana_categorized_blog() ) {

				if ( sizeof(get_the_category()) > 3 ) {

					echo '<div class="ltx-cats cats-many">';
						echo get_the_category_list( esc_html_x( ' / ', 'Used between list items, there is a space after the comma.', 'sana' ) );
					echo '</div>';
				}
			}				

		?>	
    </div>	
    <?php 
		sana_author_bio();

		sana_related_posts(get_the_ID());
    ?>
    </div>
</article>
