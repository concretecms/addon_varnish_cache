<? defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardVarnishServersController extends DashboardBaseController {
	// note can't extend settings because we might have an infinite redirect

	public function view() {
		Loader::model('varnish_servers','varnish_cache');
		$cache = PageCache::getLibrary();
		$this->cache = PageCache::getLibrary();
		$this->set("cache", $this->cache);
		$serverList = new VarnishServerList();
		$servers = $serverList->get();
		$this->set('servers',$servers);
	}

	public function invalid_settings() {
		$this->error->add(t('You must configure your Varnish server correctly first. Ensure that the server is running properly, that the management interface is running properly, and the proper information is entered in the form below.'));
		$this->view();
	}

	/*
	public function save() {

		$p = Package::getByHandle('varnish_cache');
		$p->saveConfig('VARNISH_CONTROL_TERMINAL_HOST', $this->post('VARNISH_CONTROL_TERMINAL_HOST'));
		$p->saveConfig('VARNISH_CONTROL_TERMINAL_PORT', $this->post('VARNISH_CONTROL_TERMINAL_PORT'));
		$p->saveConfig('VARNISH_CONTROL_TERMINAL_KEY', $this->post('VARNISH_CONTROL_TERMINAL_KEY'));		
		$p->saveConfig('VARNISH_VARNISHSTATS_PROXY_URL', $this->post('VARNISH_VARNISHSTATS_PROXY_URL'));
		$this->redirect('/dashboard/varnish/settings', 'saved');

	}
	*/

	public function delete($serverID,$token) {
		Loader::model('varnish_servers','varnish_cache');
		$valt = Loader::helper('validation/token');
		if($valt->validate('delete_varnish_server',$token)) {
				
			$server = VarnishServer::getByID($serverID);
			$server->Delete();
			
			$this->set('success',t('Server entry removed.'));
		} else {
			$this->error->add(t('Invalid token. Try again'));
		}
		$this->view();
	}

	public function saved() {
		$this->set('success', t('Varnish settings saved successfully.'));
		$this->view();
	}

}
