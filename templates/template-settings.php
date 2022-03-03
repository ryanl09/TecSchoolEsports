<?php
/**
 * The template for settings page
 *
 * Template Name: Settings
 *
 * @package Rookie
 */

$user = wp_get_current_user();

if (!$user->ID) {
    wp_redirect('https://tecschoolesports.com');
} else {
    get_header();
}

?>

<script src="/htdocs/wp-content/plugins/tecschoolesports/js/alertify.js" type="text/javascript"></script>

	<div id="primary" class="content-area content-area-full-width">
		<main id="main" class="site-main" role="main">
            <h1 class="entry-title">Settings</h1>
            <br>
            <div class="settingswrapper">
                <p>IGN: </p>
                <input type="text" id="updateign">
                <p>Pronouns: </p>
                <input type="text" id="updatepronouns">
                <button class="hollowbtn" id="btnupdateprofile">Submit</button>
            </div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>