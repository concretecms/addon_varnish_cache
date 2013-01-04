<? defined('C5_EXECUTE') or die(_("Access Denied."));

class VarnishStatisticRecord {

	public function __construct($name, $value, $flag, $description) {
		$this->name = $name;
		$this->value = $value;
		$this->flag = $flag;
		$this->description = $description;
	}

	public function __toString() {
		return $this->value;
	}
	
}