<?

// Contains talks
class Chat extends SessionSaveable implements SessionSaveableInterface {
	private $m_talks;
	private $m_talkers;
	const SESSION = 'chat';
	const LIMIT   = 100;

	public static function get_session_name() {
		return self::SESSION;
	}

	public function talker($sid) {
		$talker = NULL;
		foreach($this->talkers() as $t) {
			if($t->sid() === $sid) $talker = $t;
			if($talker) break;
		}
		return $talker;
	}

	private function talks_count() {
		return count($this->talks());
	}

	private function hasTalker($talker) {
		$has     = FALSE;
		$talkers = &$this->talkers();
		foreach($talkers as $t) {
			if($talker->sid() === $t->sid()) $has = TRUE;
			if($has) break;
		}
		return $has;
	}

	private function addTalker($talker) {
		if(!$this->hasTalker($talker)) array_push($this->talkers(),$talker);
	}

	public function say($text, $talker) {
		$this->addTalker($talker);
		$this->addTalk(Talk::now($text, $talker));
		$this->reduce();
	}

	public function &talks() {
		return $this->m_talks;
	}

	public function &talkers() {
		return $this->m_talkers;
	}

	private function addTalk(Talk $talk) {
		array_push($this->talks(), $talk);
	}

	private function reduce() {
		while($this->talks_count() > self::LIMIT)
			array_shift($this->talks());
	}

	private function init() {
		$this->m_talks   = array();
		$this->m_talkers = array();
	}

	public function __construct() {
		$this->init();
	}

}

