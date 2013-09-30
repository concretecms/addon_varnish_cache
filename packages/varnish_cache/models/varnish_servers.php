<?php defined('C5_EXECUTE') or die("Access Denied.");

class VarnishServerList extends DatabaseItemList {
		
	public function __construct() {
		$this->setQuery('select * from VarnishServers');
	}
	
	public function get($itemsToGet = 0, $offset = 0) {
		$servers = array();
		$rows = parent::get($itemsToGet, $offset);
		foreach($rows as $r) {
			$server = new VarnishServer();
			foreach($r as $k=>$v){
				$server->$k = $v;
			}
			$servers[] = $server;
		}
		return $servers;
	}
}

class VarnishServer extends Model {
	
	public $serverID;
	public $serverName;
	public $ipAddress;
	public $port;
	public $terminalKey;
	public $statsProxyURL;
	public $serverVersion;
	protected $socket;
	
	
	public $_table = 'VarnishServers';
	
	public function loadByID($id) {
		$db = Loader::db();
		parent::Load('serverID='.$db->quote($id));
	}
	
	public static function getByID($id) {
		$server = new self();
		$server->loadByID($id);
		if($server->serverID > 0) {
			return $server;
		}
		return false;
	}
	
	public function getSocket() {
		if($this->socket instanceof VarnishAdminSocket) {
			return $this->socket;
		} else {
			Loader::library('3rdparty/varnish_admin_socket', 'varnish_cache');
			$this->socket = new VarnishAdminSocket($this->ipAddress, $this->port, $this->serverVersion);
			if ($this->terminalKey) {
				$this->socket->set_auth($this->terminalKey);
			}
			return $this->socket;
		}	
	}
	
	/**
	 * Flushes all cache on server
	 * @return void
	 */
	public function flush() {
		$vas = $this->getSocket();
		$vas->connect(1);
		$vas->purge_url('.');
	}
	
	
	/**
	 * Flushes cache for a particular page path
	 * @return void
	*/
	public function purgeURL($url) {
		if(!strlen($url)) {
			$url = '/';
		}
		$vas = $this->getSocket();
		$vas->connect(1);
		$vas->purge_url($url);
	}
	

}
