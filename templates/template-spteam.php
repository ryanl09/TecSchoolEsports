<?php
/**
 * The template for team pages
 *
 * Template Name: SP Team
 *
 * @package Rookie
 */

get_header(); ?>
<script src="/htdocs/wp-content/plugins/tecschoolesports/js/alertify.js" type="text/javascript"></script>

	<div id="primary" class="content-area content-area-full-width">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				if ( in_array( get_post_type(), array( 'sp_player', 'sp_staff', 'sp_team' ) ) ) {
					get_template_part( 'content', 'nothumb' );
				} else {
					get_template_part( 'content', 'page' );
				}
				?>

			<?php endwhile; // end of the loop. ?>


            <?php
                if (!is_subteam(get_the_ID())) {
                    echo '<h3 class="alignfull has-text-align-center has-background-color has-primary-background-color has-text-color has-background">Games We Compete In</h3>';
                }
            ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
