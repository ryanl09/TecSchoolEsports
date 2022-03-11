<?php
/**
 * The template for all team rosters
 *
 * Template Name: Team Rosters
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



<link rel="stylesheet" href="/htdocs/wp-content/plugins/tecschoolesports/styles/teamrosters.css">
<div id="primary" class="content-area content-area-full-width">
	<main id="main" class="site-main" role="main">
        <h1 class="entry-title">Team Rosters</h1>
        <?php

            $teams = ['Holidaysburg', 'Moshannon Valley', 'Salisbury-Elk Lick', 'Bishop Carroll'];

            global $wpdb;
            $res = $wpdb->get_results("SELECT * FROM hs_staff;", ARRAY_A);
            if ($wpdb->num_rows > 0) {
                for ($i = 0; $i < count($res); $i++) {
                    $school=$res[$i]['school'];
                    if ($school==='ryan' || in_array($school, $teams)) {
                        continue;
                    }
                    $teams[count($teams)] = $school;
                }
            }

            /*
                            <h2>+ ' . $teams[$i] . '</h2>
                            <div id="team-' . strtolower(str_replace(' ', '' $teams[$i])) . '-content" style="display:none;">
    
                            </div>
            */
                sort($teams);

                $tables=[];
                $MASTER = array();
                $args = array(
                    'post_type' => 'sp_player',
                    'post_status' => 'publish',
                    'posts_per_page' => -1
                );
                $posts=get_posts($args); //get all players

                for ($i = 0; $i < count($posts); $i++) { //foreach player
                    $name = $posts[$i]->post_title;
                    $id = $posts[$i]->ID;
                    $meta = get_post_meta($id, 'sp_team', false);
                    $ign = get_post_meta($id, 'ign', true); //get all player info name, ign, teams...

                    if (!$ign) {
                        global $wpdb;
                        $res = $wpdb->get_results("SELECT `ign` FROM hs_players WHERE name='" . $name . "';", ARRAY_A);
                        $ign = $wpdb->num_rows > 0 ? $res[0]['ign'] : 'N/A' ;
                    } //if ign isnt in meta, get it from database

                    for ($j = 0; $j < count($meta); $j++) { //foreach team the player is on
                        if ($meta[$j] < 1) {
                            continue;
                        }
                        $title = get_the_title($meta[$j]);
                        $title = str_replace('–', '-', $title);
                        $title = str_replace('&#8211;', '-', $title);
                        $MASTER[$title][count($MASTER[$title])] = array(
                            'name' => $name,
                            'ign' => $ign
                        );
                    }
                }

                for ($i = 0; $i < count($teams); $i++) { //for each highschool team

                    $teamid = post_exists($teams[$i], '', '', 'sp_team'); //get team in list
                    $c = array_keys(get_children(array(
                        'post_parent' => $teamid,
                        'post_type' => 'sp_team'), ARRAY_N)); //get all subteams

                    for ($j = 0; $j < count($c); $j++) { //foreach subteam page
                        $t = get_the_title($c[$j]);
                        $t = str_replace('–', '-', $t);
                        $t = str_replace('&#8211;', '-', $t);
                        $stradd = '';
                        for ($k= 0; $k < count($MASTER[$t]); $k++) {
                            //echo '<script>console.log("name: ' . $t . ', id: ' . $MASTER[$t][$k][] . '");</script>';
                            $stradd .= '
                            <tr>
                                <td>' . $MASTER[$t][$k]['name'] . '</td>
                                <td>' . $MASTER[$t][$k]['ign'] . '</td>
                            </tr>';
                        }
                        
                        
                        $tables[$teams[$i]] .= '<h4>' . $t . '</h4>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>IGN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ' . $stradd . '
                                </tbody>
                            </table>';
                    }

                    $lower=str_replace(' ', '', strtolower($teams[$i]));
                    echo '<div id="team-' . $lower . '" class="teamrosterheader" onclick="slide(`' . $lower . '`);">
                            <h3 id="' . $lower . '-header">+ ' . $teams[$i] . '</h3>
                            <div id="team-' . $lower . '-content" style="display:none;">
                                ' . $tables[$teams[$i]] . '
                            </div>
                        </div>';
                }

                /*echo '<pre>';
                $keys = array_keys($tables);
                print_r($keys);
                echo '</pre>';*/
        ?>
    </main>
</div>

<? get_footer(); ?>