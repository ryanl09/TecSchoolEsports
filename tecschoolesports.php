<?php

/**
* Plugin Name: TEC School Esports
* Plugin URI: https://www.theesportcompany.com
* Description: do a lot of stuff
* Version: 0.1
* Author: Ryan Leitenberger
**/

add_action('init', 'tecschoolesports');

/**
 * Starting function for the plugin. Displays the menu on every page and determines the role of the user for js
 */

function tecschoolesports() {
	wp_register_script('main', plugin_dir_url(__FILE__) . 'js/main.js');
	$roles = wp_get_current_user()->roles;
	$maxrole = '';
	if (in_array('student', $roles)) {
		$maxrole='student';
	}
	if (in_array('team_manager', $roles)) {
		$maxrole='tm';
	}
	if (in_array('administrator', $roles)) {
		$maxrole='admin';
	}
	wp_localize_script('main', 'info', array('loggedin' => is_user_logged_in(), 'role' => $maxrole));
	wp_enqueue_script('main');
}

add_action('wp_enqueue_scripts', 'tecinit');

/**
 * Main conditional function for the plugin. Determines what page the user is on to call a specific script
 */

function tecinit() {
    $adm = 'admin-ajax.php';
	$user = wp_get_current_user();
	$li = is_user_logged_in();

    if ( ! is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
		$new = refresh_messages(0);

		/*
		wp_register_script('fixmenuicon', plugin_dir_url(__FILE__) . 'js/fixmenuicon.js');
		wp_localize_script('fixmenuicon', 'thisuser', array('name' => wp_get_current_user()->user_login,
	'msg' => $new,'hideteam'=>$hideteam));
		wp_enqueue_script('fixmenuicon');*/

		$post_title=strtolower(trim(get_the_title()));

		if (is_front_page()) {
			wp_register_script('homepage', plugin_dir_url(__FILE__) . 'js/homepage.js', array('jquery'));
			wp_localize_script('homepage', 'events', get_homepage_events());
			wp_enqueue_script('homepage');
		}

		if ((strpos($post_title, 'register')!==false || strpos($post_title, 'registration')!==false) && $li) { //if register page & user is logged in
			//wp_redirect('https://tecschoolesports.com/account');
		}


        if($post_title==='schedule') {
            wp_register_script('tecschedule', plugin_dir_url(__FILE__ ) . 'js/schedule.js', array('jquery'));
			wp_localize_script('tecschedule', 'myAjax', array( 'ajaxurl' => admin_url($adm)));
			wp_enqueue_script('tecschedule');
        } else if ($post_title==='student registration') {
			wp_register_script('registerstudent', plugin_dir_url(__FILE__ ) . 'js/registerstudent.js', array('jquery'));
			$code = isset($_GET['schoolcode']) ? $_GET['schoolcode'] : '';
			$sug = '';
			if($code) {
				global $wpdb;
				$sql = $wpdb->prepare("SELECT teamid FROM hs_staff WHERE code = '$code';");
				$s = $wpdb->get_results($sql, ARRAY_A);
				if($wpdb->num_rows > 0) {
					$sug = $s[0]['teamid'];
				} else {
					$sug=-1;
				}
			}
			$nfo = array(
				'ajaxurl' => admin_url($adm),
				'schoolcode' => $code,
				'sug' => get_the_title($sug)
			);
			wp_localize_script('registerstudent', 'inf', $nfo);
			wp_enqueue_script('registerstudent');
		} else if ($post_title==='team manager registration') {
            wp_register_script('registertm', plugin_dir_url(__FILE__ ) . 'js/registertm.js', array('jquery'));
			wp_localize_script('registertm', 'inf', array('ajaxurl' => admin_url($adm)));
			wp_enqueue_script('registertm');
		} else if ($post_title==='login') {
			if($li) {
				//need to get rid of this page if logged in
			}
		} else if ($post_title==='stats') {
			wp_register_script('thestats', plugin_dir_url(__FILE__ ) . 'js/stats.js', array('jquery'));
			wp_localize_script('thestats', 'myAjax', array( 'ajaxurl' => admin_url($adm), 'cols' => getcols()));
			wp_enqueue_script('thestats');
		} else if ($post_title==='casters') {
			wp_register_script('casters', plugin_dir_url(__FILE__ ) . 'js/casters.js', array('jquery'));
			wp_localize_script('casters', 'data', caster_info());
			wp_enqueue_script('casters');
		} else if ($post_title==='inbox') {
			wp_register_script('inbox', plugin_dir_url(__FILE__) . 'js/inbox.js', array('jquery'));
			wp_localize_script('inbox', 'myAjax', array( 'ajaxurl' => admin_url($adm)));
			wp_enqueue_script('inbox');
		} else if ($post_title==='my games') {
			wp_register_script('mygames', plugin_dir_url(__FILE__) . 'js/mygames.js', array('jquery'));
			wp_localize_script('mygames', 'inf', my_games_info($user));
			wp_enqueue_script('mygames');
		} else if ($post_title==='dashboard') {
			$dteams = dashboard_teams(false);//$sendeve[$add]=get_dash_events($title);
			$inf = array('events' => array());
			$ros = array();
			for ($i = 0; $i < count($dteams); $i++) {
				$events = get_dash_events($dteams[$i]['full'], $dteams[$i]['id']);
				$inf['events'][count($inf['events'])] = $events;
				$ros[count($ros)] = get_players($dteams[$i]['id']);
			}
			wp_register_script('dashboard', plugin_dir_url(__FILE__) . 'js/dashboard.js', array('jquery'));
			wp_localize_script('dashboard', 'inf', $inf);
			wp_localize_script('dashboard', 'ros', $ros);
			wp_localize_script('dashboard', 'myAjax', array( 'ajaxurl' => admin_url($adm)));
			wp_enqueue_script('dashboard');
		} else if ($post_title==='settings') {
			wp_register_script('settings', plugin_dir_url(__FILE__) . 'js/settings.js', array('jquery'));
			wp_localize_script('settings', 'myAjax', array('ajaxurl' => admin_url($adm)));
			wp_enqueue_script('settings');
		} else if ($post_title==='ryan test') {
			wp_register_script('ryan', plugin_dir_url(__FILE__) . 'js/ryan.js', array('jquery'));
			wp_localize_script('ryan', 'myAjax', array('ajaxurl' => admin_url($adm)));
			wp_enqueue_script('ryan');
		} else if($post_title==='team rosters') {
			wp_register_script('teamrosters', plugin_dir_url(__FILE__) . 'js/teamrosters.js', array('jquery'));
			wp_enqueue_script('teamrosters');
		}

		if (get_post_type()==='sp_player') {
			$id = get_the_ID();
			$ign = get_ign($id) ?? 'N/A';
			global $wpdb;
			$res = $wpdb->get_results("SELECT `ign` FROM hs_players WHERE pageid='" . $id . "';", ARRAY_A);
			if($wpdb->num_rows > 0 && $ign !== $res[0]['ign']) {
				$ign .= ' | alt: ' . $res[0]['ign'];
			}
			wp_register_script('playerpage', plugin_dir_url(__FILE__ ) . 'js/playerpage.js', array('jquery'));
			wp_localize_script('playerpage', 'playerinfo', array('ign' => $ign));
			wp_localize_script('playerpage', 'cols', getcols());
			wp_enqueue_script('playerpage');
		} else if (get_post_type()==='sp_event') {
			wp_register_script('eventpage', plugin_dir_url(__FILE__) . 'js/eventpage.js', array('jquery'));
			wp_enqueue_script('eventpage');
		}
    }
}

//get schoolnames from title string ( i.e. 'A - RL D1 vs B - RL D1' => [0]='A', [1]='B' )

/**
 * Takes a game event string and strips game titles
 * @param	string	$title	The title of the school
 * @return	array
 */

function get_schoolnames($title) {
	$title = str_replace('–', '-', $title);
	$title = str_replace('&#8211;', '-', $title);
	$dash1 = strpos($title, '- ');
	$team1 = substr($title, 0, $dash1);

	$dash2 = strpos($title, '- ', $dash1+1);
	$vs = strpos($title, ' vs ');
	$team2 = substr($title, $vs+4, $dash2-($vs+4));

	//get first dash location, substring 0 - index-1
	//get second dash location, substring ' vs '[index] - index2-1

	return [$title, $team2];
}

/**
 * Strips the game from a school subteam string
 * @param	string	$title	The title string to remove the game from
 * @return	string
 */

function remove_game_from($title) {
	$title = str_replace('–', '-', $title);
	$title = str_replace('&#8211;', '-', $title);
	$dash1 = strpos($title, '- ');
	return substr($title, 0, $dash1-1);
}

