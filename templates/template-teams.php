<?php
/**
 * The template for teams page
 *
 * Template Name: Teams
 *
 * @package Rookie
 */

get_header();
?>

<div id="primary" class="content-area content-area-full-width">
	<main id="main" class="site-main" role="main">
        <h1 class="entry-title">Teams</h1>
        <br>
        
        <div id="schoolscompetingwrapper">

        <?php

        /*<div id="schoolscompetingwrapper">

            <div class="schoolbox" id="bishopcarroll-box" onmouseover="imghover('i-bishopcarroll');" onmouseleave="imgleave('i-bishopcarroll');" onclick="imgclick('bishopcarroll');">
            <div class="schoolbox-image bishopcarroll">
            <img id="i-bishopcarroll" class="schoolbox-image-img" src="https://tecschoolesports.com/wp-content/uploads/2022/01/Bishop-Carrol-Huskies-3.png">
            </div>
            <div class="schoolbox-title"><p>Bishop Carroll</p></div>
            </div>

            <div class="schoolbox" id="foresthills-box" onmouseover="imghover('i-foresthills');" onmouseleave="imgleave('i-foresthills');" onclick="imgclick('foresthills');">
            <div class="schoolbox-image foresthills">
            <img id="i-foresthills" class="schoolbox-image-img" src="https://tecschoolesports.com/wp-content/uploads/2022/01/forest-hills-rangers-circle.png">
            </div>
            <div class="schoolbox-title"><p>Forest Hills</p></div>
            </div>

            <div class="schoolbox" id="greaterjohnstown-box" onmouseover="imghover('i-greaterjohnstown');" onmouseleave="imgleave('i-greaterjohnstown');" onclick="imgclick('greaterjohnstown');">
            <div class="schoolbox-image greaterjohnstown">
            <img id="i-greaterjohnstown" class="schoolbox-image-img" src="https://tecschoolesports.com/wp-content/uploads/2022/01/greater-johnstown-iso.png">
            </div>
            <div class="schoolbox-title"><p>Greater Johnstown</p></div>
            </div>

            </div> */



            $season = get_season(season_num());
            $args = array(
                'post_type' => 'sp_team',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
                'tax_query' => array(
                    'taxonomy' => 'sp_league',
                    'field' => 'term_id',
                    'terms' => $season
                )
            );
            $posts=get_posts($args);
            for ($i = 0; $i < count($posts); $i++) {
                $title = $posts[$i]->post_title;
                if (strpos($title, ' - ') || strpos($title, ' – ') || strpos($title, ' &#8211; ')) {
                    continue;
                }
                $id = $posts[$i]->ID;
                $tax = get_the_terms($id, 'sp_season');
                $flag = false;
                for ($j = 0; $j < count($tax); $j++) {
                    if ($tax[$j]->term_id===$season) {
                        //echo '<script>console.log(`'.$tax[$j]->term_id.', s: ' . $season . '`);</script>';
                        $flag=true;
                        break;
                    }
                }
                if ($flag) {
                    $slug = $posts[$i]->post_name;
                    echo '<div class="schoolbox" id="' . $slug . '-box" onmouseover="imghover(`i-' . $slug . '`);" onmouseleave="imgleave(`i-' . $slug . '`);" onclick="imgclick(`' . $slug . '`);">
                                <div class="schoolbox-image ' . $slug . '">
                                    <img src="' . get_the_post_thumbnail_url($id) . '" alt="' . $slug . '" id="i-' . $slug . '" class="schoolbox-image-img">
                                </div>
                                <div class="schoolbox-title"><p>' . $title . '</p></div>
                            </div>';
                }
            }
        ?>

        </div>
    </main>
</div>

<?php get_footer(); ?>