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
        
        <div class="schoolscompetingwrapper">
            
        </div>
        
        <?php 
            global $wpdb;
            $res = $wpdb->get_results("SELECT * FROM hs_staff;", ARRAY_A);
            if ($wpdb->num_rows > 0) {
                for ($i = 0; $i < count($res); $i++) {
                    $school=$res[$i]['school'];
                    $lower = strtolower(str_replace(' ', '', $school));
                    if ($school==='ryan') {
                        continue;
                    }
                    
                }
            }
        ?>
    </main>
</div>

<?php get_footer(); ?>