<?
function clear_current_session() {
	session_destroy();
}

function clear_global_session() {
	start_global_context();
	session_destroy();
	end_global_context();
}

function drop () {
	if(ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 50000, 
				$params['path'], $params["domain"],
				$params["secure"], $params["httponly"]);
	}
	clear_current_session();
}

function start_global_context() {
	$global = 'GLOBAL';
	session_name($global);
	session_id('CHAT');
	session_start();
}

function end_global_context() {
	if('CHAT' == session_id()) {
		session_write_close();
	}
}

function start_default_context($sid) {
	if($sid !== FALSE) {
		$default = get_cfg_var('session.name');
		session_name($default);
		session_id($sid);
		session_start();
	}
}

function end_default_context() {
	if('CHAT' != session_id()) {
		$sid = session_id();
		session_write_close();
		return $sid;
	} else return FALSE;
}

// safe output
function so($str) { return htmlspecialchars($str); }
