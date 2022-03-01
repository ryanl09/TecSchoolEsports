<?php

/**
* Plugin Name: The Esport Company
* Plugin URI: https://www.theesportcompany.com
* Description: do a lot of stuff
* Version: 0.3
* Author: Ryan Leitenberger
**/

/*
* not really sure why we had to do it this way
*/

add_action('init', 'tecleagues');

function tecleagues() {
	wp_register_script('main', plugin_dir_url(__FILE__) . 'js/main.js');
	wp_localize_script('main', 'info', array('loggedin' => is_user_logged_in()));
	wp_enqueue_script('main');
}

add_action('wp_enqueue_scripts', 'tecinit');

$THIS_SEASON = 1360;

/*

register_activation_hook(__FILE__, 'my_activation');
 
function my_activation() {
    if (! wp_next_scheduled ( 'check_messages' )) {
    wp_schedule_event(time(), 'hourly', 'check_messages');
    }
}

*/

//league_season_team

/*
function tec_auth($user) {
	$banned = get_user_option('tecbanned', $user->ID, false);
	if ($banned) {
		return new WP_Error( 'tecbanned', __('<strong>ERROR</strong>: This account has been banned.', 'tec') );
	}
}

add_filter('wp_authenticate_user', 'tec_auth');

*/

function insert_action($name, $user) {
	global $wpdb;
	$wpdb->insert('tec_actions', array('name' => $name, 'user' => $user));
}

