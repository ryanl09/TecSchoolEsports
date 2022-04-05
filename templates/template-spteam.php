<?php
/**
 * The template for team pages
 *
 * Template Name: SP Team page
 *
 * @package Rookie
 */

get_header(); ?>
<script src="/htdocs/wp-content/plugins/tecschoolesports/js/alertify.js" type="text/javascript"></script>
<link rel="stylesheet" href="/htdocs/wp-content/plugins/tecschoolesports/styles/spteam.css">

	<h1 class="entry-title"><?php echo get_the_title(); ?></h1>

	<div id="primary" class="content-area content-area-full-width">
		<main id="main" class="site-main" role="main">

			<div class="linewrapper">
				<div class="gridline" 
					<?php 
						global $wpdb;
						$primary = $wpdb->get_results("SELECT pcolor FROM hs_staff WHERE school = '" . get_the_title() . "';", ARRAY_A);
						if($wpdb->num_rows > 0) {
							echo "style=\"background-color:" . $primary[0]['pcolor']."\"";
						}
					?> 
				>

				</div>
				<div class="gridline"
					<?php
						global $wpdb;
						$secondary = $wpdb->get_results("SELECT scolor FROM hs_staff WHERE school = '" . get_the_title() . "';", ARRAY_A);
						if($wpdb->num_rows > 0) {
							echo "style=\"background-color:" . $secondary[0]['scolor']."\"";
						}
					?>
				>

				</div>
			</div>
            <?php
				$teamid = get_the_ID();
                if (!is_subteam($teamid)) {
                    echo '<h3 class="alignfull has-text-align-center team-' . $teamid . ' has-background-color has-primary-background-color has-text-color has-background">Games We Compete In</h3>';
					$c = get_children(array(
						'post_parent' => $teamid,
						'post_type' => 'sp_team'));

					function cmp ($a, $b) {
						return strcmp($a->post_name, $b->post_name);
					}

					usort($c, "cmp");

					echo '<div class="gameboxwrapper">';
					$season = get_season(season_num());
					for ($i = 0; $i < count($c); $i++) { 

						$id = $c[$i]->ID;
						$flag = false;
						
						$tax = get_the_terms($id, 'sp_season');
						for ($j = 0; $j < count($tax); $j++) {
							if ($tax[$j]->term_id===$season) {
								$flag=true;
								break;
							}
						}

						if ($flag) {
							$title = team_to_game($c[$i]->post_title);
							$slug = $c[$i]->post_name;
							//echo '<script>console.log(`s: ' . $slug . '`);</script>';
							$perma = get_permalink();
							$perma .= ($perma[strlen($perma)-1]==='/'?'':'/') . $slug;
							echo '<div class="schoolbox" id="' . $slug . '-box" onmouseover="imghover(`i-' . $slug . '`);" onmouseleave="imgleave(`i-' . $slug . '`);" onclick="teamclick(`' . $perma . '`);">
										<div class="schoolbox-image ' . $slug . '">
											<img src="' . slug_to_image($slug) . '" alt="' . $slug . '" id="i-' . $slug . '" class="schoolbox-image-img">
										</div>
										<div class="schoolbox-title"><p>' . $title . '</p></div>
									</div>';
						}

					}
					echo '</div>';



					/*<div class="gameboxwrapper">
						<div class="schoolbox" id="overwatchd1-box" onmouseover="imghover('i-overwatchd1');" onmouseleave="imgleave('i-overwatchd1');" onclick="stdclick('overwatchd1spring2022');">
							<div class="schoolbox-image overwatch">
								<img src="https://tecschoolesports.com/wp-content/uploads/2021/10/tec-ov-e1642548358670.png" alt="Overwatch D1" id="i-overwatchd1" class="schoolbox-image-img">
							</div>
							<div class="schoolbox-title"><p>Overwatch D1</p></div>
						</div>

						<div class="schoolbox" id="overwatchd2-box" onmouseover="imghover('i-overwatchd2');" onmouseleave="imgleave('i-overwatchd2');" onclick="stdclick('overwatchd2spring2022');">
							<div class="schoolbox-image overwatch">
								<img src="https://tecschoolesports.com/wp-content/uploads/2021/10/tec-ov-e1642548358670.png" alt="Overwatch D2" id="i-overwatchd2" class="schoolbox-image-img">
							</div>
							<div class="schoolbox-title"><p>Overwatch D2</p></div>
						</div>
					</div>*/

                }
            ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
