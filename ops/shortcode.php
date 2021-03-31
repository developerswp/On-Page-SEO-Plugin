<?php
if ( ! shortcode_exists( 'on-page-seo' ) ) {
   if ( function_exists( 'on_page_seo' )) {
add_shortcode( 'on-page-seo', 'on_page_seo' );
}
}
?>