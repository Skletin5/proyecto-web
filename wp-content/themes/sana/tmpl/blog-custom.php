<?php
/**
 * The blog template file
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 */

$sana_layout = '';
$sana_sidebar_hidden = false;
$sana_sidebar = 'right';
$blog_wrap_class = 'col-xl-9 col-lg-8 col-md-12 col-xs-12';

if ( function_exists( 'FW' ) ) {

	$sana_layout = fw_get_db_post_option( $wp_query->get_queried_object_id(), 'blog-layout' );
	$sana_sidebar = fw_get_db_settings_option( 'blog_list_sidebar' );

	$sana_sidebar_custom = fw_get_db_post_option( $wp_query->get_queried_object_id(), 'sidebar-layout' );
	if ( $sana_sidebar_custom != 'default') $sana_sidebar = $sana_sidebar_custom;

	if ( $sana_sidebar == 'hidden' OR $sana_sidebar == 'disabled' ) $sana_sidebar_hidden = true;

	if ( $sana_sidebar == 'left' ) $blog_wrap_class = 'col-xl-9 col-xl-push-3 col-lg-8 col-lg-push-4 col-lg-offset-0 col-md-12 col-xs-12 ';

	$blog_class = '';
	if ( $sana_layout == 'two-cols' OR $sana_layout == 'three-cols' ) {

		$blog_class = 'masonry';
		if ( $sana_sidebar_hidden ) $blog_wrap_class = 'col-lg-12 col-xs-12';
	}
		else {

		if ( $sana_sidebar_hidden ) $blog_wrap_class = 'col-xl-9 col-lg-10 col-md-12 col-xs-12';	
	}

	if ( $sana_layout == 'classic' ) {

		$sidebar_wrap = 'with-sidebar';
	}
		else {

		$sidebar_wrap = '';
	}
}

get_header(); ?>
<div class="inner-page margin-default">
	<div class="row <?php if ( $sana_sidebar_hidden ) echo 'centered'; else echo esc_attr($sidebar_wrap); ?>">
        <div class="<?php echo esc_attr( $blog_wrap_class ); ?> ltx-blog-wrap" >
            <div class="blog blog-block layout-<?php echo esc_attr($sana_layout); ?>">
				<?php

				if ( get_query_var( 'paged' ) ) {

					$paged = get_query_var( 'paged' );

				} elseif ( get_query_var( 'page' ) ) {

					$paged = get_query_var( 'page' );
					
				} else {

					$paged = 1;
				}

				if (isset($_GET['s'])) {

					$wp_query = new WP_Query( array(
						's'		=> esc_sql( $_GET['s'] ),
						'paged' => (int) $paged,
					) );
				}
					else {

					$wp_query = new WP_Query( array(
						'post_type' => 'post',
						'paged' => (int) $paged,
					) );
				}

            	echo '<div class="row '.esc_attr($blog_class).'">';
				if ( $wp_query->have_posts() ) :

					while ( $wp_query->have_posts() ) : the_post();

						if ( !function_exists( 'fw_get_db_settings_option' ) ) {

							get_template_part( 'tmpl/content-post-one-col', $wp_query->get_post_format() );
						}
							else {

							set_query_var( 'sana_layout', $sana_layout );

							if ($sana_layout == 'three-cols') {

								get_template_part( 'tmpl/content-post-three-cols', $wp_query->get_post_format() );
							}
								else
							if ($sana_layout == 'two-cols') {

								get_template_part( 'tmpl/content-post-two-cols', $wp_query->get_post_format() );
							}
								else {

								get_template_part( 'tmpl/content-post-one-col', $wp_query->get_post_format() );
							}
						}

						endwhile;

					else :
						// If no content, include the "No posts found" template.
						get_template_part( 'tmpl/content', 'none' );

					endif;
				echo '</div>';
				?>
	        </div>
			<?php
			if ( have_posts() ) {

				sana_paging_nav();
			}
            ?>	        
	    </div>
	    <?php
	    if ( !$sana_sidebar_hidden ) {

            if ( $sana_sidebar == 'left' ) {

            	get_sidebar( 'left' );
            }
            	else  {

            	get_sidebar();
            }
	    }
	    ?>
	</div>
</div>
<?php

get_footer();
