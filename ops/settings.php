<?php
// Prevent direct access.
  if ( ! defined( 'ABSPATH' ) ) {
	  
   die( 'Nice try, But not here!!!' );
   
  }

// Adding settings menu to admin panel.
add_action( 'admin_menu', 'on_page_seo_menu' );

// Settings menu initialization.
function on_page_seo_menu()
{ 

   add_menu_page ( 
		          'On Page SEO Settings',
		          'On Page SEO',
		          'manage_options',
		          'on_page_seo',
              'on_page_seo_settings_page',
              'dashicons-nametag',
              99
            );
// Registering settings option keys.
 //  add_action( 'admin_init', 'register_ops_settings_setup' );

}


function ops_pingback_header() {
  global $wp;
 $getCurrentPageUrl = home_url( $wp->request );
  ?>
  <link rel="canonical" href="<?php echo esc_url( $getCurrentPageUrl ); ?>/" />
  <meta name="robots"  content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
  <meta name="keywords" content="<?php echo esc_attr( $keywords ); ?>" />
  <meta name="<?php echo esc_attr( $metaName ); ?>" content="<?php echo esc_attr( trim( wp_strip_all_tags( $value ) ) ); ?>" />
  <?php
    printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
}
add_action( 'wp_head', 'ops_pingback_header' );

function  on_page_seo_settings_page()
{
?>
<div class="mainblock">
<div class="wrap pt-4 clearfix">
  <div class="row">
    <div class="col-lg-2 col-md-2">
    <img src="<?php echo plugins_url ("images/logo-seo.png",__FILE__); ?>" style="display:inline-block;margin-right:8px;border:2px solid #fbfbfb;border-radius:5px;box-shadow:0px 0px 5px rgba(0,0,0,.5);padding:2px;clear:both:" />
   </div>
   <div class="col-lg-10 col-md-10">
   <h1>Boots Your Ranking With OPS Plugin.</h1>
   <hr>
    <div class="alert alert-success  mt-2" role="alert">
   Did you know that when you optimize your Robots.txt, you maximize your site’s crawlability (& your ranking on search engines).

  Don't do things by halves! If you want to get PRO, go <strong>PRO</strong>.
  </div>
  </div>
</div>
<div class="container-fluid mt-3 jumbotron">
  <div class="row">
   <div class="col-lg-10 col-md-12">
  <ul class="nav nav-tabs nav-pills" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link font-weight-bold active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Settings</a>
    </li>
  <!--   <li class="nav-item">
      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">FAQ</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact Us</a>
    </li> -->
  </ul>
  <div class="tab-content mt-4" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  <div class="row">
      <div class="rt-column col-2">
          <span class="rt-label">Custom rules (for experts)</span>
      </div>
      
      <div class="rt-column col-10">
        <?php 
        if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'wordpress-seo-premium/wp-seo-premium.php' ) ) {
        } else{ do_shortcode('[on-page-seo]'); }
        $file = ABSPATH . 'robots.txt';
        if (isset($_POST['Submit']) && $_POST['noindex'] == 'noindex' && $_POST['Submit'] != '' && !isset($_POST['Reset']) ){
              $output = "User-agent: * Disallow: /\n";
                $file_open = fopen($file,"w+");
                fwrite($file_open, $output);
                fclose($file_open);
                echo '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
          <strong>Thank you! </strong>Blocking all web crawlers from all content!.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>';
           $checked = 'checked';
          }
        else if (isset($_POST['Reset']) && $_POST['Reset'] != ''){
            wp_delete_file( $file ); 
            wp_redirect($_SERVER['PHP_SELF'].'?page=on_page_seo');
            echo '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
          <strong>Rollback Done!</strong> <a href="'.$_SERVER['PHP_SELF'].'?page=on_page_seo">Refresh</a> page to see result!. 
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>';
          }
        else if (isset($_POST['Submit']) && $_POST['Submit'] != '' && $_POST['noindex'] != 'noindex'  && !isset($_POST['Reset']) ){
               $rbt = $_POST['user_agents'];
               $file_open = fopen($file,"w+");
                fwrite($file_open, $rbt);
                fclose($file_open);
                echo '<div class="alert alert-info alert-dismissible fade show mt-2" role="alert">
          <strong>Thank you!</strong> Robots.txt file updated sucessfully!. 
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>';
          }
          echo '<form action="'.$_SERVER['PHP_SELF'].'?page=on_page_seo" method="POST"> 
          <label for="file" class="form-label"><a href="'.get_site_url().'/robots.txt" target="_blank">'.get_site_url().'</a> Website Robots.txt Preview:</label>
          <textarea name="user_agents" rows="6" class="rt-area form-control" id="user_agents">';

          $datalines = file ($file);
          foreach ($datalines as $rt) {
              echo $rt;
          }                   
          echo '</textarea>
          <hr><h4>Block Search Indexing with noindex</h4>
      <div class="sorm-switch">
        <label class="switch">
        <input type="checkbox" name="noindex" value="noindex" '.$checked.'>
        <span class="slider round"></span>
        </label>
        <label>Note: Click toggle active for noindex (& Hit Submit Button)</label>
        </div><input type="submit" class="btn btn-info mt-3" name="Submit" value="Submit">  <input type="submit" class="btn btn-primary mt-3" name="Reset" value="Restore Robots.txt file by OPS">';
        echo '<h5 class="mt-2 mb-2"><a href="'.get_site_url().'/robots.txt" target="_blank"> Open Robots.txt </a></h5>';
        $sitemap = ABSPATH . 'sitemap.xml';
        if(file_exists($sitemap)) {
          echo '<h5 class="mt-2 mb-2"><a href="'.get_site_url().'/sitemap.xml" target="_blank">View sitemap.xml</a></h5>';
        }
       ?>
    <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
      <strong>Note!</strong> Add more custom rules if you need them, otherwise, leave it with default rules. 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>      
  </div>  
  </div>
  </div>
  </div>
  </div>
  <div class="col-lg-2 d-none d-lg-block">
     <div id="scrollspy" class="sticky-top" style="top: 80px;">
        <!--DC content-->
        <div id="dpl-gtm-scroll">
           <div id="gtmDC-scroll-unlogged">
              <div id="s1-download-mdb-free" class="alert alert-success" role="alert" data-color="success"> Need <strong>Manual</strong> On Page SEO <strong>!</strong>. Are you need SEO Services?<a href="https://wa.me/919711425615" class="btn btn-success btn-sm mt-2 mb-0 btn-block"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
  </svg> Contact Us</a> </div>
           </div>
        </div> 
        <!--/DC content-->
        <ul class="nav flex-column nav-pills menu-sidebar" data-mdb-allow-hashes="true">
           <li class="nav-item">
              <a class="nav-link active" href="https://wa.me/919711425615"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
  </svg> Support</a>
           </li>
        </ul>
     </div>
  </div>
  </div>
  </div>
</div>
</div>
<?php } ?>