/**
 * Compares to half point of year to determine which date to use for date query.
 * @return	array
 */

 function get_date_query_info() {
	$t=getdate();
	$month = intval($t['mon']);
	$y = intval($t['year']);

	if ($month >= 2 && $month <= 7) { //spring season, current year
		return array(
			'before' => 'August 31st, ' . $y,
			'after' => 'February 15th, ' . $y,
			'inclusive' => true
		);
	} else {
		return array(
			'before' => 'January 31st, ' . ($y+1),
			'after' => 'September 1st, ' . $y,
			'inclusive' => true
		);
	}
 }

//get events for homepage blocks

/**
 * Gets all past and upcoming events and formats them for use on the homepage
 * @return	array
 */

function get_homepage_events() {
	$arr = [];
	$dqi = get_date_query_info();
	$args = array(
		'post_type' => 'sp_event', 
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'date_query' => get_date_query_info()
	);

	$query = new WP_Query($args);
	if ($query->have_posts()) {
		$i = 0;
		while($query->have_posts()) {
			$query->the_post();
			$post = $query->posts[$i];

			$date = explode(' ', $post->post_date)[0];
			$time = explode(' ', $post->post_date)[1];

			$year = explode('-', $date)[0];

			$teams = get_post_meta($post->ID, 'sp_team', false);
			$size = array(42, 42);

			if ($year > '2020') {
				$arr[count($arr)] = array(
					'url' => get_permalink($post->ID),
					'date' => $date,
					'time' => $time,
					'teams' => [remove_game_from(get_the_title($teams[0])), remove_game_from(get_the_title($teams[1]))],
					'img' => [get_the_post_thumbnail($teams[0], $size), get_the_post_thumbnail($teams[1], $size)],
					'game' => team_to_game(get_the_title($teams[0]))
				);
			}
			$i++;
		}
	}
	return $arr;
}

/**
 * Checks the database to see if the logged in user has any new messages
 * @param	int	$op	The operation use. 0 = return row count, 1+ = return the row
 * @return	ARRAY_A
 */

function refresh_messages($op) {
	global $wpdb;
	$to = wp_get_current_user()->ID;
	if ($op===0) {
		$sql = $wpdb->prepare("SELECT * FROM messages WHERE id LIKE '%$to%' AND seen = '0';");
		$wpdb->get_results($sql, ARRAY_A);
		$rows = $wpdb->num_rows;
		if ($rows===null) {
			$rows=0;
		}
		return $rows;
	} else {
		$sql = $wpdb->prepare("SELECT * FROM messages WHERE id LIKE '%$to%' AND seen = '0';");
		return $wpdb->get_results($sql, ARRAY_A);
	}
}

/**
 * Gets all messages for the logged in user
 * @return	ARRAY_A
 */

function get_messages() {
	$to = wp_get_current_user()->ID;
	global $wpdb;
	$sql = $wpdb->prepare("SELECT * FROM messages WHERE id LIKE '\%$to\%';");
	$results = $wpdb->get_results($sql, ARRAY_A);
	if ($wpdb->num_rows > 0) {
		return $results;
	}
	return false;
}

/**
 * Sends a message to a user from the system
 * @param	string	$to		The user id to send the message to
 * @param	string	$msg	The message to send
 */

function system_message($to, $msg) {
	_send_message($to, '208183339', $msg);
}

/**
 * Sends a message to a user from any user
 * @param	string	$to		The user id to send the message to
 * @param	string	$from	The user id to send the message from
 * @param	string	$msg	The message to send
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

/**
 * AJAX function to send a message from a logged in user
 */

function send_message() {
	if (strpos($_SERVER['HTTP_REFERER'], 'https://tecschoolesports.com')===false) { die();}
		
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

/**
 * Deletes a message given it's id
 * @param	int	$id		The id of the message to delete
 */

function _delete_message($id) {
	global $wpdb;
	$wpdb->query($wpdb->prepare("DELETE FROM messages WHERE identifier = '" . $id . "'"));
}

/**
 * AJAX function to delete a message of a logged in user
 */

function delete_message() {
	if (strpos($_SERVER['HTTP_REFERER'], 'https://tecschoolesports.com')===false) { die();}

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

/**
 * Gets the basic stat columns for all games
 * @return	array
 */

function getcols() {
	return array(
		0=>array( //knockout city
			''
		),
		1=>array( //overwatch
			'final blows', 'deaths', 'hero damage', 'heals dealt'
		),
		2=>array( //rocket league
			'goals', 'saves', 'shots', 'assists'
		),
		3=>array( //valorant
			'kills', 'avgcombatscore', 'deaths', 'assists', 'econ rating', 'first bloods', 'plants', 'defuses'
		)
	);
}

/**
 * Attaches to the admin script enqueue hook. Used for adding scripts to /wp-admin pages
 */

function my_admin_enqueue($hook_suffix) {
	$type=get_post_type();
	if($type==='sp_event') {
		wp_register_script('repla', plugin_dir_url(__FILE__ ) . 'js/repla.js', array('jquery'));
		wp_enqueue_script('repla');
	} else {

	}
}

add_action('admin_enqueue_scripts', 'my_admin_enqueue');

/**
 * Gets all players currently on a given team
 * @param	int	$teamid		The team id to get players from
 * @return	array
 */

function get_players($teamid) {
	$players = [];
	$query = new WP_Query(array(
		'post_type' => 'sp_player',
		'posts_per_page' => '-1',
		'post_status' => 'publish'
		));
	if ($query->have_posts()) {
		$i = 0;
		while ($query->have_posts()) {
			$query->the_post();
			$plid = $query->posts[$i]->ID;
			$meta = get_post_meta($plid, 'sp_team', false);
			if (in_array($teamid, $meta)) {
				$c = count($players);
				$players[$c] = array(
					'id' => $plid,
					'name' => $query->posts[$i]->post_title
				);
			}
			$i++;
		}
		wp_reset_postdata();
	}
	return $players;
}

/**
 * AJAX function to get the schedule for the current season
 */

function getschedule() {
	if (strpos($_SERVER['HTTP_REFERER'], 'https://tecschoolesports.com')===false) { die();}
	$S = 1359;

	if (isset($_POST['game']))
	{
		$game=strtolower($_POST['game']);
		$returnval = array('ret' => array(), 'info' => 'No events found!');
		$array=[];
		$i=0;
		$query = new WP_Query(array ( 
		'post_type' => 'sp_event',
		'posts_per_page' => '-1',
		'post_status' => 'future,publish'
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

				if (strpos($pagetitle, 'vs') !== false) {
                    if (strpos($pagetitle, $game) !== false || $game==='any') {
                        $pagename = $query->posts[$i]->post_name;
                        $pagelink = 'https://tecschoolesports.com/event/' . $pagename;
                        $pageid =  $query->posts[$i]->ID;
                        $results='';
                        $boxscore='';
                        if (date('Y-m-d') > $date) {
                            //$results = do_shortcode('[event_results id="' . $pageid . '" align="none"]');
                            //$boxscore = do_shortcode('[event_performance id="' . $pageid . '" align="none"]');
                        }
                        $push = array('name' => $pagename, 'link' => $pagelink, 'id' => $pageid, 'title' => $pagetitle, 'date' => $date, 'time' => $time, 'results' => $results, 
                        'boxscore' => $boxscore);
                        $array[intval($i)] = $push;
                    }
				}
				$i++;
			}
			if (!empty($array)){
				$returnval['ret'] = $array;
				$returnval['info'] = '';
			}
		}

		//echo json_encode($returnval);
        echo json_encode($returnval);
    	wp_reset_postdata();
	} else {
		echo json_encode(array('error' => 'error'));
	}
	die();
}

add_action('wp_ajax_getschedule', 'getschedule');
add_action('wp_ajax_nopriv_getschedule', 'getschedule');

/**
 * Converts slugs to proper game titles
 * @param	string	$info	The string to convert
 * @param	string	$t		The type of conversion. 'g' = game, 't' = team
 */

function conv($info, $t) {
	$ret = $info;
	if($t==='g') {
		if ($info==='knockoutcity') {
			$ret='Knockout City';
		} else if ($info==='rocketleagued1') {
			$ret='Rocket League D1';
		} else if ($info==='rocketleagued2') {
			$ret='Rocket League D2';
		} else if ($info==='overwatch') {
			$ret='Overwatch';
		} else if ($info==='valorant') {
			$ret='Valorant';
		}
	} else if ($t==='t') {

	}
	return $ret;
}

/**
 * Gets stat information from a given array and strip useless values
 * @param	string	$g	The game to get stat columns from
 * @param	array	$a	The array with the values
 * @param	string	$s	The name for the array's name key
 * @return	ARRAY_A
 */

function stat_i($g, $a, $s) {
	$arr = array();
	$g=strtolower($g);
	if($g==='rocket league d1' || $g==='rocket league d2') {
		$arr = array('name' => $s,
					'goals' => $a['goals'],
					'saves' => $a['saves'],
					'assists' => $a['assists'],
					'shots' => $a['shots']);
	} else if ($g==='overwatch d1' || $g==='overwatch d2') {
		$arr = array('name' => $s,
					'herodamage' => $a['herodamage'],
					'finalblows' => $a['finalblows'],
					'healsdealt' => $a['healsdealt'], 
					'deaths' => $a['deaths']);
	} else if ($g==='valorant d1' || $g==='valorant d2') {
		$arr = array('name' => $s,
					'kills' => $a['kills'],
					'defuses' => $a['defuses'],
					'plants' => $a['plants'], 
					'firstbloods' => $a['firstbloods'],
					'econrating' => $a['econrating'],
					'deaths' => $a['deaths'],
					'assists' => $a['assists']);
	} else if ($g==='knockout city d1' || $g==='knockout city d2') {
		$arr = array('name' => $s,
					'' => '',
					'' => '',
					'' => '', 
					'' => '');
	}
	return $arr;
}

/**
 * Returns an array of all stat columns
 * @return array
 */

function allcols() {
	return ['score', 'goals', 'assists', 'shots', 'saves', 'deaths', 'damage', 'healsdealt', 'finalblows', 'herodamage', 'avgcombatscore', 'econrating', 'firstbloods', 
	'plants', 'defuses', 'kills'];
}

/**
 * AJAX function to get the stats of all players for a certain game
 */

function getstats() {
	if (strpos($_SERVER['HTTP_REFERER'], 'https://tecschoolesports.com')===false) { die();}

	if (isset($_POST['game'])) {
		$target_g = conv($_POST['game'], 'g');
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
				'terms' => $target_g
			))
			));
		$c_stats = array();

		$season = get_season(season_num());

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
					$pm = get_post_meta($pl_id, 'sp_assignments', false);
					$lnfo = explode('_', $pm[0], 3);
					
				$all = $stats[$lnfo[0]/*[$lnfo[1]*/[$season]];
					$disp = stat_i($target_g, $all, $player_name);
					
					$c_stats[$thecount] = $disp;
					$thecount++;
				}
				$i++;
			}
		}
		if (!empty($c_stats)) {
			echo json_encode($c_stats);
		} else {
			echo json_encode(array('error' => '[Error] No players found.', 'c' => count($c_stats)));
		}
		wp_reset_postdata();
	}
	
	die();
}

