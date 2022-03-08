<?php
/**
 * The template for the admin directory
 *
 * Template Name: Admin Directory
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
        <h1 class="entry-title">Admin Directory</h1>
        <br>
        <h2>TEC Pages</h2>
        <ul>
            <li><a href="https://tecschoolesports.com/ryan">Add Player</a></li>
            <li><a href="https://tecschoolesports.com/teamrosters">Team Rosters</a></li>
        </ul>
        <br>
        <h2>Wordpress Panels</h2>
        <ul>
            <li><a href="https://tecschoolesports.com/wp-admin">Admin</a></li>
            <li><a href="https://wordpress.com/hosting-config/tecschoolesports.com">Hosting/Database</a></li>
            <li><a href="https://tecschoolesports.com/wp-admin/edit.php?post_type=sp_event">Events</a></li>
            <li><a href="https://tecschoolesports.com/wp-admin/edit.php?post_type=sp_player">Players</a></li>
        </ul>
    </main>
</div>

<?php get_footer(); ?>