<? defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardVarnishBaseController extends DashboardBaseController {

	public function on_start() {
		parent::on_start();
		if (PAGE_CACHE_LIBRARY != 'varnish') {
			throw new Exception('You must enable Varnish as your page caching library before you may continue.');
		}

		$cache = PageCache::getLibrary();
		$this->cache = PageCache::getLibrary();
		$this->set('cache', $cache);
	}

	
}