add_action('wp_ajax_getstats', 'getstats');
add_action('wp_ajax_nopriv_getstats', 'getstats');

/**
 * AJAX function to get the sportspress stat tables of a certain player
 */

function getstatsu() {
	if (strpos($_SERVER['HTTP_REFERER'], 'https://tecschoolesports.com')===false) { die();}
		
	$ret = '';
	if (isset($_POST['player']) && isset($_POST['searchmethod'])) {
		$pl = $_POST['player'];
		$sm = $_POST['searchmethod'];
		$query = new WP_Query(array(
			'post_type' => 'sp_player',
			'posts_per_page' => '-1'
			));
		if ($query->have_posts()) {
			$i = 0;
			while ($query->have_posts()) {
				$query->the_post();
				$pl_id = $query->posts[$i]->ID;
				$got=false;
				$player_name = $query->posts[$i]->post_title;
				if($sm==='name') {
					if(strtolower($pl)===strtolower($player_name)) {
						$got=true;
					}
				} else if ($sm==='ign') {
					$meta = get_post_meta($pl_id, 'ign', true);
					if (strtolower($pl)===strtolower($meta)) {
						$got=true;
					}
				}

				if ($got===true) {
					$ret = do_shortcode('[player_statistics ' . $pl_id . ']');
				}
				$i++;
			}
		}
		wp_reset_postdata();
	} else {
		$ret = '[Error] Fields are missing!';
	}
	echo $ret;
	die();
}

add_action('wp_ajax_getstatsu', 'getstatsu');
add_action('wp_ajax_nopriv_getstatsu', 'getstatsu');

/**
 * Gets the sportspress league page id for a certain game
 * @param	string	$g	The game to get the id for
 * @return	int
 */

function get_league_id($g) {
	$g = strtolower($g);
	if (strpos($g, 'rocket league d1') !== false) {
		return 1360;
	} else if (strpos($g, 'rocket league d2') !== false) {
		return 1364;
	} else if (strpos($g, 'overwatch d1') !== false) {
		return 1361;
	} else if (strpos($g, 'overwatch d2') !== false) {
		return 1373;
	} else if (strpos($g, 'knockout city d1') !== false) {
		return 1368;
	}  else if (strpos($g, 'knockout city d2') !== false) {
		return 1374;
	} else if (strpos($g, 'valorant d1') !== false) {
		return 1362;
	} else if (strpos($g, 'valorant d2') !== false) {
		return 1372;
	}
}

/**
 * Gets the image link from the game slug. For spteam template
 * @param	string	$g	The slug to search
 * @return	string
 */

 function slug_to_image($g) {
	if (strpos($g, 'rocketleague') !== false) {
		return 'https://tecschoolesports.com/wp-content/uploads/2022/03/tec-rl.png';
	} else if (strpos($g, 'overwatch') !== false) {
		return 'https://tecschoolesports.com/wp-content/uploads/2021/10/tec-ov-e1642548358670.png';
	} else if (strpos($g, 'knockoutcity') !== false) {
		return '';
	} else if (strpos($g, 'valorant') !== false) {
		return 'https://tecschoolesports.com/wp-content/uploads/2022/03/tecva.png';
	}
 }

/**
 * Returns an array of information for the casters page
 * @return ARRAY_A
 */

function caster_info() {

	$str = array();
	$today=getdate();
	$args=array(
		'post_type' => 'sp_event',
		'posts_per_page' => '-1',
		'date_query' => array(
			array(
				'year' => $today['year'],
				'month' => $today['mon'],
				'day' => $today['mday'],
			),
		),
		'post_status' => 'publish,future',
	);
	$query = new WP_Query($args);
	if($query->have_posts()) {
		$i=0;
		while ($query->have_posts()) {
			$query->the_post();
			$id = $query->posts[$i]->ID;
			$date = $query->posts[$i]->post_date;

			$thetitle = $query->posts[$i]->post_title;
			$time = preg_split('# #', $date)[1];

			$meta_te=get_post_meta($id, 'sp_team', false);
			$meta_pl=get_post_meta($id, 'sp_player', false);
			//echo '<script>alert(JSON.stringify(' . json_encode($meta_pl) . '));</script>';
			$half = get_index(get_post_meta($id, 'sp_player', false),0);
			$t1_pl=array();
			$t2_pl=array();

			$t1_plid=array();
			$t2_plid=array();

			for ($j = 1; $j < count($meta_pl); $j++) {
				if($j===$half) {
					continue;
				}
				
				$player = new SP_Player($meta_pl[$j]);
				if($j<$half) {
					//$t1_plid[count($t1_plid)] = $meta_pl[$j];
					$t1_pl[$j-1]=array(
						'name' => get_post_meta($meta_pl[$j], 'ign', true),
						'leagueid' => get_league_id($thetitle),
						'stats' => $player->statistics()[get_league_id($thetitle)]["-1"]
					);
				} else {
					//$t2_plid[count($t2_plid)] = $meta_pl[$j];
					$t2_pl[$j-$half-1]=array(
						'name' => get_post_meta($meta_pl[$j], 'ign', true),
						'leagueid' => get_league_id($thetitle),
						'stats' => $player->statistics()[get_league_id($thetitle)]["-1"]
					);
				}
			}

			$str[$i] = array(
				'time' => $time,
				'team' => array(
					0=>array(
						'name'=>get_the_title($meta_te[0]),
						'img'=>get_the_post_thumbnail($meta_te[0], array(50, 50)),
						'players' => $t1_pl,
					),
					1=>array(
						'name'=>get_the_title($meta_te[1]),
						'img'=>get_the_post_thumbnail($meta_te[1], array(50, 50)),
						'players' => $t2_pl,
					),
				),
			);
			$i++;
		}
		wp_reset_postdata();
	} else {
		$str = array('ecode' => 'There are no matches today!');
	}
	return $str;
}

/**
 * Returns the second index of a number n in an array
 * @param	array	$arr	The array to search
 * @param	int		$n		The number to search for in the array
 * @return	int
 */

function get_index($arr, $n) { //get second index of 'n'
	$c=0;
	$in=-1;
	for ($i = 0; $i < count($arr); $i++) {
		if(intval($arr[$i])===$n) {
			$c++;
			if($c===2) {
				$in=$i;
				break;
			}
		}
	}
	return $in;
}

/**
 * Displays a string in the default javascript alert
 * @param	string	$d	The message to show
 */

function alert($d) {
	echo '<script>alert(' . $d . ')</script>';
}

/**
 * Displays a JSON object in the default javascript alert
 * @param	string	$d	The JSON object to show
 */

