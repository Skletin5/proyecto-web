<?php
/**
 * The template for displaying the footer
 */
?>
        </div>
    </div>
    <div class="ltx-footer-wrapper">
<?php
    /**
     * Before Footer area
     */
    sana_the_before_footer();
    sana_the_subscribe_block();

    /**
     * Footer widgets area
     */
    sana_the_footer_widgets();

    /**
     * Copyright
     */
    sana_the_copyrights_section();
?>
    </div>
<?php 

    sana_the_go_top();

    /**
     * WordPress Core Function
     */   
    wp_footer();
?>
</body>
</html>