function tecinit() {
	$adm = 'admin-ajax.php';
	if ( ! is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
		$post_title=strtolower(trim(get_the_title()));
		$new = refresh_messages(0);
		$hideteam = '';
		if ($post_title==='inbox') {
			$new = 0;
		}
		if ($post_title==='account'){
			$hideteam = 'mepr_mepr_team';
		}
		wp_register_script('fixmenuicon', plugin_dir_url(__FILE__) . 'js/fixmenuicon.js');
		wp_localize_script('fixmenuicon', 'thisuser', array('name' => wp_get_current_user()->user_login,
	'msg' => $new,'hideteam'=>$hideteam));
		wp_enqueue_script('fixmenuicon');

		
		if (in_array('gm', wp_get_current_user()->roles) || in_array('administrator', wp_get_current_user()->roles)) {
			// user is gm or admin
		} else {
			wp_register_script('showdash', plugin_dir_url(__FILE__) . 'js/showdash.js');
			wp_localize_script('showdash', 'thisuser', array('gm' => false));
			wp_enqueue_script('showdash');
		}

		$intid = get_the_ID();
		if (get_post_type()==='sp_player') {
			$user = get_user_by('login', get_the_title());
			$result = '';
			if ($user) {
				$member = new MeprUser();
				$member->ID = $user->ID;
				$m_result = $member->active_product_subscriptions('ids');
				if(!empty($m_result)) {
					if (in_array('1888', $m_result) || in_array('1887', $m_result)) {
						$currentpage = get_post($intid);
						if ($currentpage->post_status==='private') {
							wp_update_post(array(
								'ID' => $intid,
								'post_status' => 'publish'
							));
						}

						if (in_array('1888', $m_result)) {
							$result = 'pro';
						} else {
							$result = 'plus';
						}
					}
				} else {
					if ($currentpage->post_status==='publish') {
						wp_update_post(array(
							'ID' => $intid,
							'post_status' => 'private'
						));
					}
				}
			}
			$values = get_post_meta($intid, 'teccustom', true);
			wp_register_script('player', plugin_dir_url(__FILE__ ) . 'js/player.js', array('jquery'));
			wp_localize_script('player', 'myAjax', array( 'ajaxurl' => admin_url($adm), 'membership' => $result));
			wp_enqueue_script('player');
			wp_register_script('updateplayerstyle', plugin_dir_url(__FILE__) . 'js/updateplayerstyle.js', array('jquery'));
			wp_localize_script('updateplayerstyle', 'stuff', $values);
			wp_enqueue_script('updateplayerstyle');
		} else if (get_post_type()==='sp_team') {
			$values = get_post_meta($intid, 'teccustom', true);
			wp_register_script('updateteamstyle', plugin_dir_url(__FILE__) . 'js/updateteamstyle.js', array('jquery'));
			wp_localize_script('updateteamstyle', 'stuff', $values);
			wp_enqueue_script('updateteamstyle');
		} 
		else 
		{
			$user = wp_get_current_user();
			$post_title=strtolower(trim(get_the_title()));
			if ($post_title==='standings') {
	
			}
			else if ($post_title==='schedule') {
				wp_register_script('tecschedule', plugin_dir_url(__FILE__ ) . 'js/schedule.js', array('jquery'));
				wp_localize_script('tecschedule', 'myAjax', array( 'ajaxurl' => admin_url($adm)));
				wp_enqueue_script('tecschedule');
			} 
			else if ($post_title==='stats') {
				//insert_action('stats', 'ryanl09');
				wp_register_script('thestats', plugin_dir_url(__FILE__ ) . 'js/stats.js', array('jquery'));
				wp_localize_script('thestats', 'myAjax', array( 'ajaxurl' => admin_url($adm)));
				wp_enqueue_script('thestats');
			} 
			else if ($post_title==='edit profile') {
				$mepr = new MeprUser();
				if (is_user_logged_in()) {
					$mepr->ID = wp_get_current_user()->ID;
					$act = $mepr->active_product_subscriptions('ids');
					if (in_array('1887', $act) || in_array('1888', $act)) {
						$pageid = get_user_meta(wp_get_current_user()->ID, 'pageid', true);
						$customfields = get_post_meta($pageid, 'teccustom', true);
						$customfields['content'] = get_post($pageid)->post_content;
					} else {
						wp_redirect('https://tecleagues.com');
					}
				} else {
					wp_redirect('https://tecleagues.com');
				}
				wp_register_script('editplayerpage', plugin_dir_url(__FILE__ ) . 'js/editplayerpage.js', array('jquery'));
				wp_localize_script('editplayerpage', 'stuff', $customfields);
				wp_enqueue_script('editplayerpage');
			} else if ($post_title==='inbox') {
				wp_register_script('inbox', plugin_dir_url(__FILE__) . 'js/inbox.js', array('jquery'));
				wp_localize_script('inbox', 'myAjax', array( 'ajaxurl' => admin_url($adm)));
				wp_enqueue_script('inbox');
			}else if ($post_title==='thank you') {




//give discord role

					




					$SEASONID = 1360; //season5

					$m = new MeprUser(); //get memberuser
					$m->ID = $user->ID; //set id
					$act = $m->active_product_subscriptions('ids'); //get subs
					$havepage = get_user_meta($user->ID, 'pageid', false);
					
					if ($havepage) { //upgrade!
						$p_id = $havepage[0];
						if (in_array('1887', $act) || in_array('1888', $act)) { //has page, has plus
							wp_update_post(array(
								'ID' => $p_id,
								'post_status' => 'publish'
							));
						} else {	//has page, no plus
							wp_update_post(array(
								'ID' => $p_id,
								'post_status' => 'private'
							));
						}
						
					} else { //new account!
						$post_status='private';
						if (in_array('1887', $act) || in_array('1888', $act)) { //no page, has plus
							$post_status = 'publish';
						}
						$args = array(
							'post_title' => $user->user_login,
							'post_status' => $post_status,
							'post_author' => '208183280',
							'post_type' => 'sp_player'
						);
						$playerpageid = wp_insert_post($args, true);
						add_user_meta($user->ID, 'pageid', $playerpageid);
						update_user_option('tecbanned', $user->ID, false, false);

						//set sportspress stuff

						//update_pl_sp();
						
						$columns = getcolumns($game);

						$stats = array();

						// get age

						$birthday = get_user_meta($user->ID, 'mepr_date_of_birth', true);
						$birthday = new DateTime($birthday);
						$interval = $birthday->diff(new DateTime);

						//get ign

						$ign = get_user_meta($user->ID, 'mepr_ign_in_game_name', true);

						//get location

						$location = get_user_meta($user->ID, 'mepr-address-city', true) . ', ' . get_user_meta($user->ID, 'mepr-address-state', true);

						//get discord

						$discord = get_user_meta($user->ID, 'mepr_discord_name', true);

						$metrics = array(
							'age' => $interval->y,
							'ign' => $ign,
							'location' => $location,
							'discordusername' => $discord
						);
						
						echo '<script>console.log("set metrics");</script>';
						$approval = 'no';
						$welcome = 'Your team request is being processed!';
						
						
						if (get_user_meta($user->ID, 'mepr_team', true)==='freeagency') {
							$approval = 'yes';
							$welcome = 'You can request to join a team here: <a href="https://tecleagues.com/teamrequest">https://tecleagues.com/teamrequest</a>';
						}

						update_user_meta($user->ID, 'teamapproved', $approval);
						update_post_meta($playerpageid, 'sp_metrics', $metrics);
						update_post_meta($playerpageid, 'sp_columns', $columns);
						update_post_meta($playerpageid, 'sp_statistics', $stats);

						//send message

						system_message($user->ID, 'Welcome to TEC Leagues! ' . $welcome);

						//done
					}
					wp_register_script('createpage', plugin_dir_url(__FILE__) . 'js/createpage.js', array('jquery'));
					wp_localize_script('createpage', 'user', array('name' => $user->user_login));
					wp_enqueue_script('createpage');
			} else if ($post_title==='admin') {
				wp_register_script('admin', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'));
				//
				wp_enqueue_script('admin');
			} else if ($post_title==='report a bug') {
				wp_register_script('sendbug', plugin_dir_url(__FILE__) . 'js/sendbug.js', array('jquery'));
				wp_enqueue_Script('sendbug');
			} else if ($post_title==='edit team page') {

				//need to get all postmetafields
				$theteamid = tecgetid();
				$customfields = get_post_meta($theteamid, 'teccustom', true);
				$customfields['content'] = get_post($theteamid)->post_content;
				$adminuser = wp_get_current_user();
				if (in_array('administrator', $adminuser->roles)) {
					$customfields['teampageid'] = $theteamid;
				}

				wp_register_script('editteampage', plugin_dir_url(__FILE__) . 'js/editteampage.js', array('jquery'));
				wp_localize_script('editteampage', 'stuff', $customfields);
				wp_enqueue_script('editteampage');
			} else if($post_title==='team request') {
				$onteam=get_user_meta($user->ID, 'mepr_team', true);
				$app = get_user_meta($user->ID, 'teamapproved', true);
				$customfields=array('team' => $onteam, 'app' => $app,'ajaxurl' => admin_url($adm));
				wp_register_script('teamrequest', plugin_dir_url(__FILE__) . 'js/teamrequest.js', array('jquery'));
				wp_localize_script('teamrequest', 'stuff', $customfields);
				wp_enqueue_script('teamrequest');
			} else if ($post_title==='gm dashboard') {
				$gmuser = wp_get_current_user();
				if ((in_array('gm', $gmuser->roles) || in_array('agm', $gmuser->roles) || in_array('administrator', $gmuser->roles)) && $gmuser->ID) {
					$users = get_users(array('fields' => array('ID','user_login')));
					$local_players=array();
					$userinfo = array();
					$gmteam = get_user_meta($gmuser->ID, 'mepr_team', true);
					foreach($users as $user) {
						$meta = get_user_meta($user->ID);
						$fullteam = str_replace(' ', '', strtolower(convert($gmteam)));
						if (trim($meta['mepr_team'][0])===trim($gmteam)&&strtolower($user->user_login)!==$fullteam . 'gm') {
							$thegame=$meta['mepr_game'][0];
							$thediv=$meta['mepr_division'][0];
							$approved=$meta['teamapproved'][0];
							if ($approved===''||empty($approved)) { $approved='yes'; }
							$c_count=count($local_players[$approved][$thegame][$thediv]);
							$local_players[$approved][$thegame][$thediv][$c_count]=array(
								'name' => $user->user_login,
								'discord' => $meta['mepr_discord_name'][0]
							);
							$roles=get_userdata($user->ID)->roles;
								$userinfo[$user->user_login]=array(
									'captain' => in_array('tec_captain',$roles)?1:0,
									'agm' => in_array('agm', $roles)?1:0
								);
						}
					}

					if (empty($local_players) && count($local_players)===0) {
						$local_players='No players found!';
					}
					wp_register_script('gmdashboard', plugin_dir_url(__FILE__) . 'js/gmdashboard.js', array('jquery'));
					wp_localize_script('gmdashboard', 'players', $local_players);
					wp_localize_script('gmdashboard', 'userinfo', $userinfo);
					wp_enqueue_script('gmdashboard');
				}
			}
		}
	}
}

/*
	function to change pl role (gm dashboard)
*/

function gm_addrole() {
	$ret = '';
	$captain=0;
	$agm=0;
	if (isset($_POST['captain']) && isset($_POST['agm']) && isset($_POST['player'])) {
		$captain = $_POST['captain'];
		$agm = $_POST['agm'];
		$player = get_user_by('login', $_POST['player']);
		if ($player->ID) {
			$player = new WP_User($player->ID);
			if($captain){
				$player->add_role('tec_captain');
			}else{
				$player->remove_role('tec_captain');
			}
			if($agm){
				$player->add_role('agm');
			}else{
				$player->remove_role('agm');
			}
			$ret='[Success] Roles updated!';
		} else {
			$ret = '[Error] User does not exist!';
		}
	} else {
		$ret = '[Error] Fields are missing!';
	}
	echo $ret;
	die();
}

add_action('wp_ajax_gm_addrole', 'gm_addrole');
add_action('wp_ajax_nopriv_gm_addrole', 'gm_addrole');

/*
	function to approve a player for a team
*/

function approve_player() {
	$ret = '';
	$players = '';
	$approve=$_POST['approve'];
	if (isset($_POST['player'])) {
		if (is_array($_POST['player'])) {
			$pl = $_POST['player'];
			for ($i = 0; $i < count($pl); $i++){
				$line = explode('|', $pl[$i], 2);
				$ret += apr_h($approve, $line[0], $line[1]);
				$players .= $line[0] . ' | ';
			}
			if (strpos($ret, '[Error]')!==false) {
				$ret = '[Error] There was an error processing one or more players.';
			} else {
				$stat = ' approved!';
				if($appr==='no'){
					$stat = ' rejected.';
				}
				$ret = '[Success] All players were' . $stat . '<>' . $players;
			}
		} else {
			if (isset($_POST['division'])) {
				$ret = apr_h($approve, $_POST['player'], $_POST['division']);
		
			} else {
				$ret = '[Error] Fields are missing!';
			}
		}
	}
	echo $ret;
	die();
}

add_action('wp_ajax_approve_player', 'approve_player');
add_action('wp_ajax_nopriv_approve_player', 'approve_player');

/*
	function to update system info for player so that method above looks nicer
*/

function apr_h($approve, $player, $division) {
	$ret = '';
	$user= get_user_by('login', $player);
	if ($user->ID) {
		$status = get_user_meta($user->ID, 'teamapproved', true);
		if ($status===$approve && $status==='yes') {
			$ret = '[Error] Player already has approval status of: ' . $approve;
		} else {
			update_user_meta($user->ID, 'teamapproved', $approve);
			update_user_meta($user->ID, 'mepr_division', $division);
			update_pl_sp($approve, $user);
			$ret = '[Success] Player team status updated! Approved: ' . $approve;
			if ($approve==='no') {
				update_user_meta($user->ID, 'mepr_team', 'freeagency');
				system_message($user->ID, 'Sorry, your team request was denied. You can request again here: <a href="https://tecleagues.com/teamrequest">https://tecleagues.com/teamrequest</a>');
			} else {
				system_message($user->ID, 'Your team request was approved!');
			}
		}
	} else {
		$ret = '[Error] User does not exist!';
	}
	return $ret;
}

/*
	function to remove a player from the team
*/

function removeplayer() {
	$ret='[Success] Player removed successfully!';
	if(isset($_POST['player'])) {
		$user=get_user_by('login',$_POST['player']);
		if($user->ID){
			update_user_meta($user->ID, 'mepr_team', 'freeagency');
			update_pl_sp('no', $user);
			$user->remove_role('tec_captain');
			$user->remove_role('agm');
			system_message($user->ID, 'Sorry, you were removed from your current team. You can reapply here: <a href="https://tecleagues.com/teamrequest">https://tecleagues.com/teamrequest</a>');
		} else {
			$ret = '[Error] Player does not exist.';
		}
	} else {
		$ret = '[Error] Fields are missing.';
	}
	echo $ret;
	die();
}

add_action('wp_ajax_removeplayer', 'removeplayer');
add_action('wp_ajax_nopriv_removeplayer', 'removeplayer');

/*
	function to send noti to discord

function send_discord($userid) {
	$discordname = get_user_meta($userid, 'mepr_discord_name', true);
}

*/

/*
	function to create custom post types (support ticket)
*/


function create_posttypes() {
	/* Create the ticket post type
	*/
	$labels = array(
        'name'                => _x( 'Tickets', 'Post Type General Name', 'rookie' ),
        'singular_name'       => _x( 'Ticket', 'Post Type Singular Name', 'rookie' ),
        'menu_name'           => __( 'Tickets', 'rookie' ),
        'parent_item_colon'   => __( 'Parent Ticket', 'rookie' ),
        'all_items'           => __( 'All Tickets', 'rookie' ),
        'view_item'           => __( 'View Ticket', 'rookie' ),
        'add_new_item'        => __( 'Add New Ticket', 'rookie' ),
        'add_new'             => __( 'Add New', 'rookie' ),
        'edit_item'           => __( 'Edit Ticket', 'rookie' ),
        'update_item'         => __( 'Update Ticket', 'rookie' ),
        'search_items'        => __( 'Search Ticket', 'rookie' ),
        'not_found'           => __( 'Not Found', 'rookie' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'rookie' ),
    );
	$args = array(
        'label'               => __( 'tickets', 'rookie' ),
        'description'         => __( 'Support tickets', 'rookie' ),
        'labels'              => $labels,
        'supports'            => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        'taxonomies'          => array(),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    );
    register_post_type('tickets', $args );

	/* Create the message post type
	*/
	$labels = array(
        'name'                => _x( 'Messages', 'Post Type General Name', 'rookie' ),
        'singular_name'       => _x( 'Message', 'Post Type Singular Name', 'rookie' ),
        'menu_name'           => __( 'Messages', 'rookie' ),
        'parent_item_colon'   => __( 'Parent Message', 'rookie' ),
        'all_items'           => __( 'All Messages', 'rookie' ),
        'view_item'           => __( 'View Message', 'rookie' ),
        'add_new_item'        => __( 'Add New Message', 'rookie' ),
        'add_new'             => __( 'Add New', 'rookie' ),
        'edit_item'           => __( 'Edit Message', 'rookie' ),
        'update_item'         => __( 'Update Message', 'rookie' ),
        'search_items'        => __( 'Search Message', 'rookie' ),
        'not_found'           => __( 'Not Found', 'rookie' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'rookie' ),
    );
	$args = array(
        'label'               => __( 'messages', 'rookie' ),
        'description'         => __( 'Support tickets', 'rookie' ),
        'labels'              => $labels,
        'supports'            => array('title', 'editor', 'excerpt', 'author', 'custom-fields', ),
        'taxonomies'          => array(),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    );
    register_post_type('messages', $args );
}

add_action('init', 'create_posttypes', 0);

/*
	function to get stat columns when player registers or game is changed
*/

function getcolumns($game) {
	$ret = array();
	if ($game==='apexlegends') {
		$ret=array(0, 'kills', 'timealive', 'revives', 0);
	} else if ($game==='callofduty') {
		$ret=array(0, 'kills', 'deaths', 'kd', 'hardpointtime', 0);
	} else if ($game==='csgo') {
		$ret=array(0, 'kills', 'deaths', 0);
	} else if ($game==='fortnite') {
		$ret=array(0, 'eliminations', 'placement', 0);
	} else if ($game==='leagueoflegends') {
		$ret=array(0, 'kills', 'deaths', 'assists', 0);
		//team: gold, towers, inhibitors, barons, dragons
	} else if ($game==='overwatchconsole'||$game==='overwatchpc') {
		$ret=array(0, 'eliminations', 'deaths', 'damage', 'timeplayed', 'healing', 0);
	} else if ($game==='r6pc'||$game==='r6playstation'||$game==='r6xbox') {
		$ret=array(0, 'score', 'kills', 'deaths', 'assists', 0);
	} else if ($game==='rocketleague') {
		$ret=array(0, 'goals', 'saves', 'assists', 'score', 'shots', 0);
	} else if ($game==='roguecompany') {
		$ret=array(0, 'eliminations', 'downs', 'revives', 'damage', 0);
	} else if ($game==='smite') {
		$ret=array(0, 'kills', 'deaths', 0);
	} else if ($game==='valorant') {
		$ret=array(0, 'kills', 'deaths', 'assists', 'averagecombatscore', 'firstblood', 'plants', 'defuses', 'kd', 0);
	} else if ($game==='warzone') {
		$ret=array(0, 'score', 'kills', 'damage', 'placement', 0);
	}
}

/*
	function to get commissioner name
*/

function get_commissioner($game) {
	$username = '';
	$args = array(
		'role' => 'commissioner'
	);
	$users = get_users($args);
	foreach ($users as $user) {
		if($game===get_user_meta($user->ID, 'mepr_game', true)) {
			$username = $user->user_login;
			break 1;
		}
	}
	return $username;
}

/*
	function to make the player reapply
*/

function force_reapply($user) {
	update_user_meta($user->ID, 'reapply', 'yes');
}

/*
	function to allow a player to reapply for a team
*/

function pl_reapply() {
	$ret = '';
	$user=wp_get_current_user();
	if (isset($_POST['team']) && isset($_POST['game'])) {
		update_user_meta($user->ID, 'mepr_team', $_POST['team']);
		update_user_meta($user->ID, 'mepr_game', $_POST['game']);
	}
	echo $ret;
	die();
}

add_action('wp_ajax_pl_reapply', 'pl_reapply');
add_action('wp_ajax_nopriv_pl_reapply', 'pl_reapply');

function convert($team) {
	if ($team==='allentown') {
		$team = 'Allentown Liberty';
	} else if ($team==='altoona') {
		$team = 'Altoona Steam';
	} else if ($team==='annandale') {
		$team = 'Annandale Aviators';
	} else if ($team==='erie') {
		$team = 'Erie Isles';
	} else if ($team==='frederick') {
		$team = 'Frederick Colonials';
	} else if ($team==='greensburg') {
		$team = 'Greensburg Guardians';
	} else if ($team==='harrisburg') {
		$team = 'Harrisburg Armada';
	} else if ($team==='indiana') {
		$team = 'Indiana Warhawks';
	} else if ($team==='johnstown') {
		$team = 'Johnstown Steel';
	} else if ($team==='montclair') {
		$team = 'Montclair Rams';
	} else if ($team==='scranton') {
		$team = 'Scranton Storm';
	} else if ($team==='utica') {
		$team = 'Utica Muskrats';
	} else if ($team==='youngstown') {
		$team = 'Youngstown Yetis';
	}
	return $team;
}

/*
	function to update user sp team/league info
*/

function update_pl_sp($remove, $user) {
	$playerpageid = get_user_meta($user->ID, 'pageid', true);
	if ($remove==='yes') {
		$team = get_user_meta($user->ID, 'mepr_team', true);
		if ($team==='allentown') {
			$team = 'Allentown Liberty';
		} else if ($team==='altoona') {
			$team = 'Altoona Steam';
		} else if ($team==='annandale') {
			$team = 'Annandale Aviators';
		} else if ($team==='erie') {
			$team = 'Erie Isles';
		} else if ($team==='frederick') {
			$team = 'Frederick Colonials';
		} else if ($team==='greensburg') {
			$team = 'Greensburg Guardians';
		} else if ($team==='harrisburg') {
			$team = 'Harrisburg Armada';
		} else if ($team==='indiana') {
			$team = 'Indiana Warhawks';
		} else if ($team==='johnstown') {
			$team = 'Johnstown Steel';
		} else if ($team==='montclair') {
			$team = 'Montclair Rams';
		} else if ($team==='scranton') {
			$team = 'Scranton Storm';
		} else if ($team==='utica') {
			$team = 'Utica Muskrats';
		} else if ($team==='youngstown') {
			$team = 'Youngstown Yetis';
		}

		$game = get_user_meta($user->ID, 'mepr_game', true);
		if ($game==='apexlegends') {
			$game = 'Apex Legends';
		} else if ($game==='callofduty') {
			$game = 'Call of Duty';
		} else if ($game==='csgo') {
			$game = 'CS:GO';
		} else if ($game==='fortnite') {
			$game = 'Fortnite';
		} else if ($game==='leagueoflegends') {
			$game = 'League of Legends';
		} else if ($game==='overwatchconsole') {
			$game = 'Overwatch (Console)';
		} else if ($game==='overwatchpc') {
			$game = 'Overwatch (PC)';
		} else if ($game==='r6pc') {
			$game = 'R6 (PC)';
		} else if ($game==='r6playstation') {
			$game = 'R6 (Playstation)';
		} else if ($game==='r6xbox') {
			$game = 'R6 (Xbox)';
		} else if ($game==='rocketleague') {
			$game = 'Rocket League';
		} else if ($game==='roguecompany') {
			$game = 'Rogue Company';
		} else if ($game==='smite') {
			$game = 'Smite';
		} else if ($game==='valorant') {
			$game = 'Valorant';
		} else if ($game==='warzone') {
			$game = 'Call of Duty: Warzone';
		}

		$div = get_user_meta($user->ID, 'mepr_division', true);
		if($div==='division1') {
			$div = 'Division 1';
		} else if ($div==='division2') {
			$div = 'Division 2';
		} else if ($div==='division3') {
			$div = 'Division 3';
		} else if ($div==='division4') {
			$div = 'Division 4';
		}

		$leaguetitle = $game . ' - ' . $div;
		$teamtitle = $team . ' - ' . $leaguetitle;
		$teampageid = get_page_by_title($teamtitle, OBJECT, 'sp_team')->ID;
		$leagueid = get_term_by('name', $leaguetitle, 'sp_league')->term_id;

		$new_assignments = $leagueid . '_' . $SEASONID . '_' . $teampageid;
		$new_team = $teampageid;
		$new_league = array(
			$leagueid => array(
				$SEASONID => $teampageid
			)
		);

		update_post_meta($playerpageid, 'sp_assignments', $new_assignments);
		update_post_meta($playerpageid, 'sp_current_team', $new_team);
		update_post_meta($playerpageid, 'sp_team', $new_team);
		update_post_meta($playerpageid, 'sp_leagues', $new_league);
		wp_set_object_terms($playerpageid, $leagueid, 'sp_league', false);
		wp_set_object_terms($playerpageid, $SEASONID, 'sp_season', false);
	} else {
		update_post_meta($playerpageid, 'sp_assignments', '');
		update_post_meta($playerpageid, 'sp_current_team', '');
		update_post_meta($playerpageid, 'sp_team', '');
		update_post_meta($playerpageid, 'sp_leagues', '');
		wp_set_object_terms($playerpageid, '', 'sp_league', false);
		wp_set_object_terms($playerpageid, '', 'sp_season', false);
	}
}

/*
	function to get gm
*/

function get_gm($team) {
	$username = '';
	$args = array(
		'role' => 'gm'
	);
	$users = get_users($args);
	foreach ($users as $user) {
		if($team===get_user_meta($user->ID, 'mepr_team', true)) {
			$username = $user->user_login;
			break 1;
		}
	}
	return $username;
}

/*
	function to create an event
*/

function create_event() {
	$ret = '';

	echo $ret;
	die();
}

add_action('wp_ajax_create_event', 'create_event');
add_action('wp_ajax_nopriv_create_event', 'create_event');

/*
	function for player to request a team (/teamrequest)
*/

function team_request() {
	$ret = '[Success] Your request was sent!';
	if (isset($_POST['team']) && isset($_POST['game'])) {
		$user=wp_get_current_user();
		if($user->ID) {
			$m = get_user_meta($user->ID, 'mepr_team', true);
			if($m==='freeagency') {
				update_user_meta($user->ID, 'mepr_team', $_POST['team']);
				update_user_meta($user->ID, 'mepr_game', $_POST['game']);
				update_user_meta($user->ID, 'teamapproved', 'no');
				system_message($user->ID, 'Your team request is currently being processed!');
			} else {
				$ret = '[Error] Your request cannot be processed at this time.';
			}
		}
	} else {
		$ret = '[Error] Some fields are missing.';
	}
	echo $ret;
	die();
}

add_action('wp_ajax_team_request', 'team_request');
add_action('wp_ajax_nopriv_team_request', 'team_request');

/*
	functions to get teams, games, and divs (schedule 'any')
*/

function _teams() {
	return array('Allentown Liberty', 'Altoona Steam', 'Annandale Aviators', 'Erie Isles', 'Frederick Colonials', 'Greensburg Guardians', 'Harrisburg Armada', 
	'Indiana Warhawks', 'Johnstown Steel', 'Montclair Rams', 'Scranton Storm','Utica Muskrats', 'Youngstown Yetis');
}

function _games() {
	return array('Apex Legends', 'Call of Duty', 'CS:GO', 'Fortnite', 'League of Legends', 'Overwatch (Console)', 'Overwatch (PC)', 'R6 (Playstation)', 'R6 (PC)', 'R6 (Xbox)', 
	'Rocket League', 'Rogue Company', 'Smite', 'Valorant', 'Warzone');
}

function _divs() {
	return array('Division 1', 'Division 2', 'Division 3', 'Division 4');
}

/*
	function to create a support ticket

	types: dispute, general

	status: pending, resolved

	meta: type, status, owner, description, responses(?)
*/

function submitticket() {
	$user = wp_get_current_user();
	$ret = '';
	if ($user->ID) {
		if (isset($_POST['ticketType']) && isset($_POST['description'])) {
			$type = $_POST['ticketType'];
			if ($_POST['ticketType']==='dispute') {
				$status = 'pending';
				$owner = $user->user_login;
				$description = $_POST['description'];
				$post_title = 'ticket' . number_of_tickets();

				$args = array(
					'post_title' => $post_title,
					'post_status' => 'private',
					'post_author' => '208183280',
					'post_type' => 'tickets',
					'post_content' => $description
				);
				$pageid = wp_insert_post($args, true);
				update_post_meta($pageid, 'type', $type);
				update_post_meta($pageid, 'status', $status);
				update_post_meta($pageid, 'owner', $owner);
				update_post_meta($pageid, 'game', $_POST['game']);
				update_post_meta($pageid, 'response', '');
				$user_tickets = get_user_meta($user->ID, 'tickets', true);
				$user_tickets[count($user_tickets)] = $pageid;
				update_user_meta($user->ID, 'tickets', $user_tickets);

				$details = array(
					'type' => $type,
					'description' => $description
				);
				//system_message(get_commissioner(), $details);
				//email commissioners!!!

			} else if ($_POST['ticketType']==='general') {
	
			} else if ($_POST['ticketType']==='') {
	
			} else {
				$ret = '[Error] Invalid ticket type';
			}
		} else {
			$ret = '[Error] Fields are missing.';
		}
	} else {
		$ret = '[Error] You must be signed in!';
	}
	echo $ret;

	die();
}

add_action('wp_ajax_submitticket', 'submitticket');
add_action('wp_ajax_nopriv_submitticket', 'submitticket');

/*
	function to update messages (i.e. make them all seen when page loads)
*/

function update_messages() {
	/*
	$code = '[Success] 000';
	$to = wp_get_current_user()->ID;
	global $wpdb;
	$wpdb->query("UPDATE messages SET seen = '0' WHERE id LIKE '%$to%';");
	echo $code;
	*/
	die();
}

add_action('wp_ajax_update_messages', 'update_messages');
add_action('wp_ajax_nopriv_update_messages', 'update_messages');

/*
	function to check for new messages
*/

function refresh_messages($op) {
	global $wpdb;
	$to = wp_get_current_user()->ID;
	if ($op===0) {
		$wpdb->get_results("SELECT * FROM messages WHERE id LIKE '%$to%' AND seen = '0';", ARRAY_A);
		$rows = $wpdb->num_rows;
		if ($rows===null) {
			$rows=0;
		}
		return $rows;
	} else {
		return $wpdb->get_results("SELECT * FROM messages WHERE id LIKE '%$to%' AND seen = '0';", ARRAY_A);
	}
}

/*
	function to get messages
*/

function get_messages() {
	$to = wp_get_current_user()->ID;
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM messages WHERE id LIKE '%$to%';", ARRAY_A);
	if ($wpdb->num_rows > 0) {
		return $results;
	}
	return false;
}

/*
	function to send a message to user from system
*/

function system_message($to, $msg) {
	_send_message($to, '208183339', $msg);
}

/*
	send message without echoing anything
*/


function _send_message($to, $from, $msg) {
	global $wpdb;
	$id = "$to:$from";
	$wpdb->insert('messages', array(
		'id' => $id,
		'idfrom' => $from, 
		'msg' => $msg,
		'date' => date("Y-m-d h:i:s"),
		'seen' => 0));
}

/*
	send a message
*/

function send_message() {
	$ret = 'Message sent successfully.';
	if (isset($_POST['to']) && isset($_POST['from']) && isset($_POST['msg'])) {
		$touser = get_user_by('login', $_POST['to']);
		if ($touser->ID) {
			_send_message($touser->ID, $_POST['from'], $_POST['msg']);
		} else {
			$ret = '[Error] User does not exist!';
		}
		
	} else {
		$ret = 'Some fields are missing.';
	}
	echo $ret;
	die();
}

add_action('wp_ajax_send_message', 'send_message');
add_action('wp_ajax_nopriv_send_message', 'send_message');

/*
	delete msg no echo
*/

function _delete_message($id) {
	global $wpdb;
	$wpdb->query($wpdb->prepare("DELETE FROM messages WHERE identifier = '" . $id . "'"));
}

/*
	function to delete message
*/

function delete_message() {
	$ret = '[Success] Message deleted!';
	if (isset($_POST['id'])) {
		_delete_message($_POST['id']);
	} else {
		$ret = '[Error] No message was selected.';
	}
	echo $ret;
	die();
}

add_action('wp_ajax_delete_message', 'delete_message');
add_action('wp_ajax_nopriv_delete_message', 'delete_message');

/*
	helper function to get # of tickets
*/

function number_of_tickets() {
	$args = array(
		'post_type' => 'tickets'
	);
	$query = new WP_Query($args);
	$number = $query->found_posts;
	wp_reset_postdata();
	return $number;
}

/*
	function to get a user's tickets
*/

function get_tickets() {
	
	die();
}

/*
	Number to month because im lazy
*/

function get_month($input) {

	$output = 'January';
	if ($input==='2') {
		$output = 'February';
	} else if ($input==='3') {
		$output = 'March';
	} else if ($input==='4') {
		$output = 'April';
	} else if ($input==='5') {
		$output = 'May';
	} else if ($input==='6') {
		$output = 'June';
	} else if ($input==='7') {
		$output = 'July';
	} else if ($input==='8') {
		$output = 'August';
	} else if ($input==='9') {
		$output = 'September';
	} else if ($input==='10') {
		$output = 'October';
	} else if ($input==='11') {
		$output = 'November';
	} else if ($input==='12') {
		$output = 'December';
	}
	return $output;
}

/*

* Help convert number day to the number + suffix i.e. 1 -> 1st etc.

*/

function get_day($day) {
	$last = substr($day, strlen($day) - 1);
	if ($last === '1') {
		return $day . 'st';
	} else if ($last === '2') {
		return $day . 'nd';
	} else if ($last==='3') {
		return $day . 'rd';
	} else {
		return $day . 'th';
	}
}

/*
	function to remove the post thumbnail (aka user pfp)
*/

function remove_pfp() {
	$user = wp_get_current_user();
	delete_post_thumbnail(get_user_meta($user->ID, 'pageid', true));
	echo 'Photo removed!';
	die();
}

add_action('wp_ajax_remove_pfp', 'remove_pfp');
add_action('wp_ajax_nopriv_remove_pfp', 'remove_pfp');

/*
* Function to look up the user on admin page
*/

function userlookup() {
	$ret = array(
		'info' => ''
	);
	if (isset($_POST['lookupuser'])) {
		$user = get_user_by('login', $_POST['lookupuser']);
		if ($user->ID) {

			//check if user is banned

			$banned = get_user_option('tecbanned', $user->ID, false);
			$ret['banned'] = $banned;

			//get stats

			$pl_id = get_user_meta($user->ID, 'pageid', true);
			$player = new SP_Player($pl_id);
			$stats = $player->statistics();
			if (count($stats) > 0) {
				$values = array();
				$lnfo = explode('_', get_post_meta($pl_id, 'sp_assignments', true), 3);
				$all = $stats[$lnfo[0]][$lnfo[1]];
				$cols = $stats[$lnfo[0]][0];
				unset($cols['name']);
				foreach ($cols as $v) {
					$values[strtolower($v)] = $all[strtolower($v)];
				}
				$ret['stats'] = $stats;
			} else {
				$ret['stats'] = 'No stats available!';
			}

			//get membership level

			$member = new MeprUser();
			$member->ID = $user->ID;
			$m_result = $member->active_product_subscriptions('ids');
			if(!empty($m_result)) {
				if (in_array('1888', $m_result) || in_array('1887', $m_result)) {
					if (in_array('1888', $m_result)) {
						$ret['membership'] = 'Pro';
					} else {
						$ret['membership'] = 'Plus';
					}
				} else {
					$ret['membership'] = 'None';
				}
			} else {
				$ret['membership'] = 'None';
			}

		} else {
			$ret['info'] = '[Error]: User not found!';
		}
	}
	echo json_encode($ret);
	die();
}

add_action('wp_ajax_userlookup', 'userlookup');
add_action('wp_ajax_nopriv_userlookup', 'userlookup');

/*
	function to create an event
*/

function tecevent() {

	die();
}

add_action('wp_ajax_tecevent', 'tecevent');
add_action('wp_ajax_nopriv_tecevent', 'tecevent');

/*
	function to move a player (gms+admins)
*/

function moveplayer() {
	$ret = 'null';
	$user = wp_get_current_user();
	$team = get_user_meta($user->ID, 'mepr_team', true);

	if ($team==='allentown') {
		$team = 'Allentown Liberty';
	} else if ($team==='altoona') {
		$team = 'Altoona Steam';
	} else if ($team==='annandale') {
		$team = 'Annandale Aviators';
	} else if ($team==='erie') {
		$team = 'Erie Isles';
	} else if ($team==='frederick') {
		$team = 'Frederick Colonials';
	} else if ($team==='greensburg') {
		$team = 'Greensburg Guardians';
	} else if ($team==='harrisburg') {
		$team = 'Harrisburg Armada';
	} else if ($team==='indiana') {
		$team = 'Indiana Warhawks';
	} else if ($team==='johnstown') {
		$team = 'Johnstown';
	} else if ($team==='montclair') {
		$team = 'Montclair Rams';
	} else if ($team==='scranton') {
		$team = 'Scranton Storm';
	} else if ($team==='utica') {
		$team = 'Utica Muskrats';
	} else if ($team==='youngstown') {
		$team = 'Youngstown Yetis';
	}

	if ($user->ID && (in_array('gm', $user->roles) || in_array('agm', $user->roles) || in_array('administrator', $user->roles))) {
		if (isset($_POST['name']) && isset($_POST['newgame']) && isset($_POST['newdiv'])) {
			$newuser = get_user_by('login', $_POST['name']);
			if ($newuser->ID) {

				$SEASONID = 1360; //season 5
				$pageid = get_user_meta($newuser->ID, 'pageid', true);

				$status = get_user_meta($newuser->ID, 'teamapproved', true);
				if($status==='no') {
					echo "[Error] User hasn't been approved for a team yet!";
					die();
				}

				//update memberpress user info

				update_user_meta($newuser->ID, 'mepr_game', $_POST['newgame']);
				update_user_meta($newuser->ID, 'mepr_division', $_POST['newdiv']);

				$leaguetitle = $_POST['newgameproper'] . ' - ' . $_POST['newdivproper'];
				$teamtitle = $team . ' - ' . $leaguetitle;
				$teampageid = get_page_by_title($teamtitle, OBJECT, 'sp_team')->ID;
				$leagueid = get_term_by('name', $leaguetitle, 'sp_league')->term_id;

				$new_assignments = $leagueid . '_' . $SEASINID . '_' . $teampageid;
				$new_team = $teampageid;
				$new_league = array(
					$leagueid => array(
						$SEASONID => $teampageid
					)
				);

				//update sportspress player page info 
				//TODO: figure out how to fix stats
				wp_set_object_terms($pageid, $leagueid, 'sp_league', false);
				wp_set_object_terms($pageid, $SEASONID, 'sp_season', false);
				$a=update_post_meta($pageid, 'sp_assignments', $new_assignments);
				$b=update_post_meta($pageid, 'sp_current_team', $new_team);
				$c=update_post_meta($pageid, 'sp_team', $new_team);
				$d=update_post_meta($pageid, 'sp_leagues', $new_league);
				$ret = '[Success] Player moved successfully.';
			} else {
				$ret = '[Error] Could not find user!';
			}
		} else {
			$ret = '[Error] Fields missing!';
		}
	} else {
		$ret = '[Error] Invalid permissions.';
	}

	echo $ret;
	die();
}

add_action('wp_ajax_moveplayer', 'moveplayer');
add_action('wp_ajax_nopriv_moveplayer', 'moveplayer');

/*
	function to set user meta from admin page
*/

function setmetauser() {
	$ret = 'There was an error setting that user role.';
	if (isset($_POST['user']) && isset($_POST['key']) && isset($_POST['value'])) {
		if (in_array('administrator', wp_get_current_user()->roles)) {
			$user = get_user_by('login', $_POST['user']);
			if ($user->ID) {
				$hasmeta = get_user_meta($user->ID, $_POST['key'], false);
				if ($hasmeta) {
					update_user_meta($user->ID, $_POST['key'], $_POST['value']);
					$ret = '[Success] Meta updated successfully!';
				} else {
					add_user_meta($user->ID, $_POST['key'], $_POST['value']);
					$ret = '[Success] Meta added successfully!';
				}
			} else {
				$ret = '[Error] User does not exist!';
			}
		}else {
			$ret = '[Error] Only administrators can set user meta!';
		}
	} else {
		$ret = '[Error] There were empty fields!';
	}
	echo $ret;
	die();
}

add_action('wp_ajax_setmetauser', 'setmetauser');
add_action('wp_ajax_nopriv_setmetauser', 'setmetauser');

/*
	function to update team pages for gms
*/

function tecgetid() {
	$user = wp_get_current_user();
	$team = get_user_meta($user->ID, 'mepr_team', true);
	
	if (in_array('administrator', $user->roles) && isset($_GET['team'])) {
		$team = $_GET['team'];
	}
	
	$returnid = 34;
	if ($team==='allentown') {
		$returnid = 34;
	} else if ($team==='altoona') {
		$returnid = 62;			
	} else if ($team==='annandale') {
		$returnid = 63;
	} else if ($team==='erie') {
		$returnid = 64;
	} else if ($team==='frederick') {
		$returnid = 65;
	} else if ($team==='greensburg') {
		$returnid = 66;
	} else if ($team==='harrisburg') {
		$returnid = 67;
	} else if ($team==='indiana') {
		$returnid = 68;
	} else if ($team==='johnstown') {
		$returnid = 69;
	} else if ($team==='montclair') {
		$returnid = 70;
	} else if ($team==='scranton') {
		$returnid = 71;
	} else if ($team==='utica') {
		$returnid = 72;
	} else if ($team==='youngstown') {
		$returnid = 73;
	}
	return $returnid;
}

/*
	Funciton to update a player's profile page
*/

function updateplayerpage() {
	$ret = '';
	$user = wp_get_current_user();
	if ($user->ID) {
		$font = $_POST['font'];
		$bgcolor = $_POST['bgcolor'];
		$textcolor = $_POST['textcolor'];
		$headercolor = $_POST['headercolor'];
		$menucolor = $_POST['menucolor'];
		$linkcolor = $_POST['linkcolor'];
		$linkhovercolor = $_POST['linkhovercolor'];
		$twitchlink='';
		if (isset($_POST['twitchusername']) && !empty($_POST['twitchusername'])) {
			$twitchlink = '<iframe src="https://player.twitch.tv/?channel=' . $_POST['twitchusername'] . '&amp;parent=tecleagues.com" width="100%" height="500" frameborder="0" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';

		}
		$postid = get_user_meta($user->ID, 'pageid', true);
		if ($postid) {
			wp_update_post(array(
				'ID' => $postid,
				'post_content' => $_POST['pagecontent']
			));
			$good = array(
				'font' => $font,
				'bgcolor' => $bgcolor,
				'textcolor' => $textcolor,
				'headercolor' => $headercolor,
				'menucolor' => $menucolor,
				'linkcolor' => $linkcolor,
				'linkhovercolor' => $linkhovercolor,
				'twitch' => $twitchlink
			);
			$success = update_post_meta($postid, 'teccustom', $good);
			$ret = '[Success] Page updated successfully!';
		} else {
			$ret = '[Error] There was an error processing your request.';
		}
	}
	echo $ret;
	die();
}

add_action('wp_ajax_updateplayerpage', 'updateplayerpage');
add_action('wp_ajax_nopriv_updateplayerpage', 'updateplayerpage');

/*
	Function to update gm's team page(s)
*/

function updateteampage() {
	$ret = '';
	$user = wp_get_current_user();
	
	if ($user->ID && (in_array('administrator', $user->roles) || in_array('gm', $user->roles))) {
		$font = $_POST['font'];
		$bgcolor = $_POST['bgcolor'];
		$textcolor = $_POST['textcolor'];
		$headercolor = $_POST['headercolor'];
		$menucolor = $_POST['menucolor'];
		$linkcolor = $_POST['linkcolor'];
		$linkhovercolor = $_POST['linkhovercolor'];
		$pid = tecgetid();
		if (isset($_POST['teampageid']) && in_array('administrator', $user->roles)) {
			$pid = $_POST['teampageid'];
		}
		if (isset($pid)) {
			wp_update_post(array(
				'ID' => $pid,
				'post_content' => $_POST['pagecontent']
			));
			$good = array(
				'font' => $font,
				'bgcolor' => $bgcolor,
				'textcolor' => $textcolor,
				'headercolor' => $headercolor,
				'menucolor' => $menucolor,
				'linkcolor' => $linkcolor,
				'linkhovercolor' => $linkhovercolor
			);
			$success = update_post_meta($pid, 'teccustom', $good);
			$ret = '[Success] Page updated successfully!';
		} else {
			$ret = '[Error] There was an error processing your request.';
		}
	} else {
		$ret = '[Error] Only admins & GMs can edit team pages!';
	}
	echo $ret;
	die();
}

add_action('wp_ajax_updateteampage', 'updateteampage');
add_action('wp_ajax_nopriv_updateteampage', 'updateteampage');

/*

* Function to check if the user is on their own profile page, to see if edit button should appear (Deprecated)
* Send: theurl - current page url
* Return: Verification/html

*/

function tecprofile() {
	$needback = '';
	$result = array(
		'verify' => $needback
	);
	
	if (isset($_POST["myurl"]) && isset($_POST["urlsuffix"])) {
		$user = wp_get_current_user();
		if ($user->user_login===$_POST['urlsuffix']) {
			$needback ='<center><button id="btnedit">Edit</button></center>';
			$result['href']='https://tecleagues.com/editprofile/';
		}
		$result['verify'] = $needback;
	}

	echo json_encode($result);
	die();
}

add_action('wp_ajax_tecprofile', 'tecprofile');
add_action('wp_ajax_nopriv_tecprofile', 'tecprofile');

function banuser() {
	$ser = wp_get_current_user();
	if ($ser->ID && in_array('administrator',$ser->roles)) {
		if (isset($_POST['userban']) && isset($_POST['ban'])) {
			$user = get_user_by('login', $_POST['userban']);
			if ($user->ID) {
				if ($_POST['ban']==='ban') {
					if (get_user_option('tecbanned', $user->ID, false)) {
						update_user_option('tecbanned', $user->ID, true, false);
					} else {
						echo '[Error] User is already banned.';
					}
				} else if ($_POST['ban']==='unban') {
					if (get_user_option('tecbanned', $user->ID, false)) {
						update_user_option('tecbanned', $user->ID, false, false);
					} else {
						echo '[Error] User is not currently banned.';
					}
				} else {
					echo '[Error] Invalid parameters.';
				}
			} else {
				echo '[Error] User does not exist!';
			}
		} else {
			echo '[Error] Empty username.';
		}
	} else {
		echo '[Error] Only administrators can ban users.';
	}
 	die();
}

add_action('wp_ajax_banuser', 'banuser');
add_action('wp_ajax_nopriv_banuser', 'banuser');

/*
* Function to get an array of all pro members.
*/

function getpromembers() {
	$ret = array();
	$users = get_users( array( 'fields' => array( 'ID','user_login' ) ) );
	$count = 0;
	foreach($users as $user){
        $member = new MeprUser();
		$member->ID = $user->ID;
		$m_result = $member->active_product_subscriptions('ids');
		if (in_array('1888', $m_result)) {
			$meta = get_user_meta($user->ID);
			$data = array(
				'username' => $user->user_login,
				'fname' => $meta['first_name'][0],
				'lname' => $meta['last_name'][0],
				'email' => $meta['mepr_email'][0],
				'team' => $meta['mepr_team'][0],
				'disc' => $meta['mepr_discord_name'][0],
				'ign' => $meta['mepr_ign_in_game_name'][0],
				'dob' => $meta['mepr_date_of_birth'][0],
				'country' => $meta['mepr-address-country'][0],
				'adr' => $meta['mepr-address-one'][0] . '; ' . $meta['mepr-address-two'][0],
				'city' => $meta['mepr-address-city'][0],
				'state' => $meta['mepr-address-state'][0],
				'zip' => $meta['mepr-address-zip'][0],
				'phone' => $meta['mepr_phone_number'][0],
				'csize' => $meta['mepr_clothing_size'][0],
				'ssize' => $meta['mepr_sock_size'][0]
			);

			$ret[$count] = $data;
			$count++;
		}
    }
	echo json_encode($ret);
	die();
}

add_action('wp_ajax_getpromembers', 'getpromembers');
add_action('wp_ajax_nopriv_getpromembers', 'getpromembers');


/*
	function to set a users role (admin only
*/
function setroleuser() {
	$ret = 'There was an error setting that user role.';
	if (isset($_POST['user']) && isset($_POST['role'])) {
		if (in_array('administrator', wp_get_current_user()->roles)) {
			$user = get_user_by('login', $_POST['user']);
			if ($user->ID) {
				if (in_array('gm', $user->roles)) {
					$ret = '[Error] User already has that role!';
				} else {
					try {
						$user->add_role($_POST['role']);
						$ret='[Success] Role has been added!';
					} catch (Exception $ex) {
						$ret = '[Error] Could not add role.';
					}
				}
			} else {
				$ret = '[Error] User does not exist!';
			}
		}else {
			$ret = '[Error] Only administrators can set roles!';
		}
	} else {
		$ret = '[Error] There were empty fields!';
	}
	echo $ret;
	die();
}

add_action('wp_ajax_setroleuser', 'setroleuser');
add_action('wp_ajax_nopriv_setroleuser', 'setroleuser');


/*function to report a bug

*/

function reportbug() {
	$response = '[Success] Thank you for submitting! We will look into this issue ASAP.';
	if (isset($_POST['pagename']) && isset($_POST['content'])) {
		$url = 'Not provided';
		if (isset($_POST['pageurl']) && !empty($_POST['pageurl'])) {
			$url = $_POST['pageurl'];
		}
		$headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = '<p><b>User</b>: ' . wp_get_current_user()->user_login . "</p>";
		$message .= '<p><b>Page</b>: ' . $_POST['pagename'] . "</p>";
		$message .= '<p><b>URL</b>: ' . $_POST['pageurl'] . "</p>";
		$message .= '<p><b>Content</b>: ' . $_POST['content'] . '</p>';
		$success = wp_mail('ryan@theesportcompany.com', '[TECLeagues] Bug reported', $message, $headers);
		if ($success===false) {
			$response = "[Error] There was an error with your request! Please try again later.";
		}
	} else {
		$response = '[Error] Some fields were empty!';
	}
	echo $response;
	die();
}

add_action('wp_ajax_reportbug', 'reportbug');
add_action('wp_ajax_nopriv_reportbug', 'reportbug');

/* Function to register a user (Deprecated)

*/

function tecregister() {
    global $wpdb;
    $ret = array(
        'verify' => 'error',
        'error' => ''
    );
    if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['cpass'])) {
        $tec_user = $wpdb->escape(trim($_POST['username']));
        $tec_email = $wpdb->escape(trim($_POST['email']));
        $tec_pass = $wpdb->escape(trim($_POST['pass']));
        $tec_cpass = $wpdb->escape(trim($_POST['cpass']));
        if($tec_pass===$tec_cpass) {
            if (preg_match('/^[a-z0-9]{2,}[a-z0-9_]+$/i', $tec_user)) {
                if (!email_exists($tec_email)) {
                    if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $tec_email) ) {
                        if (!username_exists($tec_user)) {
                            $args = array(
                                'user_login' => $tec_user,
                                'user_pass' => $tec_pass,
                                'user_email' => $tec_email,
                                'display_name' => $tec_user,
                                'role' => 'tecplayer'
                            );
                            
                            $status = wp_insert_user($args);
                            if (is_wp_error($status)) {
                                $ret['error'] = 'There was an error creating your account. Please try again.';
                            } else {
                                do_action('user_register', $status);
                                $from = get_option('admin_email');
                                $headers = 'From: '. $from . "\r\n";
                                $subject = "Registration complete!";
                                $message = "Your TECLeagues account has been created.\nYour login details:\nUsername: " . $_POST['username'] . "\nPassword: " . $_POST['pass'];
                                wp_mail($_POST['email'], $subject, $message, $headers);
                                $creds = array();
                                $creds['user_login'] = $tec_user;
                                $creds['user_password'] = $tec_pass;
                                $creds['remember'] = true;
                                $user = wp_signon($creds, false);
                                if (!is_wp_error($user)) {

									$ret['verify'] = 'https://tecleagues.com/player/' . $tec_user;
                                } else {
                                    $ret['error'] = 'There was an error signing you in: ' . print_r($user->errors, true);
                                }
                            }
                        } else {
                            $ret['error'] = 'An account with that username already exists!';
                        }
                    } else {
                        $ret['error'] = 'Email is invalid.';
                    }
                } else {
                    $ret['error'] = 'An account with that email already exists!';
                }
            } else {
                $ret['error'] = 'Username may only contain letters (a-z), numbers(0-9), and underscore (_)';
            }
        } else {
            $ret['error'] = 'Passwords do not match!';
        }
    } else {
        $ret['error'] = 'Not all fields were entered!';
    }

    echo json_encode($ret);
	die();
}

