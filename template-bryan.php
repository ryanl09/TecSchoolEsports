<?php

$user=wp_get_current_user();

if($user->ID && in_array('administrator', $user->roles)) {
    get_header();
} else {
    wp_redirect('https://tecschoolesports.com');
}

?>

<script src="/htdocs/wp-content/plugins/tecschoolesports/js/alertify.js" type="text/javascript"></script>

	<div id="primary" class="content-area content-area-full-width">
		<main id="main" class="site-main" role="main">
            <h1 class="entry-title">Bryan</h1>
            <br>
            
            <div class="tmdashboardwrapper">

                <h2 id="upcomingmatches" class="clickable">Team Manager Requests</h2>
                <hr style="border:solid 1px #fff; width:100%; color:#fff;">
                <div class="tmrequests">
                    <table>
                        <thead id="umthead">
                            <tr>
                                <th>Name</th>
                                <th>School</th>
                                <th>Approve?</th>
                            </tr>
                        </thead>
                        <tbody class="umtbody">
                            <?php
                                $args = array(
                                    'role' => 'team_manager'
                                );
                                $results = 
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>