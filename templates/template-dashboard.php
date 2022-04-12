<?php
/**
 * The template for dashbaord page
 *
 * Template Name: Dashboard
 *
 * @package Rookie
 */
$user = wp_get_current_user();

if (!($user->ID && (in_array('team_manager', $user->roles) || in_array('administrator', $user->roles)))) {
    wp_redirect('https://tecschoolesports.com');
} else {
    get_header();
}

?>

<script src="/htdocs/wp-content/plugins/tecschoolesports/js/alertify.js" type="text/javascript"></script>
<link rel="stylesheet" href="/htdocs/wp-content/plugins/tecschoolesports/styles/dashboard.css">

    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="closeModal">&times;</span>
                <h2 id="mbheadertext">Modal Header</h2>
            </div>
            <div class="modal-body" id="mbbodytext">
                <p>Some text in the Modal Body</p>
            </div>
            <div class="modal-footer">
                <h3 id="mbfootertext">Modal Footer</h3>
            </div>
        </div>
    </div>

	<div id="primary" class="content-area content-area-full-width">
		<main id="main" class="site-main" role="main">
            <h1 class="entry-title">Dashboard</h1>
            <br>
            <?php 
                $code = find_schoolcode($user->ID);
                $link = "https://tecschoolesports.com/register/student/?schoolcode=$code";
                echo '<p class="schoolcodelink">Send this link to your students: <a href="'.$link. '">' . $link . '</a></p>';
            ?>
            <br>
            <div class="tmdashboardwrapper">
                <div class="mygamesheader">
                    <?php
                        $buttons = dashboard_teams(true);
                        for ($i = 0; $i < count($buttons); $i++) { 
                            echo '<button id="game' . $i . '" class="mygamesbox">' . $buttons[$i] . '</button>';
                        }
                    ?>
                </div>

                <h2 id="upcomingmatches" class="clickable">Upcoming Matches ⯆</h2>
                <hr style="border:solid 1px #fff; width:100%; color:#fff;">
                <div id="upcomingmatchesinfo" style="display:none;">
                    <table>
                        <thead>
                            <tr>
                                <th class="trleftalign" style="width:60%;">Opponent</th>
                                <th class="trleftalign" style="width:15%;">Date</th>
                                <th class="trleftalign" style="width:15%;">Time</th>
                                <th class="trleftalign" style="width:20%;">Roster</th>
                            </tr>
                        </thead>
                        <tbody id="ucmatchesbody">
                        </tbody>
                    </table>
                </div>

                <h2 id="pastmatches" class="clickable">Past Matches ⯆</h2>
                <hr style="border:solid 1px #fff; width:100%; color:#fff;">
                <div id="pastmatchesinfo" style="display:none;">
                    <table>
                        <thead>
                            <tr>
                                <th class="trleftalign" style="width:60%;">Opponent</th>
                                <th class="trleftalign" style="width:15%;">Date</th>
                                <th class="trleftalign" style="width:15%;">Time</th>
                                <th class="trleftalign" style="width:10%">Result</th>
                            </tr>
                        </thead>
                        <tbody id="pastmatchesbody">

                        </tbody>
                    </table>
                </div>

                <h2>Players</h2>
                <div class="playersheader">
                    <div class="plleft">
                        <h5 id="gametitle">{game}</h5>
                    </div>
                    
                    <div class="plright">
                    <a id="addplayer" class="ploption">➕</a>
                    <input type="text" id="playersearch" class="dashboardsearch">
                    </div>
                </div>
                
                <div id="playerstable" class="gametablecontainer">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:50%;">Name</th>
                                <th style="width:50%;">Options</th>
                            </tr>
                        </thead>
                        <tbody id="playersbody">
                        </tbody>
                    </table>
                </div>
                <div id="playersloader" class="loader-wrapper">
                    <div class="loader-"></div>
                </div>

            </div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>