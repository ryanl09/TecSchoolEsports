<?php
/**
 * The template for roster graphic page
 *
 * Template Name: ROSTER PAGE
 *
 * @package Rookie
 */

$roles = wp_get_current_user()->roles;

if (in_array('administrator', $roles)) {
    get_header();
} else {
    wp_redirect('https://tecschoolesports.com');
}

?>

<div id="primary" class="content-area content-area-full-width">
	<main id="main" class="site-main" role="main">
        <h1 class="entry-title">Team Rosters</h1>
        
    </main>
</div>


<?php get_footer(); ?>