add_action('wp_ajax_tecregister', 'tecregister');
add_action('wp_ajax_nopriv_tecregister', 'tecregister');

/*

* Function to get all events for schedule
* Send: b_day, b_month, b_year, a_day, a_month, a_year - a_ = after date, b_ = before date
* Return: Array of event posts that occur within the given timeframe

*/

function getschedule() {
	if (isset($_POST['a_day'])&&isset($_POST['a_month'])&&isset($_POST['a_year'])&&isset($_POST['b_day'])&&isset($_POST['b_month'])&&isset($_POST['b_year'])
	&&isset($_POST['team'])&&isset($_POST['div'])&&isset($_POST['game']))
	{
		$returnval = array('ret' => array(), 'info' => 'No events found!');
		$array=[];
		$i=0;
		$query = new WP_Query(array ( 
		'post_type' => 'sp_event',
		'posts_per_page' => '-1',
		'post_status' => 'future,publish',
		'date_query' => array(array(
			'before' => get_month($_POST['b_month']) . ' ' . get_day($_POST['b_day']) . ', ' . $_POST['b_year'],
			'after' => get_month($_POST['a_month']) . ' ' . get_day($_POST['a_day']) . ', ' . $_POST['a_year']),
			'inclusive' => true,
			)
			)
			);


		if ($query->have_posts()) 
		{
			while($query->have_posts()) 
			{
				$returnval['info']==='atleast 1';
				$query->the_post();
				$pagetitle=strtolower($query->posts[$i]->post_title);
				$date = $query->posts[$i]->post_date;
				$time = preg_split('# #', $date)[1];
				$date = preg_split("# #", $date)[0];

				if (strpos($pagetitle, '|') !== false) {
					if (strpos($pagetitle, $_POST['team']) !== false || $_POST['team']==='any') {// && strpos($pagetitle, $_POST['game']) !== false && strpos($pagetitle, $_POST['div']) !== false)
						if (strpos($pagetitle, $_POST['game']) !== false || $_POST['game']==='any') {
							if (strpos($pagetitle, $_POST['div']) !== false || $_POST['div']==='any') {
								$pagename = $query->posts[$i]->post_name;
								$pagelink = 'https://tecleagues.com/event/' . $pagename;
								$pageid =  $query->posts[$i]->ID;
								$results='';
								$boxscore='';
								if (date('Y-m-d') > $date) {
									$results = do_shortcode('[event_results id="' . $pageid . '" align="none"]');
									$boxscore = do_shortcode('[event_performance id="' . $pageid . '" align="none"]');
								}
								$push = array('name' => $pagename, 'link' => $pagelink, 'id' => $pageid, 'title' => $pagetitle, 'date' => $date, 'time' => $time, 'results' => $results, 
								'boxscore' => $boxscore);
								$array[$i] = $push;
								$i++;
							}
						}
					}
				}
				
			}
			if (!empty($array)){
				$returnval['ret'] = $array;
				$returnval['info'] = '';
			}
		}
		echo json_encode($returnval);
    	wp_reset_postdata();
	} else {
		echo json_encode(array('info' => '[Error] Fields are missing!'));
	}
	die();
}

