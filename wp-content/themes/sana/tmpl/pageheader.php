<?php
	$header_wrapper = sana_get_pageheader_wrapper();
	$header_class = sana_get_pageheader_class();
	$pageheader_layout = sana_get_pageheader_layout();

    if ( is_404() ) {

    	$pageheader_layout = 'disabled';
    	$header_wrapper = '';
    }	
?>
<div class="ltx-content-wrapper <?php echo esc_attr($header_wrapper); ?>">
	<div class="header-wrapper <?php echo esc_attr($header_class .' ltx-pageheader-'. $pageheader_layout); ?>">
	<?php
		get_template_part( 'tmpl/navbar' );

		if ( $pageheader_layout != 'disabled' ) : ?>
		<header class="page-header ltx-parallax">
			<?php sana_the_tagline_header(); ?>
		    <div class="container">   
		    	<?php
		    		sana_the_h1();			
					sana_the_breadcrumbs();
				?>	    
		    </div>
		    <?php sana_the_social_header(); ?>
		</header>
		<?php endif; ?>
	</div>