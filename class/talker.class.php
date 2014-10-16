<?

class Talker extends SessionSaveable implements SessionSaveableInterface {

	private $m_nickname;
	private $m_sid;
	const SESSION = 'talker';

	public function sid() {
		return $this->m_sid;
	}

	public function setSid($sid) {
		$this->m_sid = $sid;
	}

	public static function get_session_name() {
		return self::SESSION;
	}

	public function setNickname($value) {
		$this->m_nickname = $value;
	}

	public function nickname() {
		return $this->m_nickname;
	}

}