function alerta($d) {
	echo '<script>alert(JSON.stringify(' . $d . '))</script>';
}

/**
 * Finds the game from a sub team title string
 * @param	string	$game	The title to find the game from
 * @return	string
 */

 // this is garbage

function team_to_game($game) {
	$ret = '';
	$game=strtolower($game);
	if(strpos($game, 'rocket league d1')!==false) {
		$ret='Rocket League D1';
	} else if(strpos($game, 'rocket league d2')!==false) {
		$ret='Rocket League D2';
	} else if(strpos($game, 'overwatch d1')!==false) {
		$ret='Overwatch D1';
	} else if(strpos($game, 'overwatch d2')!==false) {
		$ret='Overwatch D2';
	} else if(strpos($game, 'valorant d1')!==false && strpos($game, '(green)')===false && strpos($game, '(yellow)')===false) {
		$ret='Valorant D1';
	} else if(strpos($game, 'valorant d2')!==false && strpos($game, '(green)')===false && strpos($game, '(yellow)')===false) {
		$ret='Valorant D2';
	} else if(strpos($game, 'valorant (green)')!==false) {
		$ret='Valorant (Green)';
	} else if(strpos($game, 'valorant (yellow)')!==false) {
		$ret='Valorant (Yellow)';
	} else if(strpos($game, 'knockout city d1')!==false) {
		$ret='Knockout City D1';
	} else if(strpos($game, 'knockout city d2')!==false) {
		$ret='Knockout City D2';
	}

	return $ret;
}

/**
 * Gets the array of past & upcoming matches for the 'My Games' page
 * @param	WP_User	$user	The user to get the info for
 * @return	ARRAY_A
 */

function my_games_info($user) {
	$arr = array();
	if ($user->ID) {
		$id = pageid($user->ID);
		$teams = get_post_meta($id, 'sp_team', false);
		for ($i = 0; $i < count($teams); $i++) {
			if ($teams[$i]==0) continue;
			
			$name = get_the_title($teams[$i]);
			$arr[count($arr)]=array(
				'name' => $name,
				'img' => team_to_game($name),
				'events' => get_events($name, $teams[$i])
			);
		}
	}
	return $arr;
}

/**
 * Return the sportspress player page id for a given user
 * @param	string	$id		The id to get the page from
 */

function pageid($id) {
	return get_user_meta($id, 'pageid', true);
}

/**
 * Gets the events for a certain team
 * @param	string	$team	The team string to get the games for
 * @param	int	$teamid		The id of the team to get the games for
 * @return	ARRAY_A
 */

function get_events($team, $teamid) {
	$S = 1359;
	$array=[];
	$i=0;

	$team = str_replace('&#8211;', '-', $team);
	$team = str_replace('–', '-', $team);

	$query = new WP_Query(array ( 
	'post_type' => 'sp_event',
	'posts_per_page' => '-1',
	'post_status' => 'future,publish'
	));

	if ($query->have_posts()) 
	{
		while($query->have_posts()) 
		{
			$query->the_post();
			$pagetitle=$query->posts[$i]->post_title;
			$date = $query->posts[$i]->post_date;
			$time = preg_split('# #', $date)[1];
			$date = preg_split("# #", $date)[0];
			$pagetitle = str_replace('&#8211;', '-', $pagetitle);
			$pagetitle = str_replace('–', '-', $pagetitle);

			if (strpos($pagetitle, 'vs') !== false && strpos($pagetitle, $team) !== false) {
				$pagename = $query->posts[$i]->post_name;
				$pagelink = 'https://tecschoolesports.com/event/' . $pagename;
				$pageid =  $query->posts[$i]->ID;
				$result=get_post_meta($pageid, 'sp_results', true);
				$result = $result[$teamid]['outcome'][0] ? $result[$teamid]['outcome'][0] : 'N/A';

				if (date('Y-m-d') > $date) {
					//past event
				}
				$push = array('name' => $pagename, 'link' => $pagelink, 'id' => $pageid, 'title' => $pagetitle, 'date' => $date, 'time' => $time, 'result' => $result);
				$array[count($array)] = $push;
			}
			$i++;
		}
		wp_reset_postdata();
	}
	return $array;
}

/**
 * Gets the subteams for a team manager, and prints the buttons to the screen
 * @param	WP_User	$user	The user to get the games for
 */

function get_tm_subteams($user) {
	
	$myteam = get_user_meta($user->ID, 'teamid', true);
	$team = get_the_title($myteam);

	$query = new WP_Query(array ( 
		'post_type' => 'sp_team',
		'posts_per_page' => '-1',
		'post_status' => 'future,publish'
			));

	if ($query->have_posts()) {
		$i=0;
		$sea = get_season(season_num());
		while ($query->have_posts()) {
			$query->the_post();
			$title = $query->posts[$i]->post_title;
			if (strpos($title, $team)!==false && intval($query->posts[$i]->ID) !== intval($myteam)) {
				$add = str_replace($team . ' - ', '', $title);
			}
			$i++;
		}

		sort($buttons);
		for ($i = 0; $i < count($buttons); $i++) { 
			echo '<button id="game' . $i . '" class="mygamesbox" onclick="updatedashboard(' . $i . ')">' . $buttons[$i] . '</button>';
		}
	}
	wp_reset_postdata();
}

/**
 * Returns the season of a game
 * @param	int	$eventid	The id of the event
 * @return	int
 */

function event_season($eventid) {
	return get_the_terms($eventid, 'sp_season')[0]->term_id;
}

/**
 * Returns the most recent season for an wordpress post
 * @param	int	$id		The id of the post
 * @return	int
 */

function r_seas($id) {
	$seasons = get_the_terms($id, 'sp_season');
	$mseas = $seasons[0]->term_id;
	for ($i = 1; $i < count($seasons); $i++) {
		if ($seasons[$i]->term_id > $mseas) {
			$mseas=$season[$i]->term_id;
		}
	}
	return $mseas;
}

/**
 * Gets all events for the team manager dashboard page
 * @param	string	$team	The team manager's team title
 * @param	int		$tid	The id of the manager's team
 * @return	ARRAY_A
 */

function get_dash_events($team, $tid) {
	$S = get_season(season_num());
	$S=1359;
	$array=array(
		'future'=> array(),
		'past'=>array()
	);
	$i=0;

	$team = str_replace('&#8211;', '-', $team);
	$team = str_replace('–', '-', $team);

	$query = new WP_Query(array ( 
	'post_type' => 'sp_event',
	'posts_per_page' => '-1',
	'post_status' => 'future,publish'
	));

	if ($query->have_posts()) 
	{
		while($query->have_posts()) 
		{
			$query->the_post();
			$pagetitle=$query->posts[$i]->post_title;
			$date = $query->posts[$i]->post_date;
			$time = preg_split('# #', $date)[1];
			$date = preg_split("# #", $date)[0];
			$pagetitle = str_replace('&#8211;', '-', $pagetitle);
			$pagetitle = str_replace('–', '-', $pagetitle);
			$pageid =  $query->posts[$i]->ID;

			if (strpos($pagetitle, 'vs') !== false && strpos($pagetitle, $team) !== false && $date > "2020-01-01"){// && event_season($pageid)===$S) {
				$pagename = $query->posts[$i]->post_name;
				//$pagelink = 'https://tecschoolesports.com/event/' . $pagename;

				

				$push = array('name' => $pagename, 'opponent' => isolate_opponent($pagetitle, $team), 'id' => $pageid, 'title' => $pagetitle, 'date' => $date, 'time' => $time, 'roster' => get_event_roster($tid, $pageid));

				if (date('Y-m-d') > $date) {
					$array['past'][count($array['past'])] = $push;
				} else {
					$array['future'][count($array['future'])] = $push;
				}
			}
			$i++;
		}
		wp_reset_postdata();
	}
	return $array;
}

/**
 * AJAX function to allow a user to update profile fields
 */

function update_profile() {
	
	if (strpos($_SERVER['HTTP_REFERER'], 'https://tecschoolesports.com')===false) { die();}

	$user = wp_get_current_user();
	if (!$user->ID) { echo '[Error] Invalid user.'; die(); }
	$pageid = get_user_meta($user->ID, 'pageid', true);
	global $wpdb;

	if (isset($_POST['ign']) && $_POST['ign']) {
		update_user_meta($pageid, 'ign', trim($_POST['ign']));
		/*$wpdb->update('hs_students', array(
			'ign' => 
		));*/
	}
	if (isset($_POST['pronouns']) && $_POST['pronouns']) {
		update_user_meta($pageid, 'pronouns', trim($_POST['pronouns']));
	}
	echo '[Success] All actions completed successfully.';
	die();
}

add_action('wp_ajax_update_profile', 'update_profile');
add_action('wp_ajax_nopriv_update_profile', 'update_profile');

