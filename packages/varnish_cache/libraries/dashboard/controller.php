<? defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardVarnishBaseController extends DashboardBaseController {

	public function on_start() {
		parent::on_start();
		if (PAGE_CACHE_LIBRARY != 'varnish') {
			throw new Exception('You must enable Varnish as your page caching library before you may continue.');
		}

		Loader::model('varnish_servers','varnish_cache');
		$cache = PageCache::getLibrary();
		$this->cache = PageCache::getLibrary();
		$servers = VarnishServers::get();
		foreach($servers as $server) {
			$this->socket = $this->cache->getVarnishAdminSocket($server);
			try {
				@$this->socket->connect(1);
			} catch(Exception $e) {
				$this->redirect('/dashboard/varnish/settings', 'invalid_settings');
			}
		}

		$this->set('cache', $cache);
		$this->set('socket', $this->socket);
	}

	
}
