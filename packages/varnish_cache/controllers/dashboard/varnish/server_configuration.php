<? defined('C5_EXECUTE') or die(_("Access Denied."));


class DashboardVarnishServerConfigurationController extends DashboardVarnishBaseController {

	public function view($serverID = NULL) {
		Loader::model('varnish_servers','varnish_cache');
		$server = VarnishServer::getByID($serverID);
		if(!$server) {
			$this->redirect('/dashboard/varnish/servers');
		}
		$configuration = VarnishConfiguration::getList();
		$this->set('configuration', $configuration);
		$this->set('server', $server);
	}

	public function configuration_switched($serverID) {
		$this->set('message', t("Varnish configuration updated."));
		$this->view($serverID);
	}
	
	public function save_configuration() {
		$serverID = $this->post('serverID');
		Loader::model('varnish_servers','varnish_cache');
		$server = VarnishServer::getByID($serverID);
		
		if(!$server) {
			$this->redirect('/dashboard/varnish/servers');
		}
		
		$confHandle = $this->post('configuration');

		try {
			$conf = VarnishConfiguration::getByHandle($confHandle);
			$conf->enable($server);
			
			$this->redirect('/dashboard/varnish/server_configuration', 'configuration_switched', $server->serverID);
		} catch(Exception $e) {
			$this->error->add($e->getMessage());
		}
		$this->view($server->serverID);

	}

}