/**
 * Returns the opponent from a title
 * @param	string	$title	The title to use
 * @param	string	$home	The home team to strip
 * @return	string
 */

function isolate_opponent($title, $home) {
	$title = str_replace(' vs ', '', $title);
	$title = str_replace($home, '', $title);
	$title = str_replace(' - ' . explode(' - ', $home)[1], '', $title);
	return $title;
}

/**
 * AJAX function for the team manager to submit their roster for an event
 */

function confirm_roster() {
	
	if (strpos($_SERVER['HTTP_REFERER'], 'https://tecschoolesports.com')===false) { die();}

	$ret = '[Success] Roster submitted.';
	$user = wp_get_current_user();

	if (!$user->ID) { echo '[Error] Invalid user.'; die(); }
	if (!(in_array('team_manager', $user->roles) || in_array('administrator', $user->roles))) { echo '[Error] Insufficient permissions.'; die(); }
	if (!( isset($_POST['players']) && isset($_POST['eventid']) )) { echo '[Error] Missing fields!'; die(); }

	$eventid = $_POST['eventid'];
	$players = $_POST['players'];

	if (count($players) < 2 || !$players) {
		echo '[Error] Not enough players selected!';
		die();
	}

	if ($eventid === -1) {
		echo '[Error] Invalid event.';
		die();
	}

	$teamid = get_user_meta($user->ID, 'teamid', true);

	$c = array_keys(get_children(array(
		'post_parent' => $teamid,
		'post_type' => 'sp_team'), ARRAY_N));

	$eteams = get_post_meta($eventid, 'sp_team', false);
	
	for ($i = 0; $i < count($c); $i++) {
		for ($j = 0; $j < count($eteams); $j++) {
			if ($c[$i]===$eteams[$j]) {
				$teamid=$eteams[$j];
				break 2;
			}
		}
	}

	$index = array_search($teamid, $eteams);
	$eplayers = get_post_meta($eventid, 'sp_player', false);
	$half = get_index($eplayers, 0);
	
	$h1 = array_slice($eplayers, 0, $half);
	$h2 = array_slice($eplayers, $half);

	$newarr = [0];

	for ($i=0; $i< count($players); $i++) {
		$newarr[count($newarr)] = $players[$i];
	}

	if ($index===0) {
		$newarr = array_merge($newarr, $h2);

		//$ret = implode(',', $newarr) . ' {} ' . implode(',',$h2);

	} else {
		$newarr = array_merge($h1, $newarr);
		//$ret = implode(',', $newarr) . ' {} ' . implode(',',$h1);
	}
	delete_post_meta($eventid, 'sp_player');
	update_post_meta($eventid, 'sp_player', 0);
	for ($i = 1; $i < count($newarr); $i++) {
		add_post_meta($eventid, 'sp_player', $newarr[$i]);
	}

	echo $ret;
	die();
}

add_action('wp_ajax_confirm_roster', 'confirm_roster');
add_action('wp_ajax_nopriv_confirm_roster', 'confirm_roster');

/**
 * Gets all game titles a team competes in for the team manager's dashboard
 * @param	boolean	$stronly	Determines whether HTML buttons or a array of events will be returned
 * @return	ARRAY_A
 */

function dashboard_teams($stronly) {
	$myteam = get_user_meta(wp_get_current_user()->ID, 'teamid', true);
	$team = get_the_title($myteam);

	$query = new WP_Query(array ( 
		'post_type' => 'sp_team',
		'posts_per_page' => '-1',
		'post_status' => 'future,publish'
			));
	$buttons=[];
	if ($query->have_posts()) {
		$i=0;
		$sea = get_season(season_num());
		while ($query->have_posts()) {
			$query->the_post();
			$title = $query->posts[$i]->post_title;
			if (strpos($title, $team)!==false && intval($query->posts[$i]->ID) !== intval($myteam)) {
				$add = str_replace($team . ' - ', '', $title);
				if ($stronly) {
					$buttons[count($buttons)] = $add;
				} else {
					$buttons[count($buttons)] = array('name' => $add, 'id' => $query->posts[$i]->ID, 'full' => $title);
				}
			}
			$i++;
		}
	}
	wp_reset_postdata();
	sort($buttons);
	return $buttons;
}

/**
 * Returns the roster of a certain event for a given team
 * @param	int	$teamid		The id of the team to get the roster for
 * @param	int	$eventid	The id of the event to get the roster from
 * @return	array
 */

function get_event_roster($teamid, $eventid) {
	if (strpos($_SERVER['HTTP_REFERER'], 'https://tecschoolesports.com')===false) { die();}
		
	$index = array_search($teamid, get_post_meta($eventid, 'sp_team', false));
	$players = get_post_meta($eventid, 'sp_player', false);
	$half = get_index($players, 0);

	if (!$players || count($players)===$half) return 0;

	$start = $index ? $half : 0;
	$end = $index ? count($players) : $half;

	if ($end-$start < 3) return 0;

	$ret=array();
	for ($i = $start; $i < $end; $i++) {
		$c_p = $players[$i];
		if (!$c_p) continue;
		$ret[count($ret)] = array(
			'id' => $c_p,
			'name' => get_the_title($c_p),
			'ign' => get_ign($c_p)
		);
	}
	return $ret;
}

/**
 * Gets the team id of a team string
 * @param	string	$name	The name of the name
 * @return	int
 */

function getteamid($name) {
	return post_exists(trim(ucwords($name)));
}

/**
 * Generates a random 20 character string for a new school
 * @return	string
 */

function gen_schoolcode() {
	$code = bin2hex(random_bytes(10));
	while (sc_exists($code)) {
		$code = bin2hex(random_bytes(10));
	}
	return $code;
}

/**
 * Determines whether a school code has already been generated or not
 * @param	string	$code	The code to search for
 * @return	boolean
 */

function sc_exists($code) {
	global $wpdb;
	$sql = $wpdb->prepare("SELECT * FROM hs_reg WHERE code = '$code';");
	$wpdb->get_results($sql, ARRAY_A);
	$rows = $wpdb->num_rows;
	if ($rows===null) {
		$rows=0;
	}
	return $rows>0;
}

/**
 * Adds an array of values to a certain post's meta
 * @param	int		$id		The id of the post
 * @param	ARRAY_A	$vals	The array of keys and values to add meta to
 */

function upmeta($id, $vals) {
	$k = array_keys($vals);
	for ($i = 0; $i < count($k); $i++) {
		update_post_meta($id, $k[$i], $vals[$k[$i]]);
	}
}

/**
 * Gets a small int value based on the month of the current year
 * @return	int
 */

function season_num() {
	$today = getdate();
	$num = intval($today['year']) - 2021;
	if ($today['mon'] >= 8) {
		$num+=1;
	}
	return $num;
}

/**
 * Returns a number for a game title, starting from 0 in alphabetical order
 * @param	string	$name	The name of the game
 * @return	int
 */

function name_to_game_id($name) {
	$id = -1;
	$name = trim(strtolower($name));
	if ($name==='knockout city d1' || $name==='knockout city d2') {
		$id = 0;
	} else if ($name==='overwatch d1' ||$name==='overwatch d2') {
		$id = 1;
	} else if ($name==='rocket league d1'||$name==='rocket league d2') {
		$id = 2;
	} else if ($name==='valorant d1' || $name==='valorant d2') {
		$id = 3;
	}
	return $id;
}

/**
 * Creates the slug based off an input string
 * @param	string	$input	The input string with capital letters and spaces
 * @return	string
 */

function make_slug($input) {
	$input = strtolower($input);
	return str_replace(' ', '', $input);
}

/**
 * Creates all new subteam pages and parent page when a new school is to be added
 * @param	string	$name	The name of the school
 * @param	ARRAY_A	$gamesd	The array of games to create pages for
 * @return ARRAY_A
 */

