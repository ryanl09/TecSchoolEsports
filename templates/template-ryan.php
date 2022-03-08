<?php
/**
 * The template for ryan
 *
 * Template Name: ryan test
 *
 * @package Rookie
 */

$user = wp_get_current_user();

if ($user->user_login==='ryanl09' || $user->user_login==='tecunknown' || $user->user_login==='tecbryan') {
    get_header();
} else {
    wp_redirect('https://tecschoolesports.com');
}

?>

<script src="/htdocs/wp-content/plugins/tecschoolesports/js/alertify.js" type="text/javascript"></script>
    <div id="primary" class="content-area content-area-full-width">
		<main id="main" class="site-main" role="main">
            <div>
                <input type="text" placeholder="name" id="studentname">
                <label for="studentname">Student name:</label>
                <input type="text" placeholder="ign" id="studentign">
                <label for="studentign">IGN:</label>
                <select id="gamesel">
                    <option value="Knockout City">Knockout City</option>
                    <option value="Overwatch">Overwatch</option>
                    <option value="Rocket League">Rocket League</option>
                    <option value="Valorant">Valorant</option>
                </select>
                <select id="dsel">
                    <option value="D1">D1</option>
                    <option value="D2">D1</option>
                </select>
                <select id="schoolsel">
                    <option value="Moshannon Valley">Moshannon Valley</option>
                    <option value="Salisbury-Elk Lick">Salisbury-Elk Lick</option>
                    <option value="Holidaysburg">Holidaysburg</option>
                    <option value="Holidaysburg">Bishop Carroll</option>
                    <?php 
                        global $wpdb;
                        $res = $wpdb->get_results("SELECT * FROM hs_staff;", ARRAY_A);
                        if ($wpdb->num_rows > 0) {
                            for ($i = 0; $i < count($res); $i++) {
                                $school=$res[$i]['school'];
                                if ($school!=='ryan') {
                                    echo '<option value="' . $school . '">' . $school . '</option>';
                                }
                            }
                        }
                    ?>
                </select>
                <button class="hollowbtn" id="addstudent">Add</button>
            </div>
            
            <div>
                <input type="text" placeholder="name" id="studentnamei">
                <input type="text" placeholder="ign" id="studentigni">
                <button class="hollowbtn" id="ignstudent">Update</button>
            </div>
        </main>

</div>

<?php get_footer(); ?>