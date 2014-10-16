<?

interface SessionSaveableInterface {
	public static function get_session_name();
}

class SessionSaveable {
	public function save() {
		$_SESSION[static::get_session_name()] = $this;
	}

	public static function load() {
		if(isset($_SESSION[static::get_session_name()])) {
			return $_SESSION[static::get_session_name()];
		} else {
			$o = new static();
			$_SESSION[static::get_session_name()] = $o;
			return static::load();
		}
	}
}

