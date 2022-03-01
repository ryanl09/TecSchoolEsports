<?php
/**
 * The template for displaying the homepage.
 *
 * Template Name: Homepage
 *
 * @package Rookie
 */

get_header(); ?>

<script src="/htdocs/wp-content/plugins/tecschoolesports/js/alertify.js" type="text/javascript"></script>
<link rel="stylesheet" href="/htdocs/wp-content/plugins/tecschoolesports/styles/homepage.css">

	<div id="primary" class="content-area content-area-<?php echo rookie_get_sidebar_setting(); ?>-sidebar">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'homepage' ); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
