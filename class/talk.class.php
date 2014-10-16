<?

class Talk {
	private $m_text;
	private $m_when;
	private $m_talker_sid;

	private function setTalkerSid($sid) {
		$this->m_talker_sid = $sid;
	}

	public function talker_sid() {
		return $this->m_talker_sid;
	}

	public function setText($value) {
		$this->m_text = $value;
	}

	public function text() {
		return $this->m_text;
	}

	public function setWhen($value) {
		$this->m_when = $value;
	}

	public function when() {
		return $this->m_when;
	}

	public static function now($text, Talker $talker) {
		$talk = new static();
		$talk->setText($text);
		$talk->setTalkerSid($talker->sid());
		$talk->setWhen(time());
		return $talk;
	}

}

