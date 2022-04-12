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


<div id="myModal" class="modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <span class="closeModal">&times;</span>
                <h2 id="mbheadertext">Highschool League Testimonials</h2>
            </div>
            <div class="modal-body" id="mbbodytext">
				<iframe id="testimonialsvid" height="600" src="https://www.youtube.com/embed/wsQrsznOl7E" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

	<div id="primary" class="content-area content-area-full-width">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'homepage' ); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
