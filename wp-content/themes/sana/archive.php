<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 */

$sana_sidebar_hidden = false;
$sana_layout = 'classic';
$blog_class = '';

if ( function_exists('FW') ) {

	$blog_class = 'masonry';
	$sana_layout = fw_get_db_settings_option( 'blog_layout' );
}

if ( !sana_check_active_sidebar() ) {

	$sana_sidebar_hidden = true;	
}

get_header(); ?>
<div class="inner-page margin-default">
	<div class="row <?php if ( !sana_check_active_sidebar() ): ?>centered<?php else: ?>with-sidebar<?php endif; ?>">
        <div class="col-xl-9 col-lg-8 col-md-12 ltx-blog-wrap">
            <div class="blog blog-block layout-<?php echo esc_attr($sana_layout); ?>">
				<?php

				if ( $wp_query->have_posts() ) :

	            	echo '<div class="row '.esc_attr($blog_class).'">';
					while ( $wp_query->have_posts() ) : the_post();

						// Showing classic blog without framework
						if ( !function_exists( 'FW' ) ) {

							get_template_part( 'tmpl/content-post-one-col' );
						}
							else {

							set_query_var( 'sana_layout', $sana_layout );

							if ($sana_layout == 'three-cols') {

								get_template_part( 'tmpl/content-post-three-cols' );
							}
								else
							if ($sana_layout == 'two-cols') {

								get_template_part( 'tmpl/content-post-two-cols' );
							}
								else {

								get_template_part( 'tmpl/content-post-one-col' );
							}
						}

					endwhile;
					echo '</div>';
				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'tmpl/content', 'none' );

				endif;

				?>
				<?php
				if ( have_posts() ) {

					sana_paging_nav();
				}
	            ?>
	        </div>
	    </div>
	    <?php
	    if ( !$sana_sidebar_hidden ) {

            	get_sidebar();
	    }
	    ?>
	</div>
</div>
<?php

get_footer();

