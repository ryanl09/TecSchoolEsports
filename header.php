<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Rookie
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://tecschoolesports.com/htdocs/wp-content/plugins/tecschoolesports/js/util/DateFormatter.js" type="text/javascript"></script>
<script src="https://tecschoolesports.com/htdocs/wp-content/plugins/tecschoolesports/js/util/Popup.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script>
    $(document).ready(function(){
    let progress = document.getElementById('progressbar');
    let theight = document.body.scrollHeight - window.innerHeight;
    window.onscroll = function() {
      let pheight = (window.pageYOffset / theight) * 100;
      progress.style.height = pheight+"%";
    }
  });
</script>
<link href="https://tecschoolesports.com/htdocs/wp-content/plugins/tecschoolesports/styles/popup.css" rel="stylesheet">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="sp-header"><?php do_action( 'sportspress_header' ); ?></div>
<div id="page" class="hfeed site">
  <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'rookie' ); ?></a>

  <header id="masthead" class="site-header" role="banner">
    <div class="header-wrapper">
      <?php rookie_header_area(); ?>
    </div><!-- .header-wrapper -->
  </header><!-- #masthead -->

  <div id="content" class="site-content">
    <div class="content-wrapper">
      <?php do_action( 'rookie_before_template' ); ?>
