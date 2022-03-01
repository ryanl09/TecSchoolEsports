
<script src="/htdocs/wp-content/plugins/TheEsportCompany/js/alertify.js" type="text/javascript"></script>

<?php

/*
* The template for the edit player profile page(TEC players+admins only)
 *
 * Template Name: Edit Profile Page
 *
 * @package Rookie
*/
$success = false;

$user = wp_get_current_user();
if ('POST' === $_SERVER['REQUEST_METHOD'] && !isset($_POST['UPDATINGIMAGE'])) {
    if ($_FILES) {

        $pageid = get_user_meta($user->ID, 'pageid', true);
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		require_once(ABSPATH . "wp-admin" . '/includes/media.php');

        $upload_dir = wp_upload_dir();
        $files = $_FILES['thumbnail'];
        $file_name = sanitize_file_name($files['name']);
        $file_vars = array('test_form' => FALSE);
        $file_post = wp_handle_upload($files, $file_vars);
        $file_link = $file_post['url'];
        $file_type = wp_check_filetype(basename($file_link), null);

        $post_name = preg_replace('/\.[^.]+$/', '', basename($file_link));

        $attachment = array(
            'guid' => $file_link,
            'post_mime_type' => $file_type['type'],
            'post_title' => $post_name,
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $file_name = $upload_dir['path'] . '/' . basename($file_name);
        $attach_id = wp_insert_attachment($attachment, $file_name);
        $attach_data = wp_generate_attachment_metadata($attach_id, $file_name);
        $attach_final = wp_update_attachment_metadata($attach_id, $attach_data);
        $value = set_post_thumbnail($pageid, $attach_id);
        //update_post_meta($pageid, '_thumbnail_id', $attach_id);
        
        die();
    } 
} else {
    if ($user->ID && (in_array('tecplayer', $user->roles) || in_array('administrator', $user->roles)) ) {
        get_header();
    } else {
        wp_redirect('https://tecleagues.com');
    }
}

?>

<script src="/htdocs/wp-content/plugins/tecschoolesports/js/alertify.js" type="text/javascript"></script>
<div id="primary" class="content-area content-area-full-width">
		<main id="main" class="site-main" role="main">
            <div id="leftwrapper" style="float:left; width:50%;"> <!--  -->
                <div id="fontwrapper">
                    <p>Font:</p>
                    
                </div>
                <div id="bgcolorwrapper">
                    <p>BG color:
                    <input id="bgcolor" type="text" placeholder="#000000">
                    <input type="color" id="bgcolor-picker" ></p>
                </div>
                <br>
                <div id="textcolorwrapper">
                    <p>Text color:
                    <input id="textcolor" type="text" placeholder="#000000">
                    <input type="color" id="textcolor-picker"></p>
                </div>
                <br>
                <div id="headercolorwrapper">
                    <p>Header color:
                    <input id="headercolor" type="text" placeholder="#000000">
                    <input type="color" id="headercolor-picker"></p>
                </div>
                <br>
                <div id="menucolorwrapper">
                    <p>Menu color:
                    <input id="menucolor" type="text" placeholder="#000000">
                    <input type="color" id="menucolor-picker"></p>
                </div>
                <br>
                <div id="linkcolorwrapper">
                    <p>Link text color:
                    <input id="linkcolor" type="text" placeholder="#000000">
                    <input type="color" id="linkcolor-picker"></p>
                </div>
                <br>
                <div id="linkhovercolorwrapper">
                    <p>Link text hover color:
                    <input id="linkhovercolor" type="text" placeholder="#000000">
                    <input type="color" id="linkhovercolor-picker"></p>
                </div>
                <br>
                <div id="twitchwrapper">
                    <p>Twitch username:
                    <input id="twitchusername" type="text" placeholder="Username"></p>
                </div>
                <button id="btnreset">Reset to default</button>
                <br>
                <p>Bio:</p>
            </div>

            <div id="rightwrapper" style="float:right; width: 40%;"> <!--  style="position:absolute; right:0; width:40%;" -->
                <br>
                
                <?php
                $thumbnail = get_the_post_thumbnail_url(get_user_meta(wp_get_current_user()->ID, 'pageid', true));
                ?>
                <form id="file-upload-form" method="post" enctype="multipart/form-data" target="postiframe">
                    <p> Upload profile picture:</p>
                    <input type="file" style="float:left; width:70%;" accept="image/*" name="thumbnail" id="thumbnail">
                    <?php 
                    if (!empty($thumbnail)&&$thumbnail!=='') { 
                        echo '<a href="javascript:removepfp();" style="float:right; width:30%;" id="removepfp" style="font-size:30px;">❌</a>';
                    }?>
                    <br>
                    <input type="text" name="submitphoto" id="submitphoto" style="display:none;" value="set">
                </form>
                <iframe id="postiframe" name="postiframe" style="display:none;"></iframe>
                <br>
                
                <?php
                if (!empty($thumbnail)&&$thumbnail!=='') {
                    echo '<img id="displaypfp" src="' . $thumbnail . '" width="300" height="400">';
                }
                ?>
            </div>

            
            <div id="postcontentwrapper" style="float:left; width:100% !important;">
                <br>
                <!--<input style="right:0;" type="checkbox" id="isvisual"> -->
                <!--<label for="isvisual">HTML Visual</label>-->
                <div id="pagewpr">
                    <textarea style="height:500px;" id="playerpagecontent"></textarea>
                </div>
                <div id="ubwrapper">
                    <button id="btnupdate">Update</button>
                    <!-- <img id="loadingwheel" style="display:none;" width="30" height="30" src="https://tecleagues.com/wp-content/uploads/2021/08/loading.gif" alt="loading"></p> -->
                    <!-- <progress id="updatethis" max="100" value="0"></progress> -->
                </div>
            </div>
            <br>

            
		</main><!-- #main -->
	</div><!-- #primary -->


<?php 
get_footer(); ?>


