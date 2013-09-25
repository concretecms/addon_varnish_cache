<?

defined('C5_EXECUTE') or die("Access Denied.");

class VarnishPageCache extends PageCache {

	//this needs to be changed to be per-server.
	//we can probably just pass in a serverID.
	public function getVarnishAdminSocket($server) {
		//Loader::model('varnish_servers','varnish_cache'); //server is just going to be an array here
		Loader::library('3rdparty/varnish_admin_socket', 'varnish_cache');
		//$server = VarnishServers::getByID($serverID);

		$s = new VarnishAdminSocket($server['ipAddress'],$server['port']);
		if ($server['terminalKey']) {
			$s->set_auth($server['terminalKey']);
		}
		return $s;
	}

	public function getRecord($mixed) {
		$ur = new UnknownPageCacheRecord();
		return $ur;
	}

	/*

	protected function getCacheFile($mixed) {
		$key = $this->getCacheKey($mixed);
		$filename = $key . '.cache';
		if ($key) {
			if (strlen($key) == 1) {
				$dir = DIR_FILES_PAGE_CACHE . '/' . $key;
			} else if (strlen($key) == 2) {
				$dir = DIR_FILES_PAGE_CACHE . '/' . $key[0] . '/' . $key[1];
			} else {
				$dir = DIR_FILES_PAGE_CACHE . '/' . $key[0] . '/' . $key[1] . '/' . $key[2];
			}
			if ($dir && (!is_dir($dir))) {
				mkdir($dir, DIRECTORY_PERMISSIONS_MODE, true);
			}
			$path = $dir . '/' . $filename;
			return $path;
		}
	}
	*/

	public function purgeByRecord(PageCacheRecord $rec) {
		/*
		$file = $this->getCacheFile($rec);
		if ($file && file_exists($file)) {
			unlink($file);
		}
		*/
	}

	public function flush() {
		$vas = $this->getVarnishAdminSocket();
		$vas->connect(1);
		$vas->purge_url('.');
	}

	//This is a weirder situation.
	//I guess you would get every instance of a varnish server and
	// request that purge for each server.
	public function purge(Page $c) {
		Loader::model('varnish_servers','varnish_cache');
		$servers = VarnishServers::get();
		foreach($servers as $server) {
			$vas = $this->getVarnishAdminSocket($server);
			$vas->connect(1);
			if (!$c->getCollectionPath()) {
				$path = '/';
			} else {
				$path = $c->getCollectionPath();
			}
			$vas->purge_url($path);
		}
	}

	public function set(Page $c, $content) {
		/*
		if (!is_dir(DIR_FILES_PAGE_CACHE)) {
			mkdir(DIR_FILES_PAGE_CACHE);
			touch(DIR_FILES_PAGE_CACHE . '/index.html');
		}

		$lifetime = $c->getCollectionFullPageCachingLifetimeValue();
		$file = $this->getCacheFile($c);
		if ($file) {
			$response = new PageCacheRecord($c, $content, $lifetime);
			if ($content) {
				file_put_contents($file, serialize($response));
			}
		}
		*/
	}


}
