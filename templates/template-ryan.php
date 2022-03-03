<?php

$user = wp_get_current_user();

if ($user->user_login==='ryanl09') {
    get_header();
} else {
    wp_redirect('https://tecschoolesports.com');
}

?>

<script src="/htdocs/wp-content/plugins/tecschoolesports/js/alertify.js" type="text/javascript"></script>
    <div id="primary" class="content-area content-area-full-width">
		<main id="main" class="site-main" role="main">
            <div>
                <input type="text" placeholder="Name" id="studentname">
                <label for="studentname"></label>
            </div>
        </main>

</div>

<?php get_footer(); ?>