function create_new_team($name, $gamesd) {
	$stpages='';
	$season = season_num();
	$parent_args = array(
		'post_content' => $content,
		'post_type' => 'sp_team',
		'post_status' => 'publish',
		'post_title' => ucwords($name),
		'post_name' => make_slug($name)
	);
	$teamid = wp_insert_post($parent_args);
	wp_set_post_terms($teamid, array(),'sp_league');
	wp_set_post_terms($teamid, get_term(get_season($season), 'sp_season', ARRAY_A),'sp_season');
	wp_set_post_terms($teamid, array(),'sp_venue');
	//$staffid=0;
	//update_post_meta($teamid, 'sp_staff', $staffid);
	for ($j = 0; $j < count($gamesd); $j++) {
		$games = $gamesd[$j];
		for ($i = 0; $i < count($games); $i++) {
			$comma = ',';
			if ($j===count($gamesd)-1 && $i===count($games)-1) {
				$comma = '';
			}
			$list_args = array(
				'post_title' => ucwords($name) . ' - ' . ucwords($games[$i]) . ' - Players',
				'post_type' => 'sp_list',
				'post_content' => '',
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => makeslug($games[$i])
			);
			$gameid = name_to_game_id($games[$i]);
			$listid = wp_insert_post($list_args);
			wp_set_post_terms($listid, get_term(get_league_id($games[$i]), 'sp_league', ARRAY_A),'sp_league');
			wp_set_post_terms($listid, array(),'sp_season');
			wp_set_post_terms($listid, array(),'sp_position');
			$columns = getcols()[$gameid];
			upmeta($listid, array(
				'sp_format' => 'list',
				'sp_columns' => $columns,
				'sp_era' => 'current',
				'sp_orderby' => $columns[0],
				'sp_order' => 'DESC',
				'sp_select' => 'auto',
				'sp_current_season' => 1
			));

			$subpage_args = array(
				'post_content' => '',
				'post_type' => 'sp_team',
				'post_status' => 'publish',
				'post_title' => ucwords($name) . ' - ' . ucwords($games[$i]),
				'post_parent' => $teamid,
				'post_author' => 1,
				'post_name' => make_slug($games[$i])
			);

			$subpageid = wp_insert_post($subpage_args);
			wp_set_post_terms($subpageid, get_term(get_league_id($games[$i]), 'sp_league', ARRAY_A),'sp_league');
			wp_set_post_terms($subpageid, get_term(get_season($season), 'sp_season', ARRAY_A),'sp_season');
			update_post_meta($subpageid, 'sp_list', $listid);
			update_post_meta($listid, 'sp_team', $subpageid);
			$stpages .= '' . $subpageid . $comma;
		}
	}
	//other functions: set_thumbnail, add this team to league tables

	//update teams page
	return array(
		'parent' => $teamid,
		'subpages' => $stpages
	);
}

/**
 * Creates new sub team pages for a parent team, and adds the newest season to their taxonomies
 * @param	int		$teamid		The id of the parent team
 * @param	ARRAY_A	$gamesd		The array of games to create pages for
 * @return	array
 */

function append_and_add_teams($teamid, $gamesd) {
	$stpages = '';
	$season = season_num();
	$school=trim(get_the_title($teamid));
	for ($j = 0; $j < count($gamesd); $j++) {
		$games = $gamesd[$j];
		for ($i = 0; $i < count($games); $i++) {
			$comma = ',';
			if ($j===count($gamesd)-1 && $i===count($games)-1) {
				$comma = '';
			}
			$listexists = pageexists("$school - " . $games[$i] . ' - Players', "$school – " . $games[$i] . ' – Players');
			if ($listexists===-1) {//dne
				$list_args = array(
					'post_title' => ucwords($school) . ' - ' . ucwords($games[$i]) . ' - Players',
					'post_type' => 'sp_list',
					'post_content' => '',
					'post_status' => 'publish',
					'post_author' => 1
				);
				$gameid = name_to_game_id($games[$i]);
				$listexists = wp_insert_post($list_args);
				wp_set_post_terms($listexists, get_term(get_league_id($games[$i]), 'sp_league', ARRAY_A),'sp_league');
				wp_set_post_terms($listexists, array(),'sp_season');
				wp_set_post_terms($listexists, array(),'sp_position');
				$columns = getcols()[$gameid];
				upmeta($listexists, array(
					'sp_format' => 'list',
					'sp_columns' => $columns,
					'sp_era' => 'current',
					'sp_orderby' => $columns[0],
					'sp_order' => 'DESC',
					'sp_select' => 'auto',
					'sp_current_season' => 1
				));
			}

			$subexists = pageexists("$school - " . $games[$i], "$school – " . $games[$i]);
			if ($subexists===-1) {//dne
				$subpage_args = array(
					'post_content' => '',
					'post_type' => 'sp_team',
					'post_status' => 'publish',
					'post_title' => ucwords($school) . ' - ' . ucwords($games[$i]),
					'post_parent' => $teamid,
					'post_author' => 1,
					'post_name' => make_slug($games[$i])
				);
				$subexists = wp_insert_post($subpage_args);
				wp_set_post_terms($subexists, get_term(get_league_id($games[$i]), 'sp_league', ARRAY_A),'sp_league');
				wp_set_post_terms($subexists, get_term(get_season($season), 'sp_season', ARRAY_A),'sp_season');
				update_post_meta($subexists, 'sp_list', $listexists);
				update_post_meta($listexists, 'sp_team', $subexists);
			} else {
				wp_set_post_terms($subexists, get_term(get_season($season), 'sp_season', ARRAY_A),'sp_season', true);
			}
			$stpages .= '' . $subexists . $comma;
		}
	}
	return $stpages;
}

/**
 * Determines whether a page exists, based off 2 title entries
 * @param	string	$t1		The first title to check
 * @param	string	$t2		The second title to check
 * @return	int
 */

function pageexists($t1, $t2) {
	$e = post_exists($t1);
	if ($e) return $e;
	$e = post_exists($t2);
	if ($e) return $e;
	return -1;
}

/**
 * Adds the current season to all subpages of a parent team, based off of the database entires
 * @param	int	$teamid		The id of the parent team
 */

function update_team($teamid) {
	$season_add = season_num();
	global $wpdb;
	$sql = $wpdb->prepare("SELECT subpages WHERE teamid = $teamid;");
	$result = $wpdb->get_results($sql, ARRAY_A);
	$rows = $wpdb->num_rows;
	if($rows>0) {
		$ids = explode(',', $result[0]);
		for ($i = 0; $i < count($rows); $i++) {
			wp_set_post_terms($ids[$i], get_season($season_add), 'sp_season', true);
		}
	}
}

/**
 * Gets the id of the current season, based off of either a string title or small integer entry
 * @param	int|string	$s	The season's name or number
 * @return	int
 */

function get_season($s) {
	$se = 1359;
	if ($s===1||$s==='Spring 2022') {
		$se=1367;
	} else if ($s===2||$s==='Fall 2022') {
		$se=1369;
	} else if ($s===3||$s==='Spring 2023') {
		$se=1370;
	} else if ($s===4||$s==='Fall 2023') {
		$se=1371;
	}
	return $se;
}

/**
 * Get the name of the current season based off time of year
 * @return	string
 */

function get_cseas() {
	$year = 0;//this year
	$month = 0; //this month
	return ($month > 8 ? 'Fall ' : 'Spring ') . $year;
}

/**
 * AJAX function for team manager registration
 */

