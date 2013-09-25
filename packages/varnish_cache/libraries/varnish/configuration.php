<? defined('C5_EXECUTE') or die(_("Access Denied."));

class VarnishConfiguration {

	protected static $configurationList = array();

	public function register($confName, $confDescription, $confHandle, $confFile) {
		$conf = new VarnishConfiguration();
		$conf->confFile = $confFile;
		$conf->confHandle = $confHandle;
		$conf->confName = $confName;
		$conf->confDescription = $confDescription;
		self::$configurationList[] = $conf;
	}

	public static function getList() {
		return self::$configurationList;
	}

	public function getVarnishConfigurationHandle() {return $this->confHandle;}
	public function getVarnishConfigurationFile() {return $this->confFile;}
	public function getVarnishConfigurationName() {return $this->confName;}
	public function getVarnishConfigurationDescription() {return $this->confDescription;}

	public static function getByHandle($handle) {
		$list = self::getList();
		foreach($list as $conf) {
			if ($conf->getVarnishConfigurationHandle() == $handle) {
				return $conf;
			}
		}
	}

	public function enable($server) {
		$socket = $server->getSocket();
		$socket->connect(1);
		try {
			@$socket->command('vcl.load ' . $this->confHandle . ' ' . $this->confFile, $code);
		} catch(Exception $e) {} // we don't care
		$socket->command('vcl.use ' . $this->confHandle, $code);
	}

	public function isVarnishConfigurationFileActive($server) {
		$socket = $server->getSocket();
		$socket->connect(1);
		$result = trim($socket->command('vcl.list', $code));
		$list = explode("\n", $result);
		foreach($list as $l) {
			$l = trim($l);
			if (strpos($l, $this->confHandle) > 0) {
				if (preg_match("/active/", $l)) {
					return true;
				}
			}
		}
	}
	
}