add_action('wp_ajax_getschedule', 'getschedule');
add_action('wp_ajax_nopriv_getschedule', 'getschedule');

/*
	helper function for schedule
*/

function _verify($query, $postvalue, $isany) {
	if ($isany===false){
		if (strpos($query, $postvalue) !== false) {
			return true;
		} else {
			return false;
		}
	} else if ($isany===true) {
		return 'any';
	}
	return false;
}

/*

* Function to retrieve player stats
* Send: game
* Return: Array of player objects with their stats

*/

/*

function getstats() { //DEPRECATED (cleaned up below, this is just incase the other method has a bug)

	//$player = new SP_Player(1594);

	//print_r($player->statistics());
	if (isset($_POST['game']) & isset($_POST['div'])) {
		$target_g = $_POST['game'];
		$target_d = $_POST['div'];
		$target_t = 'any';
		if (isset($_POST['team'])) {
			$target_t = $_POST['team'];
		}
		$target_t = 'any';
		

		$query = new WP_Query(array(
			'post_type' => 'sp_player',
			'posts_per_page' => '-1',
			'tax_query' => array (array(
				'taxonomy' => 'sp_league',
				'field' => 'name',
				'terms' => $target_g . ' - ' . $target_d
			))
			));


		$c_stats = array();

		if ($query->have_posts()) {
			$i = 0;
			$thecount=0;
			while ($query->have_posts()) {
				$query->the_post();
				$pl_id = $query->posts[$i]->ID;
				$player_name = $query->posts[$i]->post_title;
				$player = new SP_Player($pl_id);
				$a = $player->statistics();
				$league = '';
				if (count($a) > 0) {
					foreach ($a as $b) {
						$counter=0;
						$temp_stats1 = array();
						$temp_stats2 = array();
						foreach ($b as $c) {
							$counter++;
							if ($counter===1) {
								$temp_stats1 = $c;
							}
							if ($c['team']!=='-'&&strtolower($c['team'])!=='team') {
								
								$league = strtolower($c['team']);
							}
							
							unset($temp_stats1['name']);
							if (($target_t==='any' ? true : strpos($league, $target_t)) && strpos($league, $target_g) !== false && strpos($league, $target_d) !== false) {
								if($counter===3) {
									$temp_stats2 = $c;
    								$temppush = array('name' => $player_name);
    								
    								foreach ($temp_stats2 as $key_2 => $value_2) {
    									foreach ($temp_stats1 as $key_1 => $value_1) {
    									    if (strtolower(trim($key_1))===strtolower(trim($key_2))) {
    									        //echo $player_name . ' ' . $key_1 . ' ' . $value_1 . ' ----- ';
    									        $temppush[$key_1] = $value_1;
    									        //array_push($c_stats[$playername], array($key_1 => $value_1));
    									        //$c_stats[$player_name]["'" . $key_1 . "'"]===$value_1;
    									    }
    									}
    								}
    								$c_stats[$thecount] = $temppush;
									$thecount++;
								}
								
							} else {
								continue;
							}
						}
					}
				}
				$i++;
			}
			
		}

		if (!empty($c_stats)) {
			echo json_encode($c_stats);
		} else {
			echo json_encode(array('error' => '[Error] No players exist with those parameters.', 'c' => count($c_stats)));
		}
		wp_reset_postdata();
	}
	
	die();
}

*/