function tm_register() {
	if (strpos($_SERVER['HTTP_REFERER'], 'https://tecschoolesports.com')===false) { die();}

        if (!(isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['cpass']) && isset($_POST['pcperson']) && isset($_POST['pctitle'])
	&& isset($_POST['pcemail']) && isset($_POST['pcphone']) && isset($_POST['pcdiscord']) && isset($_POST['team1games']) && isset($_POST['primarycolor']) 
	&& isset($_POST['secondarycolor']))) { 

		//$echo = $_POST['username'] .'|'. $_POST['pass'] .'|'. $_POST['cpass'] .'|'. $_POST['pcperson'] .'|'. $_POST['pctitle'] .'|'. $_POST['pcemail'] .'|'. $_POST['pcphone'] .'|'. $_POST['pcdiscord'] .'|'. $_POST['team1games'] .'|'. $_POST['primarycolor'] .'|'. $_POST['secondarycolor'];
		echo '[Error] Fields are missing!'; die(); 
	}

	/* verify captcha */

	if (!isset($_POST['gre_captcha'])) { echo '[Error] Captcha is incomplete!'; die(); }
	$captcha = $_POST['gre_captcha'];
	$v = verify_captcha($captcha, $_SERVER['REMOTE_ADDR']);
	if (!$v) { echo '[Error] Invalid captcha'; die(); }

	/* done */

    $tec_user = sanitize_text_field(trim($_POST['username']));
    $tec_email = sanitize_email(trim($_POST['pcemail']));
    $tec_pass = sanitize_text_field(trim($_POST['pass']));
    $tec_cpass = sanitize_text_field(trim($_POST['cpass']));
	$school = sanitize_text_field(trim($_POST['school']));
	$teamname = sanitize_text_field(trim($_POST['teamname']));
	$mascot = sanitize_text_field(trim($_POST['mascot']));
	$pcperson = sanitize_text_field(trim($_POST['pcperson']));
	$pctitle = sanitize_text_field(trim($_POST['pctitle']));
	$pcphone = sanitize_text_field(trim($_POST['pcphone']));
	$pcdiscord = sanitize_text_field(trim($_POST['pcdiscord']));
	$team1games = $_POST['team1games'];
	$team2games = $_POST['team2games'];
	$primarycolor = sanitize_text_field(trim($_POST['primarycolor']));
	$secondarycolor = sanitize_text_field(trim($_POST['secondarycolor']));
	$socialmedia = sanitize_text_field(trim($_POST['socialmedia']));

    if($tec_pass!==$tec_cpass) { echo '[Error] Passwords do not match.'; die(); }
    if (!preg_match('/^[a-z0-9]{2,}[a-z0-9_]+$/i', $tec_user)) { echo '[Error] Username may only contain letters (a-z), numbers(0-9), and underscore (_)'; die(); }
    if (email_exists($tec_email)) { echo '[Error] An account with that email already exists.'; die(); }
    if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $tec_email) ) { echo '[Error] Invalid email.'; die(); }
    if (username_exists($tec_user)) { echo '[Error] An account with that username already exists.'; die(); }

	if (!($tec_user && $tec_email && $tec_pass && $tec_cpass && $school && $school && $pcperson && $pctitle && $pcphone && $pcdiscord && $primarycolor 
	&& $secondarycolor)) { echo '[Error] Fields are missing!'; die(); }

	$args = array(
		'user_login' => $tec_user,
		'user_pass' => $tec_pass,
		'user_email' => $tec_email,
		'display_name' => $tec_user
	);
                            
	$status = wp_insert_user($args);
	if (is_wp_error($status)) {
		echo '[Error] There was an error creating your account. Please try again.';
	} else {
		do_action('user_register', $status);
		$creds = array();
		$creds['user_login'] = $tec_user;
		$creds['user_password'] = $tec_pass;
		$creds['remember'] = true;
		$user = wp_signon($creds, false);
		if (!is_wp_error($user)) {
			//fix roles
			$user->add_role('team_manager');
			if(in_array('subscriber', $user->roles)) {
				$user->remove_role('subscriber');
			}

			$teamid = getteamid($school);
			$code= gen_schoolcode();
			//success
			$imported = 1;
			if (!$teamid) {
				$t = create_new_team($school, array(
					0=>$team1games,
					1=>$team2games
				));

				$teamid = $t['parent'];
				$subt = $t['subpages'];
				$imported=0;
				
				global $wpdb;
				$wpdb->insert('hs_staff', array(
					'school' => $school,
					'pcperson' => $pcperson,
					'title' => $pctitle,
					'mascot' => $mascot,
					'email' => $tec_email,
					'phone' => $pcphone,
					'discord' => $pcdiscord,
					'teamname' => $teamname,
					'pcolor' => $primarycolor,
					'scolor' => $secondarycolor,
					'socialmedia' => $socialmedia,
					'teamid' => intval($teamid),
					'regdate' => date("Y-m-d"),
					'code' => $code,
					'ID' => $user->ID,
					'imported' => $imported,
					'subpages' => $subt
				));

				$headers = 'From: no-reply@tecschoolesports.com' . "\r\n";
				$subject = "Registration complete!";
				$message = 'Your TEC School Esports account has been created.\nSend this link to your students to register: https://tecschoolesports.com/register/student?schoolcode=' . $code;
				wp_mail($_POST['email'], $subject, $message, $headers);
				update_user_meta($user->ID, 'teamid', $teamid);
				echo "[Success] values| s:$school,pcp:$pcperson,t:$pctitle,m:$mascot,e:$tec_email,p:$pcphone,d:$pcdiscord,tn:$teamname" . 
				"pc:$primarycolor,sc:$secondarycolor,sm:$socialmedia,ti:$teamid,rd:".date("Y-m-d").",co:$code,id:$user->ID,i:$imported";

			} else {
				
				$teamdb = is_team_in_db($teamid);

				if ($teamdb) {
					echo '[Error] This team already exists. Please contact us if you believe this is an error.';
					die();
				}

				update_user_meta($user->ID, 'teamid', $teamid);
				$t = append_and_add_teams($teamid, array(
					0=>$team1games,
					1=>$team2games
				));

				global $wpdb;
				$wpdb->insert('hs_staff', array(
					'school' => $school,
					'pcperson' => $pcperson,
					'title' => $pctitle,
					'mascot' => $mascot,
					'email' => $tec_email,
					'phone' => $pcphone,
					'discord' => $pcdiscord,
					'teamname' => $teamname,
					'pcolor' => $primarycolor,
					'scolor' => $secondarycolor,
					'socialmedia' => $socialmedia,
					'teamid' => $teamid,
					'regdate' => date("Y-m-d"),
					'code' => $code,
					'ID' => $user->ID,
					'imported' => $imported,
					'subpages' => $t
				));

				$headers = 'From: no-reply@tecschoolesports.com' . "\r\n";
				$subject = "Registration complete!";
				$message = 'Your TEC School Esports account has been created.\nYour school is already in our system, so we will review your request and respond soon!';
				wp_mail($_POST['email'], $subject, $message, $headers);
				echo "[Success] Your TEC School Esports account has been created.\nYour school is already in our system, so we will review your request and respond soon!";
			}
			
		} else {
			echo '[Error] There was an error signing you in.';
		}
	}
	die();
}

add_action('wp_ajax_tm_register', 'tm_register');
add_action('wp_ajax_nopriv_tm_register', 'tm_register');

/**
 * Determines whether a team has registered to the database
 * @param	int	$id		The team id to look for
 * @return	boolean
 */

function is_team_in_db($id) {
	global $wpdb;
	$sql = $wpdb->prepare("SELECT * FROM hs_staff WHERE teamid = '$id';");
	$res = $wpdb->get_results($sql, ARRAY_A);
	return $wpdb->num_rows>0;
}

/**
 * AJAX function to add the new season to parent team and all of its sub teams
 */

function team_renew() {
	if (strpos($_SERVER['HTTP_REFERER'], 'https://tecschoolesports.com')===false) { die();}
	$userid = 0;
	if (!$userid) { echo '[Error] Team could not be renewed at this time.'; die(); }
	$teamid = get_user_meta($userid, 'teamid', true);
	update_team($teamid);
	die();
}

//dd_action('wp_ajax_team_renew', 'team_renew');
//add_action('wp_ajax_nopriv_team_renew', 'team_renew');

/**
 * Gets the sportspress page id of a student
 * @param	string	$name	The name of the student
 * @return	int
 */

function getstudentid($name) {
	$name=ucwords($name);
	return post_exists($name);
}

/**
 * Verifies that the captcha was completed successfully
 * @param	string	$captcha	The captcha value sent from the client
 * @param	string	$remote		$_SERVER['REMOTE_ADDR'] value
 * @return	boolean
 */

function verify_captcha($captcha, $remote) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, [
		'secret' => get_private_key(),
		'response' => $captcha,
		'remoteip' => $remote
	]);

	$resp = json_decode(curl_exec($ch));
	curl_close($ch);
	return $resp->success;
}

/**
 * AJAX function for student registration
 */

