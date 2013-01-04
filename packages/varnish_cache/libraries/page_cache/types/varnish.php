<?

defined('C5_EXECUTE') or die("Access Denied.");

class VarnishPageCache extends PageCache {

	public function getVarnishAdminSocket() {
		Loader::library('3rdparty/varnish_admin_socket', 'varnish_cache');
		$p = Package::getByHandle('varnish_cache');
		$s = new VarnishAdminSocket($p->config('VARNISH_CONTROL_TERMINAL_HOST'), $p->config('VARNISH_CONTROL_TERMINAL_PORT'), VARNISH_CACHE_VERSION);
		if ($p->config('VARNISH_CONTROL_TERMINAL_KEY')) {
			$s->set_auth($p->config('VARNISH_CONTROL_TERMINAL_KEY'));
		}
		return $s;
	}

	public function getRecord($mixed) {
		/*
		$file = $this->getCacheFile($req);
		if (file_exists($file)) {
			$contents = file_get_contents($file);
			$record = @unserialize($contents);
			if ($record instanceof PageCacheRecord) {
				return $record;
			}
		}
		*/
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

	public function deleteByCacheRecord(PageCacheRecord $rec) {
		/*
		$file = $this->getCacheFile($rec);
		if ($file && file_exists($file)) {
			unlink($file);
		}
		*/
	}

	public function flush() {
		/*
		$fh = Loader::helper("file");
		$fh->removeAll(DIR_FILES_PAGE_CACHE);
		*/
	}

	public function delete(Page $c) {
		/*
		$file = $this->getCacheFile($c);
		if ($file && file_exists($file)) {
			unlink($file);
		}
		*/
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