function getstats() {

	if (isset($_POST['game']) & isset($_POST['div'])) {
		$target_g = $_POST['game'];
		$target_d = $_POST['div'];
		$target_t = 'any';
		if (isset($_POST['team'])) {
			$target_t = $_POST['team'];
		}
		$target_t = 'any';
		$query = new WP_Query(array(
			'post_type' => 'sp_player',
			'posts_per_page' => '-1',
			'tax_query' => array (array(
				'taxonomy' => 'sp_league',
				'field' => 'name',
				'terms' => $target_g . ' - ' . $target_d
			))
			));
		$c_stats = array();

		if ($query->have_posts()) {
			$i = 0;
			$thecount=0;
			while ($query->have_posts()) {
				$query->the_post();
				$pl_id = $query->posts[$i]->ID;
				$player_name = $query->posts[$i]->post_title;
				$player = new SP_Player($pl_id);
				$stats = $player->statistics();
				$league = '';
				if (count($stats) > 0) {
					$values = array('name' => $player_name);
					$lnfo = explode('_', get_post_meta($pl_id, 'sp_assignments', true), 3);
					$all = $stats[$lnfo[0]][$lnfo[1]];
					$cols = $stats[$lnfo[0]][0];
					unset($cols['name']);
					foreach ($cols as $v) {
						$values[strtolower($v)] = $all[strtolower($v)];
					}
					$c_stats[$thecount] = $values;
					$thecount++;
				}
				$i++;
			}
		}
		if (!empty($c_stats)) {
			echo json_encode($c_stats);
		} else {
			echo json_encode(array('error' => '[Error] No players exist with those parameters.', 'c' => count($c_stats)));
		}
		wp_reset_postdata();
	}
	
	die();
}

add_action('wp_ajax_getstats', 'getstats');
add_action('wp_ajax_nopriv_getstats', 'getstats');

/*

* Function to get the league table for specific game + div
* Send: game, div
* Return: Executed shortcode for the league table

*/

function getstandings() {
	die();
}

add_action('wp_ajax_getstandings', 'getstandings');
add_action('wp_ajax_nopriv_getstandings', 'getstandings');

/*
	helper functions for 'inbox.php'
*/
function tec_get_user() {
	return wp_get_current_user();
}


?>