function student_register() {
	if (strpos($_SERVER['HTTP_REFERER'], 'https://tecschoolesports.com')===false) { die();}

    if (!(isset($_POST['email']) && isset($_POST['ign']) && isset($_POST['pronouns']) && isset($_POST['games']) && isset($_POST['username']) && isset($_POST['pass']) && 
	isset($_POST['schoolcode']) && isset($_POST['name']) && isset($_POST['grade']) && isset($_POST['cpass']))) { echo '[Error] Fields are missing!'; die(); }

	if (!isset($_POST['schoolcode'])) { echo '[Error] You must enter a schoolcode!'; die(); }
	
	/* verify captcha */

	if (!isset($_POST['gre_captcha'])) { echo '[Error] Captcha is incomplete!'; die(); }
	$captcha = $_POST['gre_captcha'];
	$v = verify_captcha($captcha, $_SERVER['REMOTE_ADDR']);
	if (!$v) { echo '[Error] Invalid captcha'; die(); }

	/* done */

    $tec_user = sanitize_text_field(trim($_POST['username']));
    $tec_email = sanitize_email(trim($_POST['email']));
    $tec_pass = sanitize_text_field(trim($_POST['pass']));
    $tec_cpass = sanitize_text_field(trim($_POST['cpass']));
	$name = sanitize_text_field(trim($_POST['name']));
	$ign = sanitize_text_field(trim($_POST['ign']));
	$games = $_POST['games'];
	$pronouns = sanitize_text_field(trim($_POST['pronouns']));
	$grade = trim($_POST['grade']);

	if (!($tec_user && $tec_email && $tec_pass && $tec_cpass && $name && $ign && $pronouns)) { echo '[Error] Fields are missing!'; die(); }

	if(!intval($grade)) {
		$grade='';
	}
	$schoolcode = sanitize_text_field($_POST['schoolcode']);

	//verify valid schoolcode
	
	$school = 0;
	global $wpdb;
	$sql = $wpdb->prepare("SELECT teamid FROM hs_staff WHERE code = '$schoolcode';");
	$s = $wpdb->get_results($sql, ARRAY_A);
	
	if($wpdb->num_rows > 0) {
		$school = $s[0]['teamid'];
	} else {
		echo '[Error] The schoolcode is invalid!';
		die();
	}


    if($tec_pass!==$tec_cpass) { echo '[Error] Passwords do not match.'; }
    if (!preg_match('/^[a-z0-9]{2,}[a-z0-9_]+$/i', $tec_user)) { echo '[Error] Username may only contain letters (a-z), numbers(0-9), and underscore (_)'; die(); }
    if (email_exists($tec_email)) { echo '[Error] An account with that email already exists.'; die(); }
    if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $tec_email) ) { echo '[Error] Invalid email.'; die(); }
    if (username_exists($tec_user)) { echo '[Error] An account with that username already exists.'; die(); }



	$args = array(
		'user_login' => $tec_user,
		'user_pass' => $tec_pass,
		'user_email' => $tec_email,
		'display_name' => $tec_user
	);
                            
	$status = wp_insert_user($args);
	if (is_wp_error($status)) {
		echo '[Error] There was an error creating your account. Please try again.';
	} else {
		do_action('user_register', $status);
		$headers = 'From: no-reply@tecschoolesports.com' . "\r\n";
		$subject = "Registration complete!";
		$message = "Your TEC School Esports account has been created.\nYour login details:\nUsername: " . $_POST['username'] . "\nPassword: " . $_POST['pass'];
		wp_mail($_POST['email'], $subject, $message, $headers);
		$creds = array();
		$creds['user_login'] = $tec_user;
		$creds['user_password'] = $tec_pass;
		$creds['remember'] = true;
		$user = wp_signon($creds, false);
		if (!is_wp_error($user)) {

			$user->add_role('student');
			if(in_array('subscriber', $user->roles)) {
				$user->remove_role('subscriber');
			}



			//do everything
			$pageid = getstudentid($name);
			if (!$pageid) {
				$pageid = create_student($name, $user->ID);
			} else {
				if (is_student_in_db($pageid)) {
					$codeadd = bin2hex(random_bytes(3));
					$pageid = create_student($name . '#' . $codeadd, $user->ID);
				}
			}

			global $wpdb;
			$wpdb->insert('hs_players', array(
				'name' => $name,
				'pageid' => $pageid,
				'ign' => $ign,
				'username' => $tec_user,
				'grade' => $grade,
				'pronouns' => $pronouns,
				'codeentered' => $schoolcode
			));

			update_user_meta($user->ID, 'pageid', $pageid);
			update_user_meta($user->ID, 'ign', $ign);
			add_student_data($pageid, $games, $school);
			echo '[Success] Account created successfully. You are now signed in.';
		} else {
			echo '[Error] There was an error signing you in.';
		}
	}

	die();
}

add_action('wp_ajax_student_register', 'student_register');
add_action('wp_ajax_nopriv_student_register', 'student_register');

/**
 * Determines whether a student has registered to the database
 * @param	int	$id		The sportspress page id of the student to search for
 * @return	boolean
 */

function is_student_in_db($id) {
	global $wpdb;
	$sql = $wpdb->prepare("SELECT * FROM hs_players WHERE pageid = '$id';");
	$res = $wpdb->get_results($sql, ARRAY_A);
	return $wpdb->num_rows>0;
}

/**
 * Creates a student page, and adds 'owner' field to a player's sportspress page post meta
 * @param	string	$name	The name of the student
 * @param	string	$sid	The user id of the student (owner)
 * @return	int
 */

function create_student($name, $sid) {
	$id = createstudent($name);
	update_post_meta($id, 'owner', $sid);
	return $id;
}

/**
 * Creates a new sportspress page for a student
 * @param	string	$name	The name of the student
 * @return	int
 */

function createstudent($name) {
	$student_args = array(
		'post_status' => 'publish',
		'post_title' => ucwords($name),
		'post_author' => 1,
		'post_content' => '',
		'post_type' => 'sp_player'
	);
	return wp_insert_post($student_args);
}

/**
 * Adds sportspress information such as seasons and leagues to a student's sportspress page post meta
 * @param	int		$id		The of the student's sportspress page
 * @param	array	$games	The array of games that the student will be participating in
 * @param	string	$school	The name of the school that the student attends
 */

function add_student_data($id, $games, $school) {
	$season = get_season(season_num());
	$sp_leagues=array();
	for ($i = 0; $i < count($games); $i++) {
		$game = trim($games[$i]);
		$league = get_league_id($game);
		//sp_leagues
		$sp_leagues[strval($league)] = array(
			$season => $school
		);
		$teamid = pageexists(trim(get_the_title($school)) . ' - ' . $game, get_the_title($school) . ' – ' . $game);
		//sp_assignments
		$c_assign = $league . '_' . $season . '_' . $teamid;

		add_post_meta($id, 'sp_assignments', $c_assign);
		add_post_meta($id, 'sp_current_team', $teamid);
		add_post_meta($id, 'sp_team', $teamid);
		wp_set_post_terms($id, get_term($league, 'sp_league', ARRAY_A),'sp_league', true);

	}
	update_post_meta($id, 'sp_leagues', $sp_leagues);
	//sp_columns
	update_post_meta($id, 'sp_columns', allcols());
	wp_set_post_terms($id, array(), 'sp_position');
	wp_set_post_terms($id, get_term($season, 'sp_season', ARRAY_A),'sp_season', true);
}

/**
 * Adds the current season to a students's sportspress post meta
 * @param	string	$username	The name of the student
 */

function update_student($username) {
	$user = get_user_by($login);
}

/**
 * Gets the IGN of a student
 * @param	int	$id		The student's sportspress page id
 * @return	string
 */

function get_ign($id) {
	return get_post_meta($id, 'ign', true);
}

/**
 * Gets the captcha private key
 * @return	string
 */

function get_private_key() {
	return '6LdZjm4eAAAAANsiW0zHQedpRO8euafhVx8DHC66';
}

/**
 * Gets the school code of a team from the database
 * @param	string	$uid	The user id of the team manager
 * @return	string
 */

function find_schoolcode($uid) {
	global $wpdb;
	$res = $wpdb->get_results("SELECT code FROM `hs_staff` WHERE ID = '$uid';", ARRAY_A);
	if ($wpdb->num_rows > 0) {
		return $res[0]['code'];
	}
	return 0;
}

/**
 * AJAX function to add a student from the /ryan page
 */

function ryan_add_player() {
	if (strpos($_SERVER['HTTP_REFERER'], 'https://tecschoolesports.com')===false) { die();}

	//only ryan can create students this way
	$user = wp_get_current_user();
	if (!$user->ID || $user->user_login !== 'ryanl09') { echo '[Error] Invalid permissions.'; die(); }

	//make sure values are set
	if (!(isset($_POST['studentname']) && isset($_POST['studentign']) && isset($_POST['gamesel']) && isset($_POST['dsel']) && isset($_POST['schoolsel']))) { 
		echo '[Error] Fields are missing!'; die();
	}

	$exists=true;

	$name = ucwords(trim($_POST['studentname']));
	$ign = trim($_POST['studentign']);
	$game = trim($_POST['gamesel']);
	$div = trim($_POST['dsel']);
	$games = [$game . ' ' . $div];
	$school = trim($_POST['schoolsel']);

	$id = post_exists($name, '', '', 'sp_player');

	if (!$id) { //student does not exist
		$id = createstudent($name);
		$exists=false;
	}
	//add team to student
	add_student_data($id,$games,post_exists($school));

	//add post meta
	update_post_meta($id, 'ign', $ign);

	echo '[Success] Player ' . $exists ? 'existed' : 'created' . '. ID: ' . $id;

	die();
}

add_action('wp_ajax_ryan_add_player', 'ryan_add_player');
add_action('wp_ajax_nopriv_ryan_add_player', 'ryan_add_player');

/**
 * AJAX function to update a student's IGN post meta
 */

function update_player_ign() {

	if (strpos($_SERVER['HTTP_REFERER'], 'https://tecschoolesports.com')===false) { die();}

	//only ryan can create students this way
	$user = wp_get_current_user();
	if (!$user->ID || $user->user_login !== 'ryanl09') { echo '[Error] Invalid permissions.'; die(); }

	//make sure values are set
	if (!(isset($_POST['studentname']) && isset($_POST['studentign']))) { 
		echo '[Error] Fields are missing!'; die();
	}	

	$id = post_exists($name, '', '', 'sp_player');

	if ($id) {
		update_post_meta($id, 'ign', $ign);
		echo '[Success] IGN updated.';
		die();
	}

	echo '[Error] Player not found.';
	die();
}

add_action('wp_ajax_update_player_ign', 'update_player_ign');
add_action('wp_ajax_nopriv_update_player_ign', 'update_player_ign');

/**
 * Determines whether page a is a subteam page or not
 * @param	int	$id		The page id to check
 * @return	boolean
 */

function is_subteam($id) {
	return get_the_terms($id, 'sp_